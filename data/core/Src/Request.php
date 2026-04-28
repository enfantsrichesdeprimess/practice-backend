<?php
namespace Src;
use Error;

class Request {
    protected array $body;
    protected array $files;
    public string $method;
    public array $headers;

    public function __construct() {
        $this->method = $_SERVER['REQUEST_METHOD'];
        $this->body = $this->method === 'GET' ? $_GET : $_POST;
        $this->files = $_FILES ?? [];
        $this->headers = getallheaders() ?? [];
    }

    public function all(): array { return $this->body; }
    public function set($field, $value): void { $this->body[$field] = $value; }
    public function get($field) { return $this->body[$field] ?? null; }
    public function file(string $field): ?array { return $this->files[$field] ?? null; }
    public function hasFile(string $field): bool {
        $file = $this->file($field);
        return is_array($file) && ($file['error'] ?? UPLOAD_ERR_NO_FILE) === UPLOAD_ERR_OK;
    }

    public function __get($key) {
        if (array_key_exists($key, $this->body)) return $this->body[$key];
        throw new Error('Accessing a non-existent property');
    }
}
