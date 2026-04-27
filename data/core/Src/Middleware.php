<?php
namespace Src;
use Src\Traits\SingletonTrait;
use FastRoute\RouteCollector;
use FastRoute\RouteParser\Std;
use FastRoute\DataGenerator\MarkBased;
use FastRoute\Dispatcher\MarkBased as Dispatcher;

class Middleware {
    use SingletonTrait;
    private RouteCollector $middlewareCollector;

    private function __construct() {
        $this->middlewareCollector = new RouteCollector(new Std(), new MarkBased());
    }

    public function add($httpMethod, string $route, array $action): void {
        $this->middlewareCollector->addRoute($httpMethod, $route, $action);
    }

    public function group(string $prefix, callable $callback): void {
        $this->middlewareCollector->addGroup($prefix, $callback);
    }

    public function runMiddlewares(string $httpMethod, string $uri, Request $request): Request {
        $routeMiddleware = app()->settings->app['routeMiddleware'] ?? [];
        foreach ($this->getMiddlewaresForRoute($httpMethod, $uri) as $middleware) {
            $args = explode(':', $middleware);
            if (isset($routeMiddleware[$args[0]])) {
                $request = (new $routeMiddleware[$args[0]])->handle($request, $args[1] ?? null) ?? $request;
            }
        }
        return $request;
    }

    public function go(string $httpMethod, string $uri, Request $request): Request {
        return $this->runMiddlewares($httpMethod, $uri, $this->runAppMiddlewares($request));
    }

    private function runAppMiddlewares(Request $request): Request {
        $routeAppMiddleware = app()->settings->app['routeAppMiddleware'] ?? [];
        foreach ($routeAppMiddleware as $name => $class) {
            $request = (new $class)->handle($request) ?? $request;
        }
        return $request;
    }

    private function getMiddlewaresForRoute(string $httpMethod, string $uri): array {
        $dispatcherMiddleware = new Dispatcher($this->middlewareCollector->getData());
        return $dispatcherMiddleware->dispatch($httpMethod, $uri)[1] ?? [];
    }
}