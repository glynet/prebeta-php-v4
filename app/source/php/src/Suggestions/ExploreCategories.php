<?php
namespace Glynet\Suggestions;

class Explore {
    public static function getCategories(): string
    {
        $return = [];
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

        foreach ($categories as $category)
            if ($category['display'] && (isset($category['region']) && $GLOBALS['user']->country_code == $category['region'] || $category['region'] == ''))
                array_push($return, [
                    'id' => rand(999,9999),
                    'details' => [
                        'title' => $category['title'],
                        'thumbnail' => $category['thumbnail']
                    ]
                ]);

        return json_encode($return);
    }
}