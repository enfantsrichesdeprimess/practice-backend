<?php
namespace Providers;

use Src\Provider\AbstractProvider;
use Src\Route;

class RouteProvider extends AbstractProvider
{
    public function register(): void
    {
    }

    public function boot(): void
    {
        $this->app->bind('route', Route::single()->setPrefix($this->app->settings->getRootPath()));

        if ($this->checkPrefix('/api')) {
            $this->app->settings->removeAppMiddleware('csrf');
            $this->app->settings->removeAppMiddleware('specialchars');
            Route::group('/api', function () {
                require_once $this->app->settings->getProjectPath() . $this->app->settings->getRoutePath() . '/api.php';
            });
            return;
        }

        $this->app->settings->removeAppMiddleware('json');
        require_once $this->app->settings->getProjectPath() . $this->app->settings->getRoutePath() . '/web.php';
    }

    private function getUri(): string
    {
        $uri = rawurldecode(parse_url($_SERVER['REQUEST_URI'] ?? '/', PHP_URL_PATH) ?: '/');
        $root = $this->app->settings->getRootPath();

        if ($root !== '' && str_starts_with($uri, $root)) {
            $uri = substr($uri, strlen($root));
        }

        return $uri ?: '/';
    }

    private function checkPrefix(string $prefix): bool
    {
        return str_starts_with($this->getUri(), $prefix);
    }
}
