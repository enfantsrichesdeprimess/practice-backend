<?php
namespace Middlewares;
use Exception;
use Src\Request;
use Src\Session;

class CSRFMiddleware {
    public function handle(Request $request): void {
        if ($request->method !== 'POST') return;
        $token = $request->get('csrf_token');
        if (!$token || $token !== Session::get('csrf_token')) throw new Exception('CSRF token invalid');
    }
}