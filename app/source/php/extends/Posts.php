<?php
namespace Glynet\PostService;
use Glynet\Database\Database as db;
use JetBrains\PhpStorm\ArrayShape;

// TODO
// Beğenildiğinde bildirim gönderilecek

class Posts {
    public static function load($type, $data, $client): array
    {
        if (trim($client) == '') {
            $user = (object)[
                'id' => 0,
                'available' => false
            ];
        } else {
            $user = db::fetch(db::select("users", "token='$client'"));
        }

        $isGuest = false;
        $list = false;
        $shuffle = false;
        $order = 'ORDER BY id DESC';
        $lastData = '';
        $sqlQuery = '';
        $lastPost = '';

        switch ($type) {
            case 'profile':
                $sqlQuery = "userid='$data'";
                
                $isPrivate = db::select("privacy", "user='$data'");
                if (db::getCount($isPrivate) == 0 || $user->id == $data) {
                    $list = true;
                } else {
                    $posts['status'] = 401600;
                    $isPrivate = db::fetch($isPrivate)->profile == 'true';

                    if ($isPrivate) {
                        if (!$isGuest) {
                            $followingControl = db::select("takip", "takip1='$user->id' && takip2='$data' && onay='1'");
                            if (db::getCount($followingControl) !== 0) $list = true;
                        }
                    } else {
                        $list = true;
                    }
                }
                break;
    
            case 'search':
                $sqlQuery = "text LIKE '%$data%' && location LIKE '%$data%'";
                $list = true;
                break;
    
            case 'bookmarks':
                if (!$isGuest) {
                    if ($lastPost !== '') $lastData = "&& post < $lastPost ";
                    $bookmarks = db::select("bookmarks", "user='$user->id' {$lastData}ORDER BY id DESC");
                    if (db::getCount($bookmarks) == 0) {
                        $posts['status'] = 401602; 
                    } else {
                        $bookmarkIds = '';
                        foreach (db::fetchAll($bookmarks) as $bookmark) $bookmarkIds .= "$bookmark->post,";
                        $sqlQuery = "id IN (" . rtrim($bookmarkIds, ',') . ")";
                        $list = true;
                    }
                } else {
                    $posts['status'] = 401601;
                }
                break;
            
            case 'location':
                $sqlQuery = "location LIKE '%$data%'";
                $list = true;
                break;
    
            case 'hashtag':
                $sqlQuery = "text LIKE '%#$data%'";
                $list = true;
                break;
    
            case 'explore':
            case 'feed-explore':
                $sqlQuery = "explore_access='1'";
                $list = true;
                break;
                
            case 'hiddenPosts':
                $posts['status'] = 401613;
    
                if (!$isGuest) {
                    if ($lastPost !== '') $lastData = "&& postid < $lastPost ";
                    $hPosts = db::select("hidden_post", "userid='$user->id' {$lastData}ORDER BY id DESC");
    
                    if (db::getCount($hPosts) !== 0) {
                        $hiddenPostIds = '';
                        foreach (db::fetchAll($hPosts) as $hPost) $hiddenPostIds .= "$hPost->postid,";
                        $sqlQuery = "id IN (" . rtrim($hiddenPostIds, ',') . ")";
                        $list = true;
                    }
                }
                break;
    
            case 'likes':
                $posts['status'] = 401606;
    
                if (!$isGuest) {
                    if ($lastPost !== '') $lastData = "&& postid < $lastPost ";
                    $likes = db::select("likes", "userid='$user->id' {$lastData}ORDER BY id DESC");
                    
                    if (db::getCount($likes) !== 0) {
                        $likedPostIds = '';
                        foreach (db::fetchAll($likes) as $like) $likedPostIds .= "$like->postid,";
                        $sqlQuery = "id IN (" . rtrim($likedPostIds, ',') . ")";
                        $list = true;
                    }
                }
                break;
                
            case 'archive':
                $sqlQuery = "userid='$user->id' AND isArchived='true'";
                $list = true;
                break;
    
            case 'homepage':
            case 'feed':
            default:
                if (!$isGuest) {
                    $followingsRequest = db::select("takip", "takip1='$user->id' && onay='1'");
                    $followings = $user->id;
                    foreach (db::fetchAll($followingsRequest) as $fUser) $followings .= ",$fUser->takip2";
    
                    $sqlQuery = "userid IN ($followings) && isArchived <>'true'";
                    $list = true;
                    $shuffle = true;
                }
                break;
        }

        $posts['list'] = $list;
        $posts['me'] = [ 'id' => $user->id ];
        
        $limit = 14;

        if ($list) {
            $posts['status'] = 400009;
            
            if ($type == 'search')
                $posts['status'] = 401999;
    
            $posts['count'] = 0;
            $select = db::select("posts", "$sqlQuery " . ($lastPost !== '' ? "&& id < $lastPost " : "") . "$order LIMIT $limit");
            
            if (db::getCount($select) !== 0) {
                $posts['status'] = 400000;
    
                $i = 0;
                foreach (db::fetchAll($select) as $post) {
                    $postAuthor = db::select("users", "id='$post->userid'");
    
                    if (db::getCount($postAuthor) !== 0) {
                        $postAuthor = db::fetch($postAuthor);
    
                        $likes = db::select("likes", "postid='$post->id'");
                        $comments = db::select("posts", "parent_post='$post->id'");
                        
                        $isLiked = !(db::getCount(db::select("likes", "userid='$user->id' && postid='$post->id'")) == 0);
                        $isSaved = db::getCount(db::select("bookmarks", "post='$post->id' && user='$user->id'"));

                        $posts['posts'][$i] = [
                            'id' => $post->id,
                            'public' => $post->public_id,
                            'isArchived' => $post->isArchived == 'true',
                            'type' => ($post->content == '' ? 'text' : (in_array(pathinfo($post->content, PATHINFO_EXTENSION), FILE_TYPES['video']) ? 'video' : 'image')),
                            'author' => [
                                'id' => $postAuthor->id,
                                'name' => $postAuthor->name,
                                'username' => $postAuthor->username,
                                'avatar' => $postAuthor->avatar,
                                'isVerified' => (bool)$postAuthor->isVerified
                            ],
                            'post' => [
                                'text' => [
                                    'raw' => nl2br($post->text),
                                    'html' => [nl2br($post->text),nl2br(str_replace("{/quotes}", "'", $post->text))]
                                ],
                                'content' => [
                                    'url' => $post->content,
                                    'type' => (in_array(pathinfo($post->content, PATHINFO_EXTENSION), FILE_TYPES['video']) ? 'video' : 'image')
                                ],
                                'location' => $post->location,
                                'date' => [
                                    'text' => moment("$post->publish_day.$post->publish_month.$post->publish_year $post->publish_time", $user->language),
                                    'raw' => "$post->publish_day.$post->publish_month.$post->publish_year $post->publish_time"
                                ]
                            ],
                            'details' => [
                                'isNSFW' => $post->nsfw,
                                'edited' => $post->edited,
                                'filter' => $post->filter
                            ],
                            'likes' => [
                                'isLiked' => $isLiked,
                                'count' => db::getCount($likes)
                            ],
                            'bookmarks' => [
                                'isSaved' => !($isSaved == 0)
                            ],
                            'comments' => [
                                'count' => db::getCount($comments)
                            ],
                            'buttons' => [
                                'report' => true,
                                'copyLink' => true,
                                'delete' => ($postAuthor->id == $user->id)
                            ]
                        ];
    
                        $i++;
                    }
                }

                if ($shuffle)
                    shuffle($posts['posts']);
    
                $posts['count'] = $i;
            }
        }

        return $posts;
    }

    #[ArrayShape(['success' => "bool"])]
    public static function delete($id, $token): array
    {
        $success = false;
        $user = db::select("users", "token='$token'");

        if (db::getCount($user) !== 0) {
            $post = db::select("posts", "id='$id'");
            
            if (db::getCount($post) !== 0) {
                $user_data = db::fetch($user);
                $post_data = db::fetch($post);
                
                if ($post_data->userid == $user_data->id) {
                    $delete = db::delete("posts", "id='$id' && userid='$user_data->id'");
                    
                    if ($delete) {
                        $success = true;
                    }
                }
            }
        }

        return [ 'success' => $success ];
    }

    #[ArrayShape(['isAuthor' => "bool", 'available' => "bool", 'data' => "array"])]
    public static function likes($post_id, $token): array
    {
        $available = false;
        $continue = true;
        $isAuthor = false;
        $return_data = [];
        $likes = db::select("likes", "postid='$post_id' LIMIT 50");
        
        if (db::getCount($likes) !== 0) {
            $post_author = db::fetch(db::select("posts", "id='$post_id'"));
            $author_privacy = db::select("privacy", "user='$post_author->userid'");
            $client = db::fetch(db::select("users", "token='$token'"));

            if ($client->id == $post_author->userid) {
                $isAuthor = true;
            } else {        
                if (db::getCount($author_privacy) !== 0) {
                    $privacy_settings = db::fetch($author_privacy);

                    if ($privacy_settings->profile == 'true') {
                        $isFollowing = db::select("takip", "takip1='$client->id' && takip2='$post_author->userid' && onay='1'");
                            
                        if (db::getCount($isFollowing) == 0) {
                            $continue = false;
                        }
                    }
                }
            }

            if ($continue) {
                foreach (db::fetchAll($likes) as $like) {
                    $user = db::select("users", "id='$like->userid'");
                    $available = true;

                    if (db::getCount($user) !== 0) {
                        $user = db::fetch($user);

                        array_push($return_data, [
                            'id' => $like->id,
                            'user' => [
                                'id' => $user->id,
                                'username' => $user->username,
                                'name' => $user->name,
                                'avatar' => $user->avatar,
                                'isVerified' => (bool)$user->isVerified
                            ]
                        ]);
                    } else {
                        db::delete("likes", "userid='$like->userid'");
                    }
                }
            }
        }
        
        return [ 'isAuthor' => $isAuthor, 'available' => $available, 'data' => $return_data ];
    }

    #[ArrayShape(['success' => "bool"])]
    public static function removeLike($post_id, $user_id, $token): array
    {
        $success = false;
        $post = db::select("posts", "id='$post_id'");

        if (db::getCount($post) !== 0) {
            $post = db::fetch($post); 
            $client = db::select("users", "token='$token'");

            if (db::getCount($client) !== 0) {
                $client = db::fetch($client);
        
                if ($post->userid == $client->id) {
                    $success = true;
                    db::delete("likes", "userid='$user_id' && postid='$post_id'");
                }
            }
        }

        return [ 'success' => $success ];
    }

    #[ArrayShape(['like' => "bool", 'post' => "int"])]
    public static function like($post_id, $token): array
    {
        $user = db::fetch(db::select("users", "token='$token'"));
        $control = db::select("likes", "postid='$post_id' && userid='$user->id'");
        $like = false;

        db::delete("likes", "postid='$post_id' && userid='$user->id'");

        if (db::getCount($control) == 0) {
            $like = true;
            db::insert("likes", "userid, postid, day, month, year", "'$user->id', '$post_id', '" . date("d") . "', '" . date("m") . "', '" . date("Y") . "'");
        }

        return ['like' => $like, 'post' => (int)$post_id];
    }

    #[ArrayShape(['save' => "bool", 'post' => "int"])]
    public static function save($post_id, $token): array
    {
        $user = db::fetch(db::select("users", "token='$token'"));
        $control = db::select("bookmarks", "post='$post_id' && user='$user->id'");
        $save = false;

        db::delete("bookmarks", "post='$post_id' && user='$user->id'");

        if (db::getCount($control) == 0) {
            $save = true;
            db::insert("bookmarks", "user, post, date", "'$user->id', '$post_id', '" . date("d.m.Y H:i:s") . "'");
        }

        return ['save' => $save, 'post' => (int)$post_id];
    }
}