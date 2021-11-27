<?php
namespace Glynet\ClientService;
use Glynet\Database\Database as db;
use JetBrains\PhpStorm\ArrayShape;

class Client {
    public static string $token = '';

    public static function setToken(string $token): void
    {
        self::$token = $token;
    }

    public static function getData()
    {
        $data = db::select("users", "token='" . self::$token . "'");
        return db::fetch($data);
    }

    #[ArrayShape(['percent' => "float|int", 'level' => "int|mixed"])]
    public static function getRank(int $myPoints = 200): array
    {
        $calcStart = 190;
        $calcEnd = 230;
        $calcInc = 0;
        $calcLevel = 6;

        $myStart = 0;
        $myEnd = 0;

        $myLevel = 0;
        $calcCount = 0;

        do {
            $calcCount = $calcCount + 1;

            if ($calcCount % 2 == 0 )
                $calcInc = $calcInc + $calcLevel;

            if (($myPoints < $calcEnd) && ($myPoints >= $calcStart)) {
                $myLevel = $calcCount;
                $myStart = $calcStart;
                $myEnd = $calcEnd;
            }

            $calcStart = $calcEnd;
            $calcEnd = $calcEnd + $calcInc;
        } while ($myLevel == 0);
        $myLevel--;


        $myPercent = (($myPoints - $myStart) / ($myEnd - $myStart)) * 100;
        $myPercent = round($myPercent);

        if ($myPercent == 0)
            $myPercent = 1;

        if ($myLevel == 0)
            $myLevel = 1;

        return ['percent' => $myPercent, 'level' => $myLevel];
    }

    public static function updateTheme(string $theme): void
    {
        db::update("users", "token='" . self::$token . "'", "theme='$theme'");
    }
}