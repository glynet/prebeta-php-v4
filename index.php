<?php
ini_set('display_errors', 0);
require_once 'init.php';

use \Glynet\Viewer\UI as viewer,
    \Glynet\Router\Router as app,
    \Glynet\Database\Database as db;

use \Glynet\UserService\User as user,
    \Glynet\PostService\Posts as posts,
    \Glynet\PostService\Stories as stories,
    \Glynet\Suggestions\Trends as trends,
    \Glynet\Suggestions\Contacts as contacts,
    \Glynet\Suggestions\Explore as explore,
    \Glynet\Suggestions\Search as search,
    \Glynet\ClientService\Client as client,
    \Glynet\ClientService\ClientUpdate,
    \Glynet\ClientService\Notifications as notifications;

$token_list = ["245868998", "262923799", "245868931", "2458689931", "483588160", "483588189", "591554326"];
$token = $_COOKIE['token'];
$token = $token_list[4];

db::connect($GLOBALS['db']);
client::setToken($token);

$user = client::collectData();

app::listen('/', function() {
    if ($GLOBALS['user']->id == '') {
        viewer::render('login');
    } else {
        $GLOBALS['default']['trending_topics'] = trends::getTopics();
        $GLOBALS['default']['recommended_contacts'] = contacts::collect($GLOBALS['token']);

        viewer::render('main', $GLOBALS['default']);
    }
});

app::listen('/login', function() {
    viewer::render('login');
});

app::listen('/:page', function() {
    if ($GLOBALS['user']->id == '') {
        viewer::render('login');
    } else {
        $GLOBALS['default']['trending_topics'] = trends::getTopics();
        $GLOBALS['default']['recommended_contacts'] = contacts::collect($GLOBALS['token']);

        viewer::render('main', $GLOBALS['default']);
    }
});

app::listen('/@:username', function() {
    if ($GLOBALS['user']->id == '') {
        viewer::render('login');
    } else {
        $GLOBALS['default']['trending_topics'] = trends::getTopics();
        $GLOBALS['default']['recommended_contacts'] = contacts::collect($GLOBALS['token']);

        viewer::render('main', $GLOBALS['default']);
    }
});

app::listen('/pages/:name', function(string $name) {
    viewer::render($name, match ($name) {
        'profile' => [
            'profile' => user::getData($_GET['username'], $GLOBALS['token'])
        ],
        'settings' => [
            'user' => [ 'email' => $GLOBALS['user']->{'email'}, 'number' => $GLOBALS['user']->{'phone'} ],
            'profile' => user::getData($GLOBALS['user']->{'username'}, $GLOBALS['token']),
            'privacy' => client::privacyPreferences(),
            'last_sessions' => client::lastSessions(),
            'colors' => AVAILABLE_COLORS
        ],
        default => [],
    });
});

// API

app::listen('/api/@me/client', function() {
    client::sessionControl();

    echo json_encode([
        'id' => (int)$GLOBALS['user']->id,
        'token' => (int)$GLOBALS['user']->token,
        'name' => $GLOBALS['user']->name,
        'username' => $GLOBALS['user']->username,
        'avatar' => $GLOBALS['user']->avatar,
        'color' => $GLOBALS['user']->color,
        'theme' => (int)$GLOBALS['user']->theme
    ]);
});

app::listen('/api/@me/client/level', function() {
    echo client::getRank($GLOBALS['user']->{'points'});
});

app::listen('/api/@me/client/theme/update/:id', function(int $id) {
    echo ClientUpdate::updateTheme($id);
});

app::listen('/api/@me/client/settings/update/:type/:data', function(string $type, string $data) {
    echo ClientUpdate::changePreferences($type, $data);
});

app::listen('/api/@me/client/account/update/:type', function(int $type) {
    echo ClientUpdate::changeAccountPreferences($type, $_REQUEST['value'], $_REQUEST['password']);
});

app::listen('/api/@me/client/color/update', function() {
    echo ClientUpdate::setColor("#" . $_GET['code']);
});

app::listen('/api/@me/client/settings/password', function() {
    echo ClientUpdate::updatePassword();
});

app::listen('/api/@me/client/contents/update/:type', function(string $type) {
    echo ClientUpdate::uploadContents($type, $_FILES['file']);
});

app::listen('/api/@me/client/contents/remove/:type', function(string $type) {
    echo ClientUpdate::changeContents($type);
});

app::listen('/api/@me/search/suggestions', function() {
    echo search::query(mb_strtolower(trim($_GET['q'])));
});

app::listen('/api/@me/posts/:type/:query', function(string $type, string $query) {
    echo posts::query($type, $query);
});

app::listen('/api/@me/profile/:type/:id', function(string $type, string $id) {
    echo user::query($type, $id);
});

app::listen('/api/@me/notifications', function() {
    echo notifications::get($GLOBALS['user']->id, $GLOBALS['user']->language);
});

app::listen('/api/@me/stories/collect', function() {
    echo stories::collect();
});

app::listen('/api/@me/explore/categories/collect', function() {
    echo explore::getCategories();
});

// Others

app::listen('/mommycanigoout/', function() {
    header('Location: http://' . str_replace(['https://', 'http://'], '', base64_decode($_GET['r'])));
});

app::checkErrors();
db::end();