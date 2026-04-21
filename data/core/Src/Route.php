<?php
namespace Src;
use Error;

class Route
{
    private static array $routes = [];
    private static string $prefix = '';

    public static function setPrefix($value): void 
    { 
        self::$prefix = $value; 
    }

    public static function add(string $route, array $action): void 
    {
        if (!array_key_exists($route, self::$routes)) {
            self::$routes[$route] = $action;
        }
    }

    public function start(): void 
    { 
        $uri = $_SERVER['REQUEST_URI'] ?? '/';
        $uri = explode('?', $uri)[0];

        $prefix = self::$prefix;
        if ($prefix !== '' && strpos($uri, $prefix) === 0) {
            $path = substr($uri, strlen($prefix));
        } else {
            $path = $uri;
        }

        $path = ltrim($path, '/');

        if (!array_key_exists($path, self::$routes)) { 
            throw new Error('This path does not exist: ' . $path); 
        }
        
        $class = self::$routes[$path][0]; 
        $action = self::$routes[$path][1]; 
        
        if (!class_exists($class)) { 
            throw new Error('This class does not exist: ' . $class); 
        } 
        if (!method_exists($class, $action)) { 
            throw new Error('This method does not exist: ' . $action); 
        } 

        call_user_func([new $class, $action]); 
    }
}