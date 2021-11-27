<?php 
namespace Glynet\Router;

class Router {
    public static int $routers = 0;
    public static int $routers_errors = 0;

    public static function parse_url(): string
    {
        $dirname = dirname($_SERVER['SCRIPT_NAME']);
        $basename = basename($_SERVER['SCRIPT_NAME']);
        return explode('?', str_replace([$dirname, $basename], null, $_SERVER['REQUEST_URI']))[0];
    }

    public static function listen($url, $callback)
    {
        self::$routers++;

        $request_uri = self::parse_url();

        $url = preg_replace('/\\\:[a-zA-Z0-9._-]+/', '([a-zA-Z0-9._-]+)', preg_quote($url));
        $url = str_replace('@', '\@', $url);

        if (preg_match('@^' . $url . '$@D', $request_uri, $parameters)) {
            unset($parameters[0]);
            
            if (is_callable($callback)) {
                call_user_func_array($callback, $parameters);
            }
        } else {
            self::$routers_errors++;
        }
    }

    public static function checkErrors()
    {
        if (self::$routers_errors == self::$routers) {
            echo "Böyle bir sayfa yok?!?!";
        }
    }
}