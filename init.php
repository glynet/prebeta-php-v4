<?php
declare(strict_types = 1);

const MAIN = __DIR__;

const FILE_SIZES = [
    'avatar' => 8388608,
    'banner' => 33554432,
    'free_post' => 16777216,
    'premium_post' => 33554432
];

const AVAILABLE_COLORS = [ "2fe0b7", "26a5ef", "a653f4", "6926ef", "e250fc", "fc2ae0", "fc2a93", "fc4160", "fc7641", "fc7c20", "fcc520", "e9ef3e", "5cc326", "87e529", "50f736", "36f7b7", "CCCCFF", "9FE2BF", "FF7F50", "6495ED" ];

const FILE_TYPES = [
    'video' => ['mp4'],
    'image' => ['gif', 'jpeg', 'jpg', 'png']
];

$db = json_decode(file_get_contents(MAIN . '/config/db.json'), true);
$default = [
    'script_url' => 'static/build/script/dist.js',
    'style_url' => 'static/build/style/main.css',
];

// Functions
require_once MAIN . '/app/source/php/func/functions.php';

// Application
require_once MAIN . '/app/source/php/Database.php';
require_once MAIN . '/app/source/php/Router.php';
require_once MAIN . '/app/source/php/Viewer.php';

// Client
require_once MAIN . '/app/source/php/src/Client/Client.php';
require_once MAIN . '/app/source/php/src/Client/ClientUpdate.php';

// Notifications
require_once MAIN . '/app/source/php/src/Notifications/Notifications.php';

// UserOptions
require_once MAIN . '/app/source/php/src/User/User.php';
require_once MAIN . '/app/source/php/src/User/UserOptions.php';

// Posts
require_once MAIN . '/app/source/php/src/Posts/Posts.php';
require_once MAIN . '/app/source/php/src/Posts/Stories.php';

// Suggestions
require_once MAIN . '/app/source/php/src/Suggestions/Suggestions.php';
require_once MAIN . '/app/source/php/src/Suggestions/ExploreCategories.php';