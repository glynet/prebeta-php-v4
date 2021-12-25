<?php
namespace Glynet\UserService;
use Glynet\Database\Database as db;

class UserOptions {
    public static function block(int $user_id, bool $mute = false): string
    {
        $type = "block";
        if ($mute)
            $type = "mute";

        $status = false;
        $author_id = (int)$GLOBALS['user']->id;
        $date = date("d.m.Y H:i:s");

        $control = db::select("user_options", "author_id='$author_id' && user_id='$user_id'");
        if (db::getCount($control) == 0) {
            $message = "added";
            db::insert("user_options", "author_id, user_id, type, date", "'$author_id', '$user_id', '$type', '$date'");
        } else {
            $data = db::fetch($control);
            db::delete("user_options", "author_id='$author_id' && user_id='$user_id'");

            if ($data->type == $type) {
                $message = "removed";
            } else {
                $message = "changed";
                db::insert("user_options", "author_id, user_id, type, date", "'$author_id', '$user_id', '$type', '$date'");
            }
        }

        return json_encode([
            'status' => $status,
            'message' => $message,
            'type' => $type
        ]);
    }

    public static function follow(int $id, int $token): string
    {
        $client = db::fetch(db::select("users", "token='$token'"));
        $control = db::select("takip", "takip1='$client->id' && takip2='$id'");
        $date = date("d.m.Y H:i:s");
        $follow = false;
        $verify = 0;

        db::delete("takip", "takip1='$client->id' && takip2='$id'");

        if (db::getCount($control) == 0 && $client->id != $id) {
            $follow = true;
            $privacy = db::fetch(db::select("privacy_preferences", "user_id='$id'"));

            if ($privacy->hide_profile != 'true')
                $verify = 1;

            db::insert("takip", "takip1, takip2, tarih, onay", "'$client->id', '$id', '$date', '$verify'");
        }

        return json_encode([
            'follow' => $follow,
            'date' => $date
        ]);
    }

    public static function removeFollower(int $id, int $token): string
    {
        $client = db::fetch(db::select("users", "token='$token'"));
        db::delete("takip", "takip1='$id' && takip2='$client->id'");

        return json_encode([
            'ok' => true
        ]);
    }
}