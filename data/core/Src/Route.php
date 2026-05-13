<?php
namespace Src;
use Error;
use FastRoute\RouteCollector;
use FastRoute\RouteParser\Std;
use FastRoute\DataGenerator\MarkBased;
use FastRoute\Dispatcher\MarkBased as Dispatcher;
use Src\Traits\SingletonTrait;

class Route {
    use SingletonTrait;
    private string $prefix = '';
    private string $groupPrefix = '';
    private RouteCollector $routeCollector;
    private string $currentRoute = '';
    private $currentHttpMethod;

    private function __construct() {
        $this->routeCollector = new RouteCollector(new Std(), new MarkBased());
    }

    public static function add($httpMethod, string $route, array $action): self {
        $route = rtrim(self::single()->groupPrefix . $route, '/') ?: '/';
        self::single()->routeCollector->addRoute($httpMethod, $route, $action);
        self::single()->currentHttpMethod = $httpMethod;
        self::single()->currentRoute = $route;
        return self::single();
    }

    public static function group(string $prefix, callable $callback): void {
        $route = self::single();
        $previous = $route->groupPrefix;
        $route->groupPrefix .= $prefix;
        $callback();
        $route->groupPrefix = $previous;
    }

    public function setPrefix(string $value = ''): self {
        $this->prefix = $value;
        return $this;
    }

    public function redirect(string $url): void {
        header('Location: ' . $this->getUrl($url));
        exit();
    }

    public function getUrl(string $url): string {
        return $this->prefix . $url;
    }

    public function middleware(...$middlewares): self {
        Middleware::single()->add($this->currentHttpMethod, $this->currentRoute, $middlewares);
        return $this;
    }

    public function start(): void {
        $httpMethod = $_SERVER['REQUEST_METHOD'];
        $uri = rawurldecode(parse_url($_SERVER['REQUEST_URI'] ?? '/', PHP_URL_PATH) ?: '/');

        if ($this->prefix !== '' && str_starts_with($uri, $this->prefix)) {
            $uri = substr($uri, strlen($this->prefix));
        }

        $uri = rtrim($uri, '/') ?: '/';
        if (!str_starts_with($uri, '/')) {
            $uri = '/' . $uri;
        }

        $dispatcher = new Dispatcher($this->routeCollector->getData());
        $routeInfo = $dispatcher->dispatch($httpMethod, $uri);

        switch ($routeInfo[0]) {
            case Dispatcher::NOT_FOUND: throw new Error('NOT_FOUND');
            case Dispatcher::METHOD_NOT_ALLOWED: throw new Error('METHOD_NOT_ALLOWED');
            case Dispatcher::FOUND:
                $handler = $routeInfo[1];
                $vars = array_values($routeInfo[2]);
                $vars[] = Middleware::single()->go($httpMethod, $uri, new Request());
                $class = $handler[0];
                $action = $handler[1];
                $response = call_user_func([new $class, $action], ...$vars);
                if ($response !== null) {
                    echo $response;
                }
                break;
        }
    }
}
