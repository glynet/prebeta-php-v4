<?php
namespace Glynet\Suggestions;
use Glynet\Database\Database as db;
use JetBrains\PhpStorm\ArrayShape;

class Contacts {
    public static function collect(string $token): array
    {
        $client = db::fetch(db::select("users", "token='$token'"));
        $list = [];
        $list_participants = [];

        // Closest users start
        $client_location = mb_strtolower(explode(', ', $client->location)[0]);
        $closest_users = db::select("users", "location LIKE '%$client_location%' ORDER BY RAND() LIMIT 0,6");
        foreach (db::fetchAll($closest_users) as $cl) {
            if (!in_array($cl->id, $list_participants)) {
                array_push($list_participants, $cl->id);

                $isFollowing = db::select("takip", "takip1='$client->id' && takip2='$cl->id' && onay='1'");
                if (db::getCount($isFollowing) == 0) {
                    array_push($list, self::parseData($cl));
                }
            }
        }
        // Closest users end

        /*
        // Audit log users start
        $auditlog_users = db::select("auditlog", "user='$client->id' && activity='profile' ORDER BY id DESC LIMIT 0,6");
        foreach (db::fetchAll($auditlog_users) as $al) {
            $alUserID = json_decode($al->data_json)->id;

            if (!in_array($alUserID, $list_participants)) {
                array_push($list_participants, $alUserID);

                $isFollowing = db::select("takip", "takip1='$client->id' && takip2='$al->id' && onay='1'");
                if (db::getCount($isFollowing) == 0) {
                    $al_user = db::select("users", "id='$alUserID'");

                    if (db::getCount($al_user) !== 0) {
                        $al_user = db::fetch($al_user);
                        array_push($list, self::parseData($al_user));
                    }
                }
            }
        }
        // Audit log users end
        */

        return $list;
    }

    #[ArrayShape(['id' => "", 'name' => "", 'username' => "", 'avatar' => "", 'isVerified' => "bool"])]
    public static function parseData($data): array
    {
        return [
            'id' => $data->id,
            'name' => $data->name,
            'username' => $data->username,
            'avatar' => $data->avatar,
            'isVerified' => boolval($data->is_verified)
        ];
    }
}

class Search
{
    public static function query(string $text): string|bool
    {
        $users = db::select("users", "username LIKE '%" . $text . "%' || name LIKE '%" . $text . "%' LIMIT 4");
        $hashtags = db::select("trending_hashtags", "name LIKE '%" . $text . "' LIMIT 4");
        $locations = db::select("posts", "location LIKE '%" . $text . "%' LIMIT 4");

        $return = [];
        $hastag_list = [];
        $location_list = [];

        foreach (db::fetchAll($users) as $user) {
            array_push($return, [
                'type' => 'user',
                'details' => [
                    'title' => $user->name,
                    'username' => $user->username,
                    'avatar' => $user->avatar
                ]
            ]);
        }

        foreach (db::fetchAll($hashtags) as $hashtag) {
            if (!in_array($hashtag->name, $hastag_list) && trim($hashtag->name) !== '') {
                array_push($return, [
                    'type' => 'hashtag',
                    'details' => [
                        'title' => $hashtag->name
                    ]
                ]);

                array_push($hastag_list, $hashtag->name);
            }
        }

        foreach (db::fetchAll($locations) as $location) {
            if (!in_array($location->location, $location_list) && trim($location->location) !== '') {
                array_push($return, [
                    'type' => 'location',
                    'details' => [
                        'title' => $location->location
                    ]
                ]);

                array_push($location_list, $location->location);
            }
        }

        return json_encode($return);
    }
}

class Trends
{
    public static int $position = 1;

    #[ArrayShape(['trends' => "array", 'count' => "int"])]
    public static function getTopics(string $location = 'tr'): array
    {
        $data = self::parseData(
            self::collectData($location)
        );

        return [ 'trends' => $data, 'count' => count($data) ];
    }

    public static function collectData(string $location): array
    {
        $today = '03.03.2021';
        $hashtags = db::select("trending_hashtags", "location='$location' && date LIKE '%$today%'");
        $tags = [];
        $tags_count = [];

        foreach (db::fetchAll($hashtags) as $tag) {
            $tags_count[$tag->name]++;

            $tags[$tag->name] = [
                'name' => $tag->name,
                'count' => $tags_count[$tag->name],
                'type' => rand(1,2)
            ];
        }

        return $tags;
    }

    public static function parseData(array $data): array
    {
        $final = [];
        $i = 0;

        foreach ($data as $key => $row) $most_desc[$key] = $row['count'];
        array_multisort($most_desc, SORT_DESC);

        foreach ($most_desc as $key => $value) {
            switch ($i) {
                case 0:
                    $desc = 'Herkes bu konuyu aratıyor';
                    if ($data[$key]['type'] == 1) $desc = 'Herkes bu konuyu tartışıyor';
                    break;

                default:
                    $desc = str_replace('{c}', $data[$key]['count'], '{c} kişi bu konuyu aratıyor');
                    if ($data[$key]['type'] == 1) $desc = str_replace('{c}', $data[$key]['count'], '{c} kişi bu konu hakkında paylaşım yaptı');
                    break;
            }

            array_push($final, self::appendTopic($data[$key]['type'], $data[$key]['name'], $desc));
            $i++;
        }

        return $final;
    }

    #[ArrayShape(['icon' => "int", 'title' => "string", 'description' => "string", 'position' => "int"])]
    public static function appendTopic(int $type, string $title, string $description): array
    {
        return [
            'icon' => $type,
            'title' => $title,
            'description' => $description,
            'position' => self::$position++
        ];
    }
}