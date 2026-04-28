<?php
declare(strict_types=1);

session_start();

try {
    $app = require_once __DIR__ . '/../core/bootstrap.php';
    $app->run();
} catch (\Throwable $exception) {
    if ($exception->getMessage() === 'CSRF token invalid') {
        http_response_code(403);
        echo '<h1>Ошибка отправки формы</h1><p>Обновите страницу и повторите попытку.</p>';
        return;
    }

    http_response_code(500);
    echo '<h1>Ошибка приложения</h1><p>Во время обработки запроса произошла ошибка.</p>';
}
