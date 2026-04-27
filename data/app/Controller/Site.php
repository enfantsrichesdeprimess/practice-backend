<?php
namespace Controller;
use Src\View;

class Site {
    public function index(): string {
        return (new View('home'))->render();
    }
}