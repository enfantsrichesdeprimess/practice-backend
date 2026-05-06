<?php 
return [ 
   //Класс аутентификации 
   'auth' => \Src\Auth\Auth::class, 
   //Клас пользователя 
   'identity'=>\Model\User::class,
   //Классы для middleware 
   'routeAppMiddleware' => [
       'trim' => \Middlewares\TrimMiddleware::class,
       'specialchars' => \Middlewares\SpecialCharsMiddleware::class,
       'csrf' => \Middlewares\CSRFMiddleware::class,
   ],
   'routeMiddleware' => [ 
       'auth' => \Middlewares\AuthMiddleware::class,
       'role' => \Middlewares\RoleMiddleware::class,  
   ],
]; 
