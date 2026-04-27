<?php
namespace Middlewares;
use Src\Request;
class SpecialCharsMiddleware {
    public function handle(Request $request): Request {
        foreach ($request->all() as $k => $v) {
            if (is_string($v)) $request->set($k, htmlspecialchars($v, ENT_QUOTES, 'UTF-8'));
        }
        return $request;
    }
}