<?php
namespace Glynet\ClientService;
use Glynet\Database\Database as db;
use JetBrains\PhpStorm\ArrayShape;

class ClientUpdate {
    public static function newToken(): int
    {
        $token = Client::$token;
        $new_token = tokenGenerator(16);

        db::update("users", "token='$token'", "token='$new_token'");

        Client::$token = $new_token;
        Client::$data->token = $new_token;
        $GLOBALS['user']->token = $new_token;
        setcookie("token", $new_token, time()+3600, "/");

        return (int)$new_token;
    }

    public static function setColor(string $code): string|bool
    {
        $token = Client::$token;

        if (in_array($_GET['code'], AVAILABLE_COLORS))
            db::update("users", "token='$token'", "color='$code'");

        return json_encode([
            'color' => $code
        ]);
    }

    public static function updateTheme(int $theme): string|bool
    {
        $token = Client::$token;

        if ($theme > 0 && $theme < 5 && is_int($theme))
            db::update("users", "token='$token'", "theme='$theme'");

        return json_encode([
            'theme' => $theme
        ]);
    }

    public static function changeContents(string $type, string $url = ""): bool
    {
        $token = Client::$token;

        if ($type == "1" || $type == "2")
            if ($type == 1) {
                if ($url == "")
                    $url = "img/avatar.png";

                db::update("users", "token='$token'", "avatar='$url'");
            } else {
                db::update("users", "token='$token'", "banner='$url'");
            }

        return true;
    }

    public static function updatePassword(): string
    {
        $newPassword = $_GET['newPassword'];
        $againPassword = $_GET['againPassword'];
        $oldPassword = $_GET['currentPassword'];
        $status = false;

        if ($newPassword == $againPassword && strlen($newPassword) >= 8) {
            if (passwordEncrypt($oldPassword) == Client::$data->password) {
                $token = Client::$token;
                $password = passwordEncrypt($newPassword);

                db::update("users", "token='$token'", "password='$password'");

                $status = true;
                $message = 3443;
            } else {
                $message = 3442;
            }
        } else {
            $message = 3441;
        }

        return json_encode([
            'status' => $status,
            'message' => $message,
            'token' => self::newToken()
        ]);
    }

    public static function uploadContents(string $type, array $file): string|bool
    {
        $user_id = Client::$data->id;
        $url = "";

        if (in_array($type, ['avatar', 'banner'])) {
            $file_type = explode('/', $_FILES['file']['type'])[1];
            if ($file_type == "") {
                $explode_file_name = explode(".", $file['name']);
                $file_type = $explode_file_name[count($explode_file_name) - 1];
            }

            $file_name = randomSeed(32) . ".$file_type";
            $file_size = $file['size'];
            $target = "cdn/user{$user_id}";

            if (!file_exists($target)) {
                mkdir($target);

                if (!file_exists($target . "/avatars"))
                    mkdir($target . "/avatars");

                if (!file_exists($target . "/banners"))
                    mkdir($target . "/banners");
            }

            if ($file_size < FILE_SIZES[$type] && $file_type !== "") {
                $url = "$target/{$type}s/$file_name";
                move_uploaded_file($file['tmp_name'], "$target/{$type}s/$file_name");

                ClientUpdate::changeContents(($type == 'avatar' ? 1 : 2), $url);
            }
        }

        return json_encode([
            'status' => $url !== '',
            'url' => $url,
            'type' => $type
        ]);
    }

    public static function changeAccountPreferences(int $type, string $value, string $password): bool|string
    {
        /**
         * 6 900 = E-Posta boş bırakılamaz
         * 6 910 - 930 = Girilen değer çok kısa
         * 7 100 = E-posta değişiyor
         * 7 110 = Geçersiz e-posta
         * 8 100 = Telefon değişiyor
         * 9 100 = Şifre değişiyor
         * 10 000 = Şifre hatalı
         */

        $token = Client::$token;

        #[ArrayShape(["status" => "bool", "message" => "int"])]
        function update($token, $type, $value, $password, $acc_password): array
        {
            if (passwordEncrypt($password) == $acc_password) {
                switch ($type) {
                    case 0:
                        if (filter_var($value, FILTER_VALIDATE_EMAIL)) {
                            db::update("users", "token='$token'", "email='$value'");
                            $rData = ["status" => true, "message" => 7100];
                        } else {
                            $rData = ["status" => false, "message" => 7110];
                        }
                        break;
                    case 1:
                        db::update("users", "token='$token'", "phone='$value'");
                        $rData = ["status" => true, "message" => 8100];
                        break;
                    case 2:
                        $rData = ["status" => true, "message" => 9100];
                        break;
                    default:
                        $rData = ["status" => true, "message" => 01000];
                        break;
                }
            } else {
                $rData = ["status" => false, "message" => 10000];
            }

            return $rData;
        }

        $value = base64_decode($value);
        $password = base64_decode($password);

        if ($value == "" && $type !== 1) {
            $return = [ "status" => false, "message" => 6900 ];
        } else {
            if ($type == 1 && strlen($value) == 0) {
                $return = update($token, $type, $value, $password, Client::$data->password);
            } else if (strlen($value) < 8) {
                $return = [ "status" => false, "message" => 6910 ];
            } else {
                $return = update($token, $type, $value, $password, Client::$data->password);
            }
        }

        return json_encode($return);
    }

    public static function changePreferences(string $type, string $data): string|bool
    {
        $type = str_replace('settings-', '', base64_decode(str_replace('d3eve', '=', $type)));
        $data = json_decode(base64_decode(str_replace('d3eve', '=', $data)));

        $user_id = Client::$data->id;
        $token = Client::$token;
        $return = [];

        $change = [
            [ "joined_at", "location" ],
            [ "show_joined_date", "public_location" ]
        ];

        switch ($type) {
            case 2:
                $setQuery = "";

                for ($i = 0; $i < count($data); $i++) {
                    $value = $data[$i]->value;

                    if (is_bool($value) == true) {
                        $value = $value ? 'true' : 'false';
                    } else {
                        $value = slashes($value);
                    }

                    $setQuery .= str_replace($change[0], $change[1], $data[$i]->name) . "='" . $value . "',";
                }

                db::update("users", "token='$token'", rtrim($setQuery, ','));
                $return['v'] = rtrim($setQuery, ',');
                break;

            case 3:
                $updateQuery = "";
                $insertQuery = [
                    "'$user_id',",
                    'user_id,'
                ];

                $comment_settings = [
                    "comment_options_everyone",
                    "comment_options_only_followings",
                    "comment_options_only_friends",
                    "comment_options_only_mentioned",
                    "comment_options_nobody"
                ];

                for ($i = 0; $i < count($data); $i++) {
                    $value = $data[$i]->value;
                    $name = str_replace($change[0], $change[1], $data[$i]->name);

                    if (in_array($data[$i]->name, $comment_settings)) {
                        if ($value) {
                            $updateQuery .= "comment_options='" . str_replace('comment_options_', '', $name) . "',";

                            $insertQuery[0] .= "'" . str_replace('comment_options_', '', $name) . "',";
                            $insertQuery[1] .= "comment_options,";
                        }
                    } else {
                        $updateQuery .= $name . "='" . ($value ? 'true' : 'false') . "',";

                        $insertQuery[0] .= "'" . ($value ? 'true' : 'false') . "',";
                        $insertQuery[1] .= $name . ",";
                    }
                }

                $control = db::select("privacy_preferences", "user_id='$user_id'");

                if (db::getCount($control) == 0) {
                    db::insert("privacy_preferences", rtrim($insertQuery[1], ','), rtrim($insertQuery[0], ','));
                } else {
                    db::update("privacy_preferences", "user_id='$user_id'", rtrim($updateQuery, ','));
                }
                break;

            case 6:
                $setQuery = "";
                $accept = [
                    "languages" => ["tr", "en", "de", "az"],
                    "regions" => ["africa", "america", "asia", "europe", "oceania"]
                ];

                for ($i = 0; $i < count($data); $i++) {
                    $value = $data[$i]->value;
                    $name = $data[$i]->name;

                    if (str_contains($name, 'lang')) {
                        if ($value) {
                            $v = str_replace('lang-', '', $name);

                            if (in_array($v, $accept['languages'])) {
                                $setQuery .= "language='$v',";
                            }
                        }
                    } else if (str_contains($name, 'region')) {
                        if ($value) {
                            $v = str_replace('region-', '', $name);

                            if (in_array($v, $accept['regions'])) {
                                $setQuery .= "region='$v',";
                            }
                        }
                    }
                }

                db::update("users", "token='$token'", rtrim($setQuery, ','));
                break;

            case 7:
                for ($i = 0; $i < count($data); $i++) {
                    $value = $data[$i]->value ? 'true' : 'false';

                    if ($data[$i]->name == 'email_alerts') {
                        db::update("users", "token='$token'", "send_notifications='$value'");
                    }
                }
                break;

            case 8:
                $data_saving_settings = [
                    "wifi_and_mobile_data",
                    "only_wifi",
                    "never"
                ];

                for ($i = 0; $i < count($data); $i++) {
                    $name = $data[$i]->name;
                    $value = $data[$i]->value;

                    if (in_array($name, $data_saving_settings)) {
                        if ($value) {
                            db::update("users", "token='$token'", "data_saving='$name'");
                        }
                    }
                }
                break;
        }

        return json_encode($return);
    }
}