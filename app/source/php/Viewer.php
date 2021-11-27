<?php /** @noinspection ALL */

namespace Glynet\Viewer;

class UI {
    public static bool|string $view;

    public static function render(string $view, array $data = [])
    {
        $dir = str_replace('/index.php', '', $_SERVER['SCRIPT_FILENAME']);
        extract($data);

        $viewName = $view . '/' . $view . '.php';
        $viewPath = $dir . '/app/views/template/' . $viewName;

        ob_start();
        require $viewPath;
        self::$view = ob_get_clean();
        self::parse();

        $viewCachePath = $dir . '/app/views/cache/' . $viewName;

        if (!file_exists($viewCachePath)) {
            mkdir($dir . '/app/views/cache/' . $view, 0777);
            file_put_contents($viewCachePath, self::$view);
        }

        if (filemtime($viewCachePath) < filemtime($viewPath)) {
            file_put_contents($viewCachePath, self::$view);
        }

        require $viewCachePath;
    }

    public static function parse()
    {
        self::parseVariables();
        self::parseForeach();
        self::parseIfElse();
    }

    public static function restore($str): array|string|null
    {
        return preg_replace('/\+/', '', preg_replace('/\%/s', '$', $str));
    }

    public static function parseVariables()
    {
        self::$view = preg_replace_callback('/{{(.*?)}}/', function($variable) {
            $var = trim($variable[1]);

            if (substr($var, 0, 1) == '%' || substr($var, 0, 1) == '+') {
                return '<?=' . self::restore($var) . '?>';
            } else {
                return '<?php ' . self::restore($var) . '; ?>';
            }
        }, self::$view);
    }

    public static function parseForeach()
    {
        self::$view = preg_replace_callback('/@foreach\((.*?) as (.*?)\)/', function($variable) {
            if (strstr($variable[2], '=>')) {
                [$key, $value] = explode('=>', $variable[2]);
                return '<?php foreach(' . self::restore(trim($variable[1])) . ' as $' . trim($key) . ' => $' . trim($value) . '): ?>';
            }
            return '<?php foreach(' . self::restore(trim($variable[1])) . ' as $' . $variable[2] . '): ?>';
        }, self::$view);
        self::$view = preg_replace_callback('/@endforeach/', function() {
            return '<?php endforeach; ?>';
        }, self::$view);
    }

    public static function parseIfElse()
    {
        self::$view = preg_replace_callback('/@if\((.*?) (.*?) (.*?)\)/', function($variable) {
            return '<?php if (' . self::restore(trim($variable[1])) . ' ' . trim($variable[2]) . ' ' . self::restore(trim($variable[3])) . '): ?>';
        }, self::$view);

        self::$view = preg_replace_callback('/@else/', function() {
            return '<?php else: ?>';
        }, self::$view);

        self::$view = preg_replace_callback('/@elif\((.*?) (.*?) (.*?)\)/', function($variable) {
            return '<?php elseif (' . self::restore(trim($variable[1])) . ' ' . trim($variable[2]) . ' ' . self::restore(trim($variable[3])) . '): ?>';
        }, self::$view);

        self::$view = preg_replace_callback('/@endif/', function() {
            return '<?php endif; ?>';
        }, self::$view);
    }
}