<?php 
return [ 
   //Класс аутентификации 
   'auth' => \Src\Auth\Auth::class, 
   //Клас пользователя 
   'identity'=>\Model\User::class,
   'providers' => [
       'kernel' => \Providers\KernelProvider::class,
       'route' => \Providers\RouteProvider::class,
       'db' => \Providers\DBProvider::class,
       'auth' => \Providers\AuthProvider::class,
   ],
   //Классы для middleware 
   'routeAppMiddleware' => [
       'json' => \Middlewares\JSONMiddleware::class,
       'trim' => \Middlewares\TrimMiddleware::class,
       'specialchars' => \Middlewares\SpecialCharsMiddleware::class,
       'csrf' => \Middlewares\CSRFMiddleware::class,
   ],
   'routeMiddleware' => [ 
       'auth' => \Middlewares\AuthMiddleware::class,
       'role' => \Middlewares\RoleMiddleware::class,  
       'bearer' => \Middlewares\BearerMiddleware::class,
   ],
]; 
