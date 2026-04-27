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
        $projectRoot = dirname($_SERVER['DOCUMENT_ROOT']);
        $root = $app->settings->getRootPath();
        $path = $app->settings->getViewsPath();
        return $projectRoot . $root . $path;
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

            echo "<!-- DEBUG: Main=$mainPath, View=$path -->\n";
            
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
            
            echo "<!-- DEBUG: Content length=" . strlen($content) . " -->\n";
            
            ob_start();
            require $mainPath;
            return ob_get_clean();
        }

    public function __toString(): string {
        return $this->render($this->view, $this->data);
    }
}