<?php

declare(strict_types=1);
// ВКЛЮЧАЕМ ВСЕ ОШИБКИ
error_reporting(E_ALL);
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);

session_start();

try {
    $app = require_once __DIR__ . '/../core/bootstrap.php';
    $app->run();
} catch (\Throwable $exception) {
    echo '<pre style="background:#f00;color:#fff;padding:20px;">';
    echo "ERROR: " . $exception->getMessage() . "\n\n";
    echo "File: " . $exception->getFile() . "\n";
    echo "Line: " . $exception->getLine() . "\n\n";
    echo "Stack trace:\n";
    echo $exception->getTraceAsString();
    echo '</pre>';
}