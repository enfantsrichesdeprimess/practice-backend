<?php 
namespace Src; 
use Error; 

class Settings 
{ 
   private array $_settings; 
   public function __construct(array $settings = []) 
   { 
       $this->_settings = $settings; 
   } 
   public function __get($key) 
   { 
       if (array_key_exists($key, $this->_settings)) { 
           return $this->_settings[$key]; 
       } 
       throw new Error('Accessing a non-existent property'); 
   } 
   public function getRootPath(): string 
   { 
       $configured = trim((string)($this->path['root'] ?? ''), '/');
       if ($configured !== '') {
           return '/' . $configured;
       }

       $scriptDir = str_replace('\\', '/', dirname($_SERVER['SCRIPT_NAME'] ?? ''));
       if ($scriptDir === '.' || $scriptDir === '/') {
           return '';
       }

       if (str_ends_with($scriptDir, '/public')) {
           $scriptDir = substr($scriptDir, 0, -7);
       }

       return rtrim($scriptDir, '/');
   } 
   public function getViewsPath(): string
   {
       return '/' . ($this->path['views'] ?? '');
   }
   public function getRoutePath(): string
   {
       return '/' . ($this->path['routes'] ?? 'routes');
   }
   public function getProjectPath(): string
   {
       return dirname(__DIR__, 2);
   }
   public function getPublicPath(): string
   {
       return $this->getProjectPath() . '/public';
   }
   public function getDbSetting(): array 
   { 
       return $this->db ?? []; 
   } 
   public function getAuthClassName(): string
   {
       return $this->app['auth'] ?? \Src\Auth\Auth::class;
   }
   public function getIdentityClassName(): string
   {
       return $this->app['identity'] ?? \Model\User::class;
   }
   public function removeAppMiddleware(string $key): void
   {
       unset($this->_settings['app']['routeAppMiddleware'][$key]);
   }
} 
