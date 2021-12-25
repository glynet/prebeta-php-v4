<?php
function moment($timestamp = "10.03.2004 09:00", $language = "en", $timezone = "Europa/Istanbul"): array|string
{
    $moment_language = array(
        "en" => array(
            "just_now" => "just now",
            "one_minute_ago" => "one minute ago",
            "minutes_ago" => "{date} minutes ago",
            "an_hour_ago" => "an hour ago",
            "hours_ago" => "{date} hours ago",
            "yesterday" => "yesterday",
            "days_ago" => "{date} days ago",
            "a_week_ago" => "a week ago",
            "weeks_ago" => "{date} weeks ago",
            "a_month_ago" => "a month ago",
            "months_ago" => "{date} months ago",
            "one_year_ago" => "one year ago",
            "years_ago" => "{date} years ago"
        ),
        "tr" => array(
            "just_now" => "şimdi",
            "one_minute_ago" => "bir dakika önce",
            "minutes_ago" => "{date} dakika önce",
            "an_hour_ago" => "bir saat önce",
            "hours_ago" => "{date} saat önce",
            "yesterday" => "dün",
            "days_ago" => "{date} gün önce",
            "a_week_ago" => "bir hafta önce",
            "weeks_ago" => "{date} hafta önce",
            "a_month_ago" => "bir ay önce",
            "months_ago" => "{date} ay önce",
            "one_year_ago" => "bir yıl önce",
            "years_ago" => "{date} yıl önce"
        )
    )[$language];
    
    date_default_timezone_set($timezone);

    $time_ago        = strtotime($timestamp);
    $current_time    = time();
    $time_difference = $current_time - $time_ago;
    $seconds         = $time_difference;
    
    $minutes = round($seconds / 60);
    $hours   = round($seconds / 3600);
    $days    = round($seconds / 86400);
    $weeks   = round($seconds / 604800);
    $months  = round($seconds / 2629440);
    $years   = round($seconds / 31553280);
    
    if ($seconds <= 60) {
        return $moment_language["just_now"];
    } else if ($minutes <= 60) {
        if ($minutes == 1) {
            return $moment_language["one_minute_ago"];
        } else {
            return str_replace("{date}", $minutes, $moment_language["minutes_ago"]);
        }
    } else if ($hours <= 24) {
        if ($hours == 1) {
            return $moment_language["an_hour_ago"];
        } else {
            return str_replace("{date}", $hours, $moment_language["hours_ago"]);
        }
    } else if ($days <= 7) {
        if ($days == 1) {
            return $moment_language["yesterday"];
        } else {
            return str_replace("{date}", $days, $moment_language["days_ago"]);
        }
    } else if ($weeks <= 4.3){
        if ($weeks == 1) {
            return $moment_language["a_week_ago"];
        } else {
            return str_replace("{date}", $weeks, $moment_language["weeks_ago"]);
        }
    } else if ($months <= 12) {
        if ($months == 1) {
            return $moment_language["a_month_ago"];
        } else {
            return str_replace("{date}", $months, $moment_language["months_ago"]);
        }
    } else {
        if ($years == 1) {
            return $moment_language["one_year_ago"];
        } else {
            return str_replace("{date}", $years, $moment_language["years_ago"]);
        }
    }
}

function randomName(): string
{
    $firstname = array(
        'Johnathon',
        'Anthony',
        'Erasmo',
        'Raleigh',
        'Nancie',
        'Tama',
        'Camellia',
        'Augustine',
        'Christeen',
        'Luz',
        'Diego',
        'Lyndia',
        'Thomas',
        'Georgianna',
        'Leigha',
        'Alejandro',
        'Marquis',
        'Joan',
        'Stephania',
        'Elroy',
        'Zonia',
        'Buffy',
        'Sharie',
        'Blythe',
        'Gaylene',
        'Elida',
        'Randy',
        'Margarete',
        'Margarett',
        'Dion',
        'Tomi',
        'Arden',
        'Clora',
        'Laine',
        'Becki',
        'Margherita',
        'Bong',
        'Jeanice',
        'Qiana',
        'Lawanda',
        'Rebecka',
        'Maribel',
        'Tami',
        'Yuri',
        'Michele',
        'Rubi',
        'Larisa',
        'Lloyd',
        'Tyisha',
        'Samatha',
    );

    $lastname = array(
        'Mischke',
        'Serna',
        'Pingree',
        'Mcnaught',
        'Pepper',
        'Schildgen',
        'Mongold',
        'Wrona',
        'Geddes',
        'Lanz',
        'Fetzer',
        'Schroeder',
        'Block',
        'Mayoral',
        'Fleishman',
        'Roberie',
        'Latson',
        'Lupo',
        'Motsinger',
        'Drews',
        'Coby',
        'Redner',
        'Culton',
        'Howe',
        'Stoval',
        'Michaud',
        'Mote',
        'Menjivar',
        'Wiers',
        'Paris',
        'Grisby',
        'Noren',
        'Damron',
        'Kazmierczak',
        'Haslett',
        'Guillemette',
        'Buresh',
        'Center',
        'Kucera',
        'Catt',
        'Badon',
        'Grumbles',
        'Antes',
        'Byron',
        'Volkman',
        'Klemp',
        'Pekar',
        'Pecora',
        'Schewe',
        'Ramage',
    );

    $name = $firstname[rand ( 0 , count($firstname) -1)];
    $name .= ' ';
    $name .= $lastname[rand ( 0 , count($lastname) -1)];

    return $name;
}

function randomSeed($length = 16): string
{
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';

    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }

    return $randomString;
}


function slashes($str, $encode = true): string
{
    if ($encode) {
        return str_replace("'", "{/quotes}", $str);
    } else {
        return str_replace("{/quotes}", "'", $str);
    }
}

function passwordEncrypt($password): string
{
    $password = md5($password);
    $password = crc32($password);
    $password = sha1($password);
    $password = md5($password);
    $password = crc32($password);
    $password = sha1($password);

    return $password;
}

function getBrowser(): string
{
    $user_agent = $_SERVER['HTTP_USER_AGENT'];

    $browser = "Unknown";
    $browser_array  = array(
        '/msie/i'       =>  'Internet Explorer',
        '/firefox/i'    =>  'Firefox',
        '/safari/i'     =>  'Safari',
        '/chrome/i'     =>  'Chrome',
        '/edge/i'       =>  'Edge',
        '/opera/i'      =>  'Opera',
        '/netscape/i'   =>  'Netscape',
        '/maxthon/i'    =>  'Maxthon',
        '/konqueror/i'  =>  'Konqueror',
        '/mobile/i'     =>  'Handheld Browser'
    );

    foreach ($browser_array as $regex => $value) {
        if (preg_match( $regex, $user_agent )) {
            $browser = $value;
        }
    }

    return $browser;
}

function getOS(): string
{
    $user_agent = $_SERVER['HTTP_USER_AGENT'];

    $os_platform = "Unknown";
    $os_array = array(
        '/windows nt 11/i'      => 'Windows 11',
        '/windows nt 10/i'      => 'Windows 10',
        '/windows nt 6.3/i'     => 'Windows 8.1',
        '/windows nt 6.2/i'     => 'Windows 8',
        '/windows nt 6.1/i'     => 'Windows 7',
        '/windows nt 6.0/i'     => 'Windows Vista',
        '/windows nt 5.2/i'     => 'Windows Server 2003/XP x64',
        '/windows nt 5.1/i'     => 'Windows XP',
        '/windows xp/i'         => 'Windows XP',
        '/windows nt 5.0/i'     => 'Windows 2000',
        '/windows me/i'         => 'Windows ME',
        '/win98/i'              => 'Windows 98',
        '/win95/i'              => 'Windows 95',
        '/win16/i'              => 'Windows 3.11',
        '/CrOS armv7/i'         => 'Chrome OS',
        '/macintosh|mac os x/i' => 'Mac',
        '/mac_powerpc/i'        => 'Mac',
        '/linux/i'              => 'Linux',
        '/ubuntu/i'             => 'Ubuntu',
        '/iphone/i'             => 'iPhone',
        '/ipod/i'               => 'iPod',
        '/ipad/i'               => 'iPad',
        '/android/i'            => 'Android',
        '/blackberry/i'         => 'BlackBerry',
        '/webos/i'              => 'Mobile'
    );
    foreach ($os_array as $regex => $value) {
        if (preg_match($regex, $user_agent)) {
            $os_platform = $value;
        }
    }

    return $os_platform;
}

function crypto_rand_secure($min, $max)
{
    $range = $max - $min;

    if ($range < 1)
        return $min;

    $log = ceil(log($range, 2));
    $bytes = (int) ($log / 8) + 1;
    $bits = (int) $log + 1;
    $filter = (1 << $bits) - 1;

    do {
        $rnd = hexdec(bin2hex(openssl_random_pseudo_bytes($bytes)));
        $rnd = $rnd & $filter;
    } while ($rnd > $range);

    return $min + $rnd;
}

function tokenGenerator($length = 64): string
{
    $token = "";
    $codeAlphabet = "0123456789";
    $codeAlphabet.= "0123456789";
    $codeAlphabet.= "0123456789";
    $max = strlen($codeAlphabet);

    for ($i=0; $i < $length; $i++) {
        $token .= $codeAlphabet[crypto_rand_secure(0, $max-1)];
    }

    return $token;
}
