<?php
namespace Src;
use Error;

class Application 
{
    private array $config;
    private array $providers = [];
    private array $binds = [];

    public function __construct(array $config = []) 
    {
        $this->config = $config;
        $this->addProviders($config['app']['providers'] ?? []);
        $this->registerProviders();
        $this->bootProviders();
    }

    public function addProviders(array $providers): void
    {
        foreach ($providers as $key => $class) {
            $this->providers[$key] = new $class($this);
        }
    }

    private function registerProviders(): void
    {
        foreach ($this->providers as $provider) {
            $provider->register();
        }
    }

    private function bootProviders(): void
    {
        foreach ($this->providers as $provider) {
            $provider->boot();
        }
    }

    public function bind(string $key, $value): void
    {
        $this->binds[$key] = $value;
    }

    public function has(string $key): bool
    {
        return array_key_exists($key, $this->binds);
    }

    public function getConfig(): array
    {
        return $this->config;
    }

    public function __get($key) 
    {
        if ($this->has($key)) {
            return $this->binds[$key];
        }

        throw new Error('Accessing a non-existent property');
    }

    public function run(): void 
    {
        $this->route->start();
    }
}
