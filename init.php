<?php
declare(strict_types = 1);

const MAIN = __DIR__;
const FILE_TYPES = [
    'video' => ['mp4', 'bup', 'mxf', 'mpg', 'm2v', '3gp', 'mov', 'avi', 'flv', 'wmv', 'm4p', 'm4v'],
    'image' => ['gif', 'jpeg', 'jpg', 'jpe', 'jif', 'jfif', 'webp', 'heif', 'jfi', 'gif', 'bmp', 'png', 'jp2', 'j2k', 'jpx']
];

$db = json_decode(file_get_contents(MAIN . '/config/db.json'), true);
$default = [
    'script_url' => 'static/build/script/dist.js',
    'style_url' => 'static/build/style/main.css',
];

require_once MAIN . '/app/source/php/func/functions.php';

require_once MAIN . '/app/source/php/Database.php';
require_once MAIN . '/app/source/php/Router.php';
require_once MAIN . '/app/source/php/Viewer.php';

require_once MAIN . '/app/source/php/extends/Client.php';
require_once MAIN . '/app/source/php/extends/Notifications.php';
require_once MAIN . '/app/source/php/extends/Profile.php';
require_once MAIN . '/app/source/php/extends/Posts.php';
require_once MAIN . '/app/source/php/extends/Suggestions.php';