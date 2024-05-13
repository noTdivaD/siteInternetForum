<?php
class App {
    protected $controller = 'HomeController';
    protected $method = 'index';
    protected $params = [];

    public function __construct() {
        $url = $this->parseUrl();

        // Déterminer le contrôleur à partir de l'URL, ou utiliser le contrôleur par défaut
        $controllerName = $this->controller;
        if (!empty($url)) {
            $controllerName = ucfirst($url[0]) . 'Controller';
            $controllerPath = __DIR__ . "/../controller/" . $controllerName . ".php";

            if (file_exists($controllerPath)) {
                require_once $controllerPath;
                unset($url[0]);
            } else {
                $controllerName = $this->controller; // fallback to default controller
                require_once __DIR__ . "/../controller/" . $controllerName . ".php";
            }
        } else {
            require_once __DIR__ . "/../controller/" . $controllerName . ".php";
        }

        if (class_exists($controllerName)) {
            $this->controller = new $controllerName;

            // Déterminer la méthode à appeler
            if (isset($url[1]) && method_exists($this->controller, $url[1])) {
                $this->method = $url[1];
                unset($url[1]);
            }

            // Obtenir les paramètres restants de l'URL
            $this->params = $url ? array_values($url) : [];

            // Appeler la méthode du contrôleur avec les paramètres
            call_user_func_array([$this->controller, $this->method], $this->params);
        } else {
            // handle error if class does not exist
            throw new Exception("Controller class '$controllerName' not found.");
        }
    }

    private function parseUrl() {
        if (isset($_GET['url'])) {
            return explode('/', filter_var(rtrim($_GET['url'], '/'), FILTER_SANITIZE_URL));
        }
        return [];
    }
}
