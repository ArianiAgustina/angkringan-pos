<?php
// app/Core/Controller.php

class Controller {
    public function model($modelName) {
        require_once BASE_PATH . '/app/Models/' . $modelName . '.php';
        return new $modelName();
    }

    public function view($viewName, $data = []) {
        // Buat file view: /app/Views/{viewName}.php
        extract($data); // Memecah array $data menjadi variabel
        require_once BASE_PATH . '/app/Views/' . $viewName . '.php';
    }

    // Redirect helper
    public function redirect($url) {
        header('Location: ' . $url);
        exit;
    }
}
