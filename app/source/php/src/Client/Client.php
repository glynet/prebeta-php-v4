<?php
namespace Glynet\ClientService;
use Glynet\Database\Database as db;
use JetBrains\PhpStorm\ArrayShape;

class Client {
    public static string|null $token;
    public static object $data;

    public static function setToken(string|null $token): string|null
    {
        return self::$token = $token;
    }

    public static function collectData(): object|array
    {
        $token = self::$token;
        $select = db::select("users", "token='$token'");

        if (db::getCount($select) !== 0) {
            return
                self::$data =
                    db::fetch($select);
        } else {
            return [
                'login' => false
            ];
        }
    }

    public static function sessionControl(): void
    {
        $ip = "31.6.90.0";
        $user_id = self::$data->id;

        $os = getOS();
        $browser = getBrowser();

        $ip_api =
            json_decode(
                file_get_contents("https://pro.ip-api.com/json/$ip?fields=66842623&key=uGZgjL0qOTI19n4"));

        $location = "$ip_api->city, $ip_api->regionName";
        $timezone = $ip_api->timezone;

        $date = date("d.m.Y H:i:s");

        $db_control = db::select("login_activity", "user_id='$user_id' && ip_address='$ip' ORDER BY id DESC");
        db::update("users", "id='$user_id'", "ip='$ip', location='$location'");

        if (db::getCount($db_control) !== 0) {
            $last_data = db::fetch($db_control);

            if ($last_data->os !== $os) {
                $db_insert = true;
            } else {
                $db_insert = false;
                db::update("login_activity", "id='{$last_data->id}'", "browser='$browser', os='$os', date='$date'");
            }
        } else {
            $db_insert = true;
        }

        if ($db_insert == true)
            db::insert("login_activity", "id, user_id, ip_address, browser, os, location, timezone, date", "NULL, '$user_id', '$ip', '$browser', '$os', '$location', '$timezone', '$date'");
    }

    public static function lastSessions(): array
    {
        $user_id = self::$data->id;
        $get = db::select("login_activity", "user_id='$user_id' ORDER BY id DESC LIMIT 20");
        $return = [];
        $i = 0;

        foreach (db::fetchAll($get) as $item) {
            $icon = match (explode(' ', $item->os)[0]) {
                'Mac', 'iPhone' => 'static/assets/images/os/apple.png',
                'Windows' => 'static/assets/images/os/windows.png',
                'Android' => 'static/assets/images/os/android.png',
                'Chrome' => 'static/assets/images/os/chrome.png',
                'Linux' => 'static/assets/images/os/linux.png',
                'Ubuntu' => 'static/assets/images/os/ubuntu.png',
                default => 'static/assets/images/os/unknown.png'
            };

            array_push($return, [
                'icon' => $icon,
                'device' => $item->os,
                'location' => $item->location,
                'browser' => $item->browser,
                'ip_address' => $item->ip_address,
                'current_session' => $i == 0,
                'date' => moment($item->date, self::$data->language)
            ]);

            $i++;
        }

        return $return;
    }

    public static function getRank(int|string $myPoints = 200): string|bool
    {
        if ($myPoints == "")
            $myPoints = 200;

        $calcStart = 190;
        $calcEnd = 230;
        $calcInc = 0;
        $calcLevel = 6;

        $myStart = 0;
        $myEnd = 0;

        $myLevel = 0;
        $calcCount = 0;

        do {
            $calcCount = $calcCount + 1;

            if ($calcCount % 2 == 0 )
                $calcInc = $calcInc + $calcLevel;

            if (($myPoints < $calcEnd) && ($myPoints >= $calcStart)) {
                $myLevel = $calcCount;
                $myStart = $calcStart;
                $myEnd = $calcEnd;
            }

            $calcStart = $calcEnd;
            $calcEnd = $calcEnd + $calcInc;
        } while ($myLevel == 0);
        $myLevel--;

        $myPercent = (($myPoints - $myStart) / ($myEnd - $myStart)) * 100;
        $myPercent = round($myPercent);

        if ($myPercent == 0)
            $myPercent = 1;

        if ($myLevel == 0)
            $myLevel = 1;

        return json_encode([
            'percent' => $myPercent,
            'level' => $myLevel
        ]);
    }

    public static function privacyPreferences(): array
    {
        $user_id = self::$data->id;
        $query = db::select("privacy_preferences", "user_id='$user_id'");
        $fetch = null;

        if (db::getCount($query) !== 0)
            $fetch = db::fetch($query);

        return [
            'available' => $fetch !== null,
            'details' => $fetch
        ];
    }
}