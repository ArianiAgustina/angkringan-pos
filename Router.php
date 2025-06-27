<?php
// app/Core/Router.php

class Router {
    protected $controller = 'HomeController';
    protected $method = 'index';
    protected $params = [];

    public function route() {
        // Ambil parameter URL: format: /controller/method/param1/param2/...
        $url = isset($_GET['url']) ? rtrim($_GET['url'], '/') : '';
        $url = filter_var($url, FILTER_SANITIZE_URL);
        $segments = explode('/', $url);
        
        // Controller
        if (isset($segments[0]) && file_exists(BASE_PATH . '/app/Controllers/' . ucfirst($segments[0]) . 'Controller.php')) {
            $this->controller = ucfirst($segments[0]) . 'Controller';
            unset($segments[0]);
        }
        require_once BASE_PATH . '/app/Controllers/' . $this->controller . '.php';
        $this->controller = new $this->controller;

        // Method
        if (isset($segments[1])) {
            if (method_exists($this->controller, $segments[1])) {
                $this->method = $segments[1];
                unset($segments[1]);
            }
        }

        // Params
        $this->params = array_values($segments);

        // Jalankan controller->method(params...)
        call_user_func_array([$this->controller, $this->method], $this->params);
    }
}
