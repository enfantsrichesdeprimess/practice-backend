<?php
namespace Middlewares;

use Src\Request;

class JSONMiddleware
{
    public function handle(Request $request): Request
    {
        $contentType = strtolower((string)$request->header('Content-Type'));
        if ($request->method === 'GET' || !str_contains($contentType, 'application/json')) {
            return $request;
        }

        $data = json_decode(file_get_contents('php://input'), true);
        if (!is_array($data)) {
            return $request;
        }

        foreach ($data as $key => $value) {
            $request->set($key, $value);
        }

        return $request;
    }
}
