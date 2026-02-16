<?php

namespace App\Core;

class Controller
{
    protected function view($name, $data = [])
    {
        extract($data);
        $viewFile = dirname(dirname(__DIR__)) . "/templates/{$name}.php";
        
        if (file_exists($viewFile)) {
            require_once $viewFile;
        } else {
            die("View {$name} not found");
        }
    }
}
