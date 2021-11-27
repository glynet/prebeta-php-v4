<?php
require_once 'init.php';

use Glynet\Viewer\UI as viewer,
    Glynet\Router\Router as app,
    Glynet\Database\Database as db;

use Glynet\Profile\Profile as profile,
    Glynet\PostService\Posts as posts,
    Glynet\Suggestions\Trends as trends,
    Glynet\Suggestions\Contacts as contacts,
    Glynet\Suggestions\Search as search,
    Glynet\ClientService\Client as client,
    Glynet\ClientService\Notifications as notifications,
    JetBrains\PhpStorm\ArrayShape;

$token_list = ["245868998", "262923799", "245868931"];
$token = $token_list[2];

db::connect($GLOBALS['db']);
client::setToken($token);

$user = client::getData();

app::listen('/', function() {
    $GLOBALS['default']['trending_topics'] = trends::getTopics();
    $GLOBALS['default']['recommended_contacts'] = contacts::collect($GLOBALS['token']);

    viewer::render('main', $GLOBALS['default']);
});

app::listen('/:page', function() {
    $GLOBALS['default']['trending_topics'] = trends::getTopics();
    $GLOBALS['default']['recommended_contacts'] = contacts::collect($GLOBALS['token']);

    viewer::render('main', $GLOBALS['default']);
});

app::listen('/@:username', function() {
    $GLOBALS['default']['trending_topics'] = trends::getTopics();
    $GLOBALS['default']['recommended_contacts'] = contacts::collect($GLOBALS['token']);

    viewer::render('main', $GLOBALS['default']);
});

app::listen('/pages/:name', function(string $name) {
    viewer::render($name, match ($name) {
        'profile' => [
            'profile' => profile::getData($_GET['username'], $GLOBALS['token'])
        ],
        default => [],
    });
});

// API

app::listen('/api/@me/client', function() {
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
    $points = ($GLOBALS['user']->{'points'} == '' ? 200 : (int)$GLOBALS['user']->{'points'});
    echo json_encode( client::getRank($points) );
});

app::listen('/api/@me/client/theme/update/:id', function(int $id) {
    $ok = false;

    if ($id > 0 && $id < 5 && is_int($id)) {
        $ok = true;
        client::updateTheme($id);
    }

    echo json_encode([
        'ok' => $ok,
        'theme' => $id
    ]);
});

app::listen('/api/@me/search/suggestions', function() {
    echo json_encode(search::query(mb_strtolower(trim($_GET['q']))));
});

app::listen('/api/@me/posts/:type/:query', function(string $type, string $query) {
    switch ($type) {
        case 'save':
            echo json_encode( posts::save($query, $GLOBALS['token']) );
            break;

        case 'like':
            echo json_encode( posts::like($query, $GLOBALS['token']) );
            break;

        case 'delete':
            echo json_encode(posts::delete($query, $GLOBALS['token']));
            break;

        case 'likes':
            echo json_encode(posts::likes($query, $GLOBALS['token']));
            break;

        case 'remove_like':
            echo json_encode(posts::removeLike(explode('-', $query)[0], explode('-', $query)[1], $GLOBALS['token']));
            break;

        default:
            $posts = posts::load($type, $query, $GLOBALS['token']);

            viewer::render('posts', [
                'code' => $posts['status'],
                'posts' => $posts['posts']
            ]);
            break;
    }
});

app::listen('/api/@me/profile/:type/:id', function(string $type, string $id) {
    echo match($type) {
        'followings' => json_encode(profile::getMetrics($id, 1, $GLOBALS['token'])),
        'followers' => json_encode(profile::getMetrics($id, 2, $GLOBALS['token'])),
        'follow' => json_encode(profile::follow($id, $GLOBALS['token'])),
        'remove_follower' => json_encode(profile::remove($id, $GLOBALS['token']))
    };
});

app::listen('/api/@me/notifications', function() {
    echo notifications::get($GLOBALS['user']->id, $GLOBALS['user']->language);
});

app::listen('/api/@me/stories/collect', function() {
    #[ArrayShape(['id' => "int", 'user' => "array", 'content' => "string[]"])]
    function appendStory(): array
    {
        return [
            'id' => rand(999,9999),
            'user' => [
                'username' => str_replace(' ', '.', strtolower(randomName())),
                'avatar' => 'https://source.unsplash.com/random/' . rand(999,9999)
            ],
            'content' => [
                'thumbnail' => 'https://picsum.photos/600?random=' . rand(999,9999)
                // 'thumbnail' => 'https://source.unsplash.com/random/1' . rand(999,9999)
            ]
        ];
    }

    $return = [];

    for ($i = 0; $i < 25; $i++) {
        array_push($return, appendStory());
    }

    $return = [
        'client' => [
            'story' => false,
            'details' => [
                'id' => $GLOBALS['user']->id,
                'username' => $GLOBALS['user']->username,
                'avatar' => $GLOBALS['user']->avatar
            ]
        ],
        'stories' => $return
    ];

    print_r(json_encode($return));
});

app::listen('/api/@me/explore/categories/collect', function() {
    $categories = [
        'c1938' => [ 'display' => false, 'region' => 'tr', 'title' => '10 Kasım', 'thumbnail' => 'static/assets/images/categories/10kasim.jpg' ],
        'c1' => [ 'display' => true, 'title' => 'Meme', 'thumbnail' => 'static/assets/images/categories/meme-unsplash.jpg' ],
        'c2' => [ 'display' => true, 'title' => 'Sağlık', 'thumbnail' => 'static/assets/images/categories/health-unsplash.jpg' ],
        'c3' => [ 'display' => true, 'title' => 'Hayvanlar', 'thumbnail' => 'static/assets/images/categories/animals-unsplash.jpg' ],
        'c4' => [ 'display' => true, 'title' => 'Hip Hop', 'thumbnail' => 'static/assets/images/categories/emrecdu.jpg' ],
        'c5' => [ 'display' => true, 'title' => 'Oyunlar', 'thumbnail' => 'static/assets/images/categories/games-unsplash.jpg' ],
        'c6' => [ 'display' => true, 'title' => 'Kripto', 'thumbnail' => 'static/assets/images/categories/crypto.jpg' ],
        'c7' => [ 'display' => true, 'title' => 'Dövme', 'thumbnail' => 'static/assets/images/categories/tattoo-unsplash.jpg' ],
        'c8' => [ 'display' => true, 'title' => 'Dizi & Film', 'thumbnail' => 'static/assets/images/categories/movie.jpg' ],
        'c9' => [ 'display' => true, 'title' => 'Sanat', 'thumbnail' => 'static/assets/images/categories/art-unsplash.jpg' ],
        'c10' => [ 'display' => true, 'title' => 'Yiyecek', 'thumbnail' => 'static/assets/images/categories/food.jpg' ],
        'c11' => [ 'display' => true, 'title' => 'Spor', 'thumbnail' => 'static/assets/images/categories/sports.jpg' ]
    ];
    $return = [];
   
    foreach ($categories as $category)
        if ($category['display'] && (isset($category['region']) && $GLOBALS['user']->countryCode == $category['region'] || $category['region'] == ''))
            array_push($return, [
                'id' => rand(999,9999),
                'details' => [
                    'title' => $category['title'],
                    'thumbnail' => $category['thumbnail']
                ]
            ]);

    print_r(json_encode($return));
});

// Others

app::listen('/heyy/', function() {

});

app::listen('/mommycanigoout/', function() {
    $url = str_replace(['https://', 'http://'], '', base64_decode($_GET['r']));
    header('Location: http://' . $url);
});

app::checkErrors();
db::end();