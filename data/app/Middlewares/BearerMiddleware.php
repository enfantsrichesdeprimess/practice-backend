<?php
namespace Middlewares;

use Src\Auth\Auth;
use Src\Request;
use Src\View;

class BearerMiddleware
{
    public function handle(Request $request): void
    {
        if (Auth::attemptToken($request->bearerToken())) {
            return;
        }

        (new View())->toJSON([
            'message' => 'Требуется Bearer token',
        ], 401);
    }
}
