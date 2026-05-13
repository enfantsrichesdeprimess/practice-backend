<?php
namespace Providers;

use Src\Provider\AbstractProvider;
use Src\Settings;

class KernelProvider extends AbstractProvider
{
    public function register(): void
    {
        $this->app->bind('settings', new Settings($this->app->getConfig()));
    }

    public function boot(): void
    {
    }
}
