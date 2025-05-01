<?php

class App
{
    protected $controller = 'Home';
    protected $method = 'index';
    protected $params = [];
    protected $basePath;

    public function __construct()
    {
        $this->basePath = dirname(dirname(__FILE__)) . '/controllers/';

        $url = $this->parseURL();

        if (isset($url[0])) {
            $controllerFile = $this->basePath . ucfirst($url[0]) . '.php';
            if (file_exists($controllerFile)) {
                $this->controller = ucfirst($url[0]);
                unset($url[0]);
            } else {
                error_log("Controller not found: " . $controllerFile);
                
                header('Location: ' . BASE_URL . '/error/notfound');
                exit;
            }
        }

        require_once $this->basePath . $this->controller . '.php';
        $this->controller = new $this->controller;

        if (isset($url[1])) {
            if (method_exists($this->controller, $url[1])) {
                $this->method = $url[1];
                unset($url[1]);
            } else {
                error_log("Method not found: " . $url[1] . " in controller " . get_class($this->controller));
                
                header('Location: ' . BASE_URL . '/error/notfound');
                exit;
            }
        }

        $this->params = $url ? array_values($url) : [];

        try {
            call_user_func_array([$this->controller, $this->method], $this->params);
        } catch (\Exception $e) {
            
            error_log("Error executing controller method: " . $e->getMessage());
            
            header('Location: ' . BASE_URL . '/error/server');
            exit;
        }
    }

    protected function parseURL()
    {
        if (isset($_GET['url'])) {
            $url = rtrim($_GET['url'], '/');
            $url = filter_var($url, FILTER_SANITIZE_URL);

            $url = strtolower($url);

            $url = explode('/', $url);

            $url = array_map(function ($segment) {
                return preg_replace('/[^a-z0-9_-]/i', '', $segment);
            }, $url);

            return array_filter($url);
        }
        return [];
    }
}