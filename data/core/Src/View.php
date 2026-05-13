<?php
namespace Src;
use Exception;

class View {
    private string $view = '';
    private array $data = [];
    private string $root = '';
    private string $layout = '/layouts/main.php';

    public function __construct(string $view = '', array $data = []) {
        $this->root = $this->getRoot();
        $this->view = $view;
        $this->data = $data;
    }

    private function getRoot(): string {
        global $app;
        $projectRoot = $app->settings->getProjectPath();
        $path = $app->settings->getViewsPath();
        return $projectRoot . $path;
    }

    private function getPathToMain(): string { return $this->root . $this->layout; }
    private function getPathToView(string $view = ''): string {
        $view = str_replace('.', '/', $view);
        return $this->getRoot() . "/$view.php";
    }

    public function render(string $view = '', array $data = []): string
    {
        $targetView = $view ?: $this->view;
        $path = $this->getPathToView($targetView);
        $mainPath = $this->getPathToMain();

        if (!file_exists($mainPath)) {
            throw new Exception("Main layout NOT found: $mainPath");
        }

        if (!file_exists($path)) {
            throw new Exception("View NOT found: $path");
        }

        extract(array_merge($this->data, $data), EXTR_PREFIX_SAME, '');

        ob_start();
        require $path;
        $content = ob_get_clean();

        ob_start();
        require $mainPath;
        return ob_get_clean();
    }

    public function toJSON(array $data = [], int $code = 200): void
    {
        header_remove();
        header('Content-Type: application/json; charset=utf-8');
        http_response_code($code);
        echo json_encode($data, JSON_UNESCAPED_UNICODE);
        exit();
    }

    public function __toString(): string {
        return $this->render($this->view, $this->data);
    }
}
