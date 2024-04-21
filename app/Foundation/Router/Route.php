<?php

namespace Norden\Foundation\Router;

class Route
{
    protected static $routes = [];

    public static function get($uri, $action)
    {
        self::$routes['GET'][$uri] = $action;
    }

    public static function post($uri, $action)
    {
        self::$routes['POST'][$uri] = $action;
    }

    /**
     * @throws \Exception
     */
    public static function match($uri, $method)
    {
        self::loadRoutes();

        if (isset(self::$routes[$method][$uri])) {
            return self::$routes[$method][$uri];
        }
        return false;
    }

    /**
     * @throws \Exception
     */
    public static function loadRoutes()
    {
        $routesFilePath = APP_ROOT. 'routes/routes.php';

        if (file_exists($routesFilePath)) {
            require_once $routesFilePath;
        } else {
            throw new \Exception("Routes file not found: $routesFilePath");
        }
    }
}