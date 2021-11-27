<?php
if ($_GET['type'] == 'user_content') {
    $img = base64_encode(file_get_contents($_GET['path']));
    $percent = $_GET['percent'];

    header('Content-Type: image/jpeg');

    $data = base64_decode($img);
    $im = imagecreatefromstring($data);
    $width = imagesx($im);
    $height = imagesy($im);
    $newwidth = $width * $percent;
    $newheight = $height * $percent;

    $thumb = imagecreatetruecolor($newwidth, $newheight);

    imagecopyresized($thumb, $im, 0, 0, 0, 0, $newwidth, $newheight, $width, $height);

    print_r(imagejpeg($thumb));
} else if ($_GET['type'] == 'EmojiAPI') {
    header('Content-type: image');
    readfile("https://cdn.discordapp.com/emojis/" . base64_decode($_GET['i']));
    exit;
} else if ($_GET['type'] == 'avatar') {
    header( 'Content-type: image/svg+xml');

    $background = str_replace('#', '', $_GET['bg']);
    $color = array(
        '057d9c' => 'cyan',
        '4af7d7' => 'teal',
        '12ddc2' => 'teal',
        '6d2aff' => 'lime',
        '8f7ed6' => 'deepPurple',
        'EA1E63' => 'orange',
        'ffb54d' => 'deepOrange',
        'f76a6a' => 'yellow',
        'f69ae4' => 'pink',
        '80e1f9' => 'lightBlue',
        'ff8652' => 'cyan'
    )[$background];
    $url = "https://avatars.dicebear.com/api/identicon/" . str_replace(' ', '', $_GET['username']) . ".svg?m=15&colors[]=" . $color . "&background=%23" . $background;

    echo file_get_contents($url, false, stream_context_create([
        "ssl" => [
            "verify_peer" => false,
            "verify_peer_name" => false,
        ]
    ]));
    exit;
} else if ($_GET['type'] == 'title-icon') {
    $filename = base64_decode($_GET['r']);
    $image_s = imagecreatefromstring(file_get_contents($filename));
    $width = imagesx($image_s);
    $height = imagesy($image_s);
    $newwidth = 300;
    $newheight = 300;
    $image = imagecreatetruecolor($newwidth, $newheight);
    imagealphablending($image, true);
    imagecopyresampled($image, $image_s, 0, 0, 0, 0, $newwidth, $newheight, $width, $height);

    //create masking
    $mask = imagecreatetruecolor($newwidth, $newheight);
    $transparent = imagecolorallocate($mask, 255, 0, 0);
    imagecolortransparent($mask,$transparent);
    imagefilledellipse($mask, $newwidth/2, $newheight/2, $newwidth, $newheight, $transparent);
    $red = imagecolorallocate($mask, 0, 0, 0);
    imagecopymerge($image, $mask, 0, 0, 0, 0, $newwidth, $newheight, 100);
    imagecolortransparent($image,$red);
    imagefill($image, 0, 0, $red);

    //output, save and free memory
    header('Content-type: image/png');
    imagepng($image);
    imagepng($image,'cdn/title/output.png');
    imagedestroy($image);
    imagedestroy($mask);
}