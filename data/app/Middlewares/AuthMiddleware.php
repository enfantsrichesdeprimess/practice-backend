<?php
namespace Middlewares;
use Src\Request;
use Src\Auth\Auth;

class AuthMiddleware {
    public function handle(Request $request): void {
        if (!Auth::check()) app()->route->redirect('/login');
    }
}