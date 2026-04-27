<?php 
return [ 
   //Класс аутентификации 
   'auth' => \Src\Auth\Auth::class, 
   //Клас пользователя 
   'identity'=>\Model\User::class,
   //Классы для middleware 
   'routeMiddleware' => [ 
       'auth' => \Middlewares\AuthMiddleware::class,
       'role' => \Middlewares\RoleMiddleware::class,  
   ],
   'validators' => [
        'required' => \Src\Validator\RequireValidator::class,
        'unique' => \Src\Validator\UniqueValidator::class,
        'min' => \Src\Validator\MinValidator::class,
        'in' => \Src\Validator\InValidator::class,
        'date' => \Src\Validator\DateValidator::class,
    ],
]; 
