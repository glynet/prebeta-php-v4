<?php
namespace Glynet\Profile;
use Glynet\Database\Database as db;
use JetBrains\PhpStorm\ArrayShape;

class Profile {
    public static function getData(string $user, string $token): array
    {
        $user_data = db::select("users", "username='$user'");
        $client = db::fetch(db::select("users", "token='$token'"));

        if (db::getCount($user_data) == 0) {
            return [ 'available' => false ];
        } else {
            $user_data = db::fetch($user_data);
            $followings = db::getCount(db::select("takip", "takip1='$user_data->id' && onay='1'"));
            $followers = db::getCount(db::select("takip", "takip2='$user_data->id' && onay='1'"));
            $posts_count = db::getCount(db::select("posts", "userid='$user_data->id'"));
            $isFollowing = db::select("takip", "takip1='$client->id' && takip2='$user_data->id' && onay='1'");

            return [
                'available' => true,
                'id' => $user_data->id,
                'username' => stripslashes($user_data->username),
                'name' => stripslashes($user_data->name),
                'avatar' => $user_data->avatar,
                'color' => $user_data->color,
                'isVerified' => $user_data->isVerified,
                'isMyProfile' => ($client->id == $user_data->id),
                'other' => [
                    'bio' => stripslashes($user_data->bio),
                    'jots' => number_format(($user_data->points == '' ? 200 : $user_data->points)),
                    'location' => $user_data->publicLocation,
                    'website' => $user_data->website,
                    "joined_at" => moment("$user_data->register_day.$user_data->register_month.$user_data->register_year", $client->language),
                    'metrics' => [
                        'followers' => $followers,
                        'followings' => $followings,
                        'posts' => $posts_count
                    ]
                ],
                'banner' => [
                    'url' => $user_data->banner,
                    'type' => (in_array(pathinfo($user_data->banner, PATHINFO_EXTENSION), FILE_TYPES['video']) ? 'video' : 'image')
                ],
                'isFollowing' => !(db::getCount($isFollowing) == 0)
            ];
        }
    }

    public static function getMetrics(int $id, int $type, string $token): array
    {
        $client = db::fetch(db::select("users", "token='$token'"));

        #[ArrayShape(['id' => "int", 'username' => "mixed", 'name' => "mixed", 'avatar' => "mixed", 'isVerified' => "bool", 'isFollowing' => "bool"])]
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
                'isVerified' => !($data->isVerified == 0),
                'isFollowing' => !(db::getCount($isFollowing) == 0)
            ];
        }

        $users = db::select("takip", "takip$type='$id' && onay='1' ORDER BY id DESC LIMIT 70");
        $return = [];

        foreach (db::fetchAll($users) as $user) array_push($return, parseUser($client->id, $user->{'takip' . ($type == 1 ? 2 : 1)}));
        return $return;
    }

    #[ArrayShape(['follow' => "bool", 'date' => "string"])]
    public static function follow($id, $token): array
    {
        $client = db::fetch(db::select("users", "token='$token'"));
        $control = db::select("takip", "takip1='$client->id' && takip2='$id'");
        $date = date("d.m.Y H:i:s");
        $follow = false;
        $verify = 0;

        db::delete("takip", "takip1='$client->id' && takip2='$id'");

        if (db::getCount($control) == 0 && $client->id != $id) {
            $follow = true;
            $privacy = db::fetch(db::select("privacy", "user='$id'"));

            if ($privacy->profile != 'true')
                $verify = 1;

            db::insert("takip", "takip1, takip2, tarih, onay", "'$client->id', '$id', '$date', '$verify'");
        }

        return ['follow' => $follow, 'date' => $date];
    }

    #[ArrayShape(['ok' => "bool"])]
    public static function remove($id, $token): array
    {
        $client = db::fetch(db::select("users", "token='$token'"));
        db::delete("takip", "takip1='$id' && takip2='$client->id'");
        return ['ok' => true];
    }
}