<?php

namespace Norden\Foundation;

use Norden\Foundation\Router\Route;
use ReflectionNamedType;

class Kernel
{
    /**
     * @throws \Exception
     */
    public static function handleRequest(): void
    {
        $request = new Request();

        $uri = $_SERVER['REQUEST_URI'];
        $method = $_SERVER['REQUEST_METHOD'];

        $route = Route::match($uri, $method);

        if ($route) {
            $next = function ($request) use ($route) {
                self::sendResponse(self::processRoute($route, $request));
            };

            self::applyMiddleware('before', $route, $request, $next);
            self::applyMiddleware('after', $route, $request, $next);
        } else {
            http_response_code(404);
            echo '404 Not Found';
        }
    }

    /**
     * @throws \ReflectionException
     */
    protected static function processRoute($route, $request): Response
    {
        $controllerName = $route['controller'];
        $controller = new $controllerName();

        $action = $route['action'];

        $reflectionMethod = new \ReflectionMethod($controllerName, $action);
        $parameters = $reflectionMethod->getParameters();

        $arguments = [];
        foreach ($parameters as $parameter) {
            if ($parameter->hasType()) {
                $parameterType = $parameter->getType();
                if ($parameterType instanceof ReflectionNamedType) {
                    $parameterTypeName = $parameterType->getName();

                    if ($parameterTypeName === Request::class) {
                        $arguments[] = $request;
                    } else {
                        $arguments[] = null;
                    }
                } else {
                    $arguments[] = null;
                }
            } else {
                $arguments[] = null;
            }
        }

        $controllerResponse = $reflectionMethod->invokeArgs($controller, $arguments);

        if ($controllerResponse instanceof Response) {
            return $controllerResponse;
        }

        return new Response(200, $controllerResponse);
    }

    protected static function sendResponse(Response $response): void
    {
        header('Content-Type: application/json');

        http_response_code($response->getStatusCode());

        foreach ($response->getHeaders() as $name => $value) {
            header("$name: $value");
        }
        echo $response->getBody();
    }

    private static function applyMiddleware($type, $route, $request, \Closure $next): void
    {
        $middlewares = $route[$type] ?? [];

        $finalMiddleware = function ($request) use ($next) {
            return $next($request);
        };

        foreach (array_reverse($middlewares) as $middleware) {
            $finalMiddleware = function ($request) use ($middleware, $finalMiddleware) {
                $middlewareInstance = new $middleware();
                return $middlewareInstance->handle($request, $finalMiddleware);
            };
        }

        $finalMiddleware($request);
    }
}