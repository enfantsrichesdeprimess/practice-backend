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
        $this->headers = function_exists('getallheaders') ? (getallheaders() ?: []) : $this->buildHeadersFromServer();
    }

    public function all(): array { return $this->body; }
    public function set($field, $value): void { $this->body[$field] = $value; }
    public function get($field) { return $this->body[$field] ?? null; }
    public function file(string $field): ?array { return $this->files[$field] ?? null; }
    public function header(string $name): ?string {
        $headers = array_change_key_case($this->headers, CASE_LOWER);
        return $headers[strtolower($name)] ?? null;
    }
    public function bearerToken(): ?string {
        $header = $this->header('Authorization');
        if (!$header || stripos($header, 'Bearer ') !== 0) {
            return null;
        }
        return trim(substr($header, 7));
    }
    public function hasFile(string $field): bool {
        $file = $this->file($field);
        return is_array($file) && ($file['error'] ?? UPLOAD_ERR_NO_FILE) === UPLOAD_ERR_OK;
    }

    public function __get($key) {
        if (array_key_exists($key, $this->body)) return $this->body[$key];
        throw new Error('Accessing a non-existent property');
    }

    private function buildHeadersFromServer(): array
    {
        $headers = [];
        foreach ($_SERVER as $key => $value) {
            if (str_starts_with($key, 'HTTP_')) {
                $name = str_replace('_', '-', strtolower(substr($key, 5)));
                $headers[implode('-', array_map('ucfirst', explode('-', $name)))] = $value;
            }
        }
        return $headers;
    }
}
