<?php
namespace Glynet\PostService;

class Stories {
    public static function collect(): string
    {
        function appendArray(): array
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

        for ($i = 0; $i < 25; $i++)
            array_push($return, appendArray());

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

       return json_encode($return);
    }
}