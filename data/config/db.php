<?php 

return [ 
   'driver' => 'mysql', 
   'host' => getenv('DB_HOST') ?: 'mariadb', 
   'database' => getenv('DB_DATABASE') ?: 'mvc', 
   'username' => getenv('DB_USERNAME') ?: 'root',
   'port' => getenv('DB_PORT') ?: '3306', 
   'password' => getenv('DB_PASSWORD') ?: 'root', 
   'charset' => 'utf8mb4', 
   'collation' => 'utf8mb4_unicode_ci', 
   'prefix' => '', 
]; 
