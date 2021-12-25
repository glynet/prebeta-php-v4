<?php
namespace Glynet\ClientService;
use Glynet\Database\Database as db;

class Notifications {
    public static function get(int $id, string $lang = 'en'): bool|string
    {
        $data = db::select("notifications", "user='$id' ORDER BY id DESC LIMIT 30");
        $isClientPrivate = db::select("privacy", "user='$id'");
        $isClientPrivate = db::getCount($isClientPrivate) !== 0 && db::fetch($isClientPrivate)->profile == 'true';
        $return = [];

        foreach (db::fetchAll($data) as $row) {
            $json = json_decode($row->data);
            $from = db::fetch(db::select("users", "id='$json->user'"));
            $extend = [];
            $append = true;

            switch ($row->type) {
                case 'comment':
                    $comment = db::select("comments", "id='$json->id'");

                    if (db::getCount($comment) !== 0) {
                        $comment = db::fetch($comment);
                        $post = db::select("posts", "id='$comment->postid'");

                        if (db::getCount($post) !== 0) {
                            $post = db::fetch($post);

                            $extend = [
                                'comment' => [
                                    'id' => (int)$comment->id,
                                    'text' => htmlspecialchars_decode($comment->content)
                                ],
                                'post' => [
                                    'id' => (int)$post->id,
                                    'text' => htmlspecialchars_decode($post->text),
                                    'content' => [
                                        'url' => $post->content,
                                        'type' => in_array(pathinfo($post->content, PATHINFO_EXTENSION), FILE_TYPES['video']) ? 'video' : 'image',
                                    ]
                                ]
                            ];
                        } else {
                            $append = false;
                        }
                    } else {
                        $append = false;
                    }
                    break;
                case 'reply-comment':
                    $reply = db::select("comments_responses", "id='$json->reply'");

                    if (db::getCount($reply) !== 0) {
                        $reply = db::fetch($reply);
                        $comment = db::select("comments", "id='$reply->comment_id'");

                        if (db::getCount($comment) !== 0) {
                            $comment = db::fetch($comment);
                            $post = db::select("posts", "id='$comment->postid'");

                            if (db::getCount($post) !== 0) {
                                $comment_author = db::select("users", "id='$comment->userid'");

                                if (db::getCount($comment_author) !== 0) {
                                    $extend = [
                                        'post' => (int)$comment->postid,
                                        'comment' => [
                                            'id' => (int)$comment->id,
                                            'text' => htmlspecialchars_decode($comment->content)
                                        ],
                                        'reply' => [
                                            'id' => (int)$reply->id,
                                            'text' => htmlspecialchars_decode($reply->comment)
                                        ]
                                    ];
                                } else {
                                    // eğer yorum sahibi yoksa yorum comments tableından silinecek.
                                    $append = false;
                                }
                            } else {
                                // eğer gönderi yoksa silinecek
                                $append = false;
                            }
                        } else {
                            // eğer yorum yoksa comments tablosundan silinecek.
                            $append = false;
                        }
                    } else {
                        $append = false;
                    }
                    break;
                case 'new-post':
                case 'quote':
                case 'like':
                case 'mention':
                    $data = match ($json->type) {
                        'post' => db::select("posts", "id='$json->id'"),
                        'comment' => db::select("comments", "id='$json->id'"),
                        'reply' => db::select("comments_responses", "id='$json->id'"),
                        default => 'pass',
                    };

                    if ($data !== 'pass' && db::getCount($data) !== 0) {
                        $fetch = db::fetch($data);

                        $extend = [
                            'id' => (int)$fetch->id,
                            'type' => $json->type,
                            'details' => match ($json->type) {
                                'comment' => [ 'text' => $fetch->content ],
                                'reply' => [ 'text' => $fetch->comment ],
                                'post' => [
                                    'text' => $fetch->text,
                                    'content' => [
                                        'url' => $fetch->content,
                                        'type' => in_array(pathinfo($fetch->content, PATHINFO_EXTENSION), FILE_TYPES['video']) ? 'video' : 'image',
                                    ]
                                ],
                                default => ''
                            }
                        ];
                    } else {
                        $append = false;
                    }
                    break;
            }

            if (!($from->username === null) && $append) {
                array_push($return, [
                    'from' => [
                        'id' => (int)$from->id,
                        'name' => $from->name,
                        'username' => $from->username,
                        'avatar' => $from->avatar,
                        'isVerified' => (bool)$from->is_verified
                    ],
                    'details' => [
                        'type' => $row->type,
                        'date' => [
                            'raw' => $row->date,
                            'text' => moment($row->date, $lang)
                        ],
                        'extend' => $extend
                    ],
                    'isMarked' => (bool)$row->markAsRead
                ]);
            } else {
                db::delete("notifications", "id='$row->id'");
            }
        }

        return json_encode([
            'id' => $id,
            'isPrivate' => $isClientPrivate,
            'notifications' => $return
        ], true);
    }
}