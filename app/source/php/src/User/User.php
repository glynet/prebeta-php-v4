<?php
namespace Glynet\UserService;
use Glynet\Database\Database as db;

class User {
    public static function query(string $type, string $id): string|bool|array
    {
        $token = $GLOBALS['token'];

        return match($type) {
            'followings' => self::getMetrics($id, 1, $token),
            'followers' => self::getMetrics($id, 2, $token),
            'follow' => UserOptions::follow($id, $token),
            'remove_follower' => UserOptions::removeFollower($id, $token),
            'block' => UserOptions::block($id),
            'mute' => UserOptions::block($id, true),
            'blocked_users' => self::getBlockedUsers($GLOBALS['user']->id, $id)
        };
    }

    public static function getData(string $user, string $token): array
    {
        $user_data = db::select("users", "username='$user'");
        $client = db::fetch(db::select("users", "token='$token'"));

        if (db::getCount($user_data) == 0) {
            return [
                'available' => false
            ];
        } else {
            $user_data = db::fetch($user_data);
            $followings = db::getCount(db::select("takip", "takip1='$user_data->id' && onay='1'"));
            $followers = db::getCount(db::select("takip", "takip2='$user_data->id' && onay='1'"));
            $posts_count = db::getCount(db::select("posts", "user_id='$user_data->id'"));
            $isFollowing = db::select("takip", "takip1='$client->id' && takip2='$user_data->id' && onay='1'");

            return [
                'available' => true,
                'id' => $user_data->id,
                'username' => stripslashes($user_data->username),
                'name' => stripslashes($user_data->name),
                'avatar' => $user_data->avatar,
                'email' => $user_data->email,
                'color' => $user_data->color,
                'isVerified' => $user_data->is_verified,
                'isMyProfile' => ($client->id == $user_data->id),
                'other' => [
                    'about' => stripslashes($user_data->about),
                    'jots' => number_format(($user_data->points == '' ? 200 : $user_data->points)),
                    'location' => $user_data->public_location,
                    'website' => $user_data->website,
                    'show_joined_date' => $user_data->show_joined_date == 'true',
                    'theme' => $user_data->theme,
                    'send_notifications' => $user_data->send_notifications == 'true',
                    'data_saving' => $user_data->data_saving,
                    'joined_at' => moment("$user_data->register_day.$user_data->register_month.$user_data->register_year", $client->language),
                    'metrics' => [
                        'followers' => $followers,
                        'followings' => $followings,
                        'posts' => $posts_count
                    ],
                    'region' => $user_data->region,
                    'language' => $user_data->language
                ],
                'banner' => [
                    'url' => $user_data->banner,
                    'type' => (in_array(pathinfo($user_data->banner, PATHINFO_EXTENSION), FILE_TYPES['video']) ? 'video' : 'image')
                ],
                'isFollowing' => !(db::getCount($isFollowing) == 0)
            ];
        }
    }

    public static function getMetrics(int $id, int $type, string $token): string
    {
        $client = db::fetch(db::select("users", "token='$token'"));

        function parseUser($c_id, $id): array
        {
            $data = db::fetch(db::select("users", "id='$id'"));
            $isFollowing = db::select("takip", "takip1='$c_id' && takip2='$id'");

            if ($data->id == null) {
                db::delete("takip", "takip1='$id'");
                db::delete("takip", "takip2='$id'");
            }

            return [
                'id' => (int)$data->id,
                'username' => $data->username,
                'name' => $data->name,
                'avatar' => $data->avatar,
                'isVerified' => !($data->is_verified == 0),
                'isFollowing' => !(db::getCount($isFollowing) == 0)
            ];
        }

        $users = db::select("takip", "takip$type='$id' && onay='1' ORDER BY id DESC LIMIT 70");
        $return = [];

        foreach (db::fetchAll($users) as $user)
            array_push($return, parseUser($client->id, $user->{'takip' . ($type == 1 ? 2 : 1)}));

        return json_encode($return);
    }

    public static function getBlockedUsers(int $id, string $type): string
    {
        if (in_array($type, ['block', 'mute'])) {
            $user_list = db::select("user_options", "author_id='$id' && type='$type' ORDER BY id DESC");
            $return = ['status' => true, 'users' => []];

            foreach (db::fetchAll($user_list) as $user) {
                $user_data = db::select("users", "id='$user->user_id'");

                if (db::getCount($user_data) !== 0) {
                    $user_data = db::fetch($user_data);

                    array_push($return['users'], [
                        'user' => [
                            'id' => (int)$user_data->id,
                            'name' => $user_data->name,
                            'username' => $user_data->username,
                            'avatar' => $user_data->avatar,
                        ],
                        'type' => $type,
                        'date' => $user->date
                    ]);
                } else {
                    db::delete("user_options", "id='$user->id'");
                }
            }
        } else {
            $return = ['status' => false];
        }

        return json_encode($return);
    }
}