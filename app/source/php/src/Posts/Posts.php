<?php
namespace Glynet\PostService;
use Glynet\Database\Database as db;
use Glynet\Viewer\UI as viewer;

// TODO
// Beğenildiğinde bildirim gönderilecek

class Posts {
    public static function query(string $type, string $query): string
    {
        switch ($type) {
            case 'save':
                return self::save($query, $GLOBALS['token']);
            case 'like':
                return self::like($query, $GLOBALS['token']);
            case 'delete':
                return self::delete($query, $GLOBALS['token']);
            case 'likes':
                return self::likes($query, $GLOBALS['token']);
            case 'remove_like':
                return self::removeLike(explode('-', $query)[0], explode('-', $query)[1], $GLOBALS['token']);
            default:
                $posts = self::load($type, $query, $GLOBALS['token']);
                return viewer::render('posts', [
                    'code' => $posts['status'],
                    'posts' => $posts['posts']
                ]);
        }
    }

    public static function load(string $type, string $data, string $client): array
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
                $sqlQuery = "user_id='$data'";

                $isPrivate = db::select("privacy_preferences", "user_id='$data'");
                if (db::getCount($isPrivate) == 0 || $user->id == $data) {
                    $list = true;
                } else {
                    $posts['status'] = 401600;
                    $isPrivate = db::fetch($isPrivate)->hide_profile == 'true';

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
                    $hPosts = db::select("hidden_post", "user_id='$user->id' {$lastData}ORDER BY id DESC");

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
                    $likes = db::select("likes", "user_id='$user->id' {$lastData}ORDER BY id DESC");

                    if (db::getCount($likes) !== 0) {
                        $likedPostIds = '';
                        foreach (db::fetchAll($likes) as $like) $likedPostIds .= "$like->postid,";
                        $sqlQuery = "id IN (" . rtrim($likedPostIds, ',') . ")";
                        $list = true;
                    }
                }
                break;

            case 'archive':
                $sqlQuery = "user_id='$user->id' AND isArchived='true'";
                $list = true;
                break;

            case 'homepage':
            case 'feed':
            default:
                if (!$isGuest) {
                    $followingsRequest = db::select("takip", "takip1='$user->id' && onay='1'");
                    $followings = $user->id;
                    foreach (db::fetchAll($followingsRequest) as $fUser) $followings .= ",$fUser->takip2";

                    $sqlQuery = "user_id IN ($followings) && isArchived <>'true'";
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
                    $postAuthor = db::select("users", "id='$post->user_id'");

                    if (db::getCount($postAuthor) !== 0) {
                        $postAuthor = db::fetch($postAuthor);

                        $likes = db::select("likes", "post_id='$post->id'");
                        $comments = db::select("posts", "parent_post='$post->id'");

                        $isLiked = !(db::getCount(db::select("likes", "user_id='$user->id' && post_id='$post->id'")) == 0);
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
                                'isVerified' => (bool)$postAuthor->is_verified,
                                'isMyProfile' => ($user->id == $postAuthor->id)
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

    public static function delete(int $id, int $token): string|bool
    {
        $success = false;
        $user = db::select("users", "token='$token'");

        if (db::getCount($user) !== 0) {
            $post = db::select("posts", "id='$id'");

            if (db::getCount($post) !== 0) {
                $user_data = db::fetch($user);
                $post_data = db::fetch($post);

                if ($post_data->user_id == $user_data->id) {
                    $delete = db::delete("posts", "id='$id' && user_id='$user_data->id'");

                    if ($delete)
                        $success = true;
                }
            }
        }

        return json_encode([
            'success' => $success
        ]);
    }

    public static function likes(int $post_id, int $token): string|bool
    {
        $available = false;
        $continue = true;
        $isAuthor = false;

        $likes = db::select("likes", "post_id='$post_id' LIMIT 50");
        $return_data = [];

        if (db::getCount($likes) !== 0) {
            $post_author = db::fetch(db::select("posts", "id='$post_id'"));
            $author_privacy = db::select("privacy_preferences", "user_id='$post_author->user_id'");
            $client = db::fetch(db::select("users", "token='$token'"));

            if ($client->id == $post_author->user_id) {
                $isAuthor = true;
            } else {
                if (db::getCount($author_privacy) !== 0) {
                    $privacy_settings = db::fetch($author_privacy);

                    if ($privacy_settings->hide_profile == 'true') {
                        $isFollowing = db::select("takip", "takip1='$client->id' && takip2='$post_author->user_id' && onay='1'");

                        if (db::getCount($isFollowing) == 0) {
                            $continue = false;
                        }
                    }
                }
            }

            if ($continue) {
                foreach (db::fetchAll($likes) as $like) {
                    $user = db::select("users", "id='$like->user_id'");
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
                                'isVerified' => (bool)$user->is_verified
                            ]
                        ]);
                    } else {
                        db::delete("likes", "user_id='$like->user_id'");
                    }
                }
            }
        }

        return json_encode([
            'isAuthor' => $isAuthor,
            'available' => $available,
            'data' => $return_data
        ]);
    }

    public static function removeLike(int $post_id, int $user_id, int $token): string|bool
    {
        $success = false;
        $post = db::select("posts", "id='$post_id'");

        if (db::getCount($post) !== 0) {
            $post = db::fetch($post);
            $client = db::select("users", "token='$token'");

            if (db::getCount($client) !== 0) {
                $client = db::fetch($client);

                if ($post->user_id == $client->id) {
                    $success = true;
                    db::delete("likes", "user_id='$user_id' && post_id='$post_id'");
                }
            }
        }

        return json_encode([
            'success' => $success
        ]);
    }

    public static function like(int $post_id, int $token): string|bool
    {
        $user = db::fetch(db::select("users", "token='$token'"));
        $control = db::select("likes", "post_id='$post_id' && user_id='$user->id'");
        $like = false;

        db::delete("likes", "post_id='$post_id' && user_id='$user->id'");

        if (db::getCount($control) == 0) {
            $like = true;
            db::insert("likes", "user_id, post_id, day, month, year", "'$user->id', '$post_id', '" . date("d") . "', '" . date("m") . "', '" . date("Y") . "'");
        }

        return json_encode([
            'like' => $like,
            'post' => $post_id
        ]);
    }

    public static function save(int $post_id, int $token): string|bool
    {
        $user = db::fetch(db::select("users", "token='$token'"));
        $control = db::select("bookmarks", "post='$post_id' && user='$user->id'");
        $save = false;

        db::delete("bookmarks", "post='$post_id' && user='$user->id'");

        if (db::getCount($control) == 0) {
            $save = true;
            db::insert("bookmarks", "user, post, date", "'$user->id', '$post_id', '" . date("d.m.Y H:i:s") . "'");
        }

        return json_encode([
            'save' => $save,
            'post' => $post_id
        ]);
    }
}