<?php
declare(strict_types=1);

session_start();

try {
    $app = require_once __DIR__ . '/../core/bootstrap.php';
    $app->run();
} catch (\Throwable $exception) {
    $uri = parse_url($_SERVER['REQUEST_URI'] ?? '/', PHP_URL_PATH) ?: '/';
    $isApi = str_contains($uri, '/api');

    if ($isApi) {
        $status = match ($exception->getMessage()) {
            'NOT_FOUND' => 404,
            'METHOD_NOT_ALLOWED' => 405,
            'CSRF token invalid' => 403,
            default => 500,
        };

        http_response_code($status);
        header('Content-Type: application/json; charset=utf-8');
        echo json_encode([
            'error' => $status,
            'message' => $status === 500 ? 'Ошибка приложения' : $exception->getMessage(),
        ], JSON_UNESCAPED_UNICODE);
        return;
    }

    if ($exception->getMessage() === 'CSRF token invalid') {
        http_response_code(403);
        echo '<h1>Ошибка отправки формы</h1><p>Обновите страницу и повторите попытку.</p>';
        return;
    }

    http_response_code(500);
    echo '<h1>Ошибка приложения</h1><p>Во время обработки запроса произошла ошибка.</p>';
}
