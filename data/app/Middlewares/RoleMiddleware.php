<?php
namespace Middlewares;
use Src\Request;
use Src\Auth\Auth;

class RoleMiddleware {
    public function handle(Request $request, $role = null): void {
        if (!Auth::check()) app()->route->redirect('/login');
        if ($role && Auth::user()->role !== $role) die('Доступ запрещен: недостаточно прав.');
    }
}