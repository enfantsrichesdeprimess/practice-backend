<?php
namespace Middlewares;
use Src\Request;
class TrimMiddleware {
    public function handle(Request $request): Request {
        foreach ($request->all() as $k => $v) {
            if (is_string($v)) $request->set($k, trim($v));
        }
        return $request;
    }
}