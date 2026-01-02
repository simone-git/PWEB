<?php

use App\Controllers\BaseController;

class Router {
    private $basePath;

    private $routes = [];


    function __construct(string $basePath) {
        $this->basePath = $basePath;

        $this->routes = [];
    }
    
    
    public function route(string $method, string $path, string $controller, string $action) {
        if(!isset($this->routes[$method]))
            $this->routes[$method] = [];

        $this->routes[$method][$path] = [$controller, $action];
    }


    public function resolve(string $uri) {
        try {
            // Rimozione del BASE_URL
            if (!empty($this->basePath) && strpos($uri, $this->basePath) === 0) {
                $path = substr($uri, strlen($this->basePath));
            } else {
                $path = $uri;
            }
            

            // Rimuove eventuale "index.php" dalla URL e le variabili GET
            $path = trim($path, '/');
            $path = preg_replace('/^index(\.php)?$|\?[A-z0-9\-=&,%]+$/', '', $path);
            

            $method = $_SERVER["REQUEST_METHOD"];

            // Controllo sulle route
            if (isset($this->routes[$method]) && isset($this->routes[$method][$path])) {
                [$controller, $method] = $this->routes[$method][$path];

                if (method_exists($controller, $method)) {
                    return (new $controller)->$method();
                } else {
                    return "Errore: il metodo '{$method}' non esiste in '{$controller}'";
                }
            }

            http_response_code(404);
            return "Pagina non trovata.";
            // return (new PagesController())->page404();
        } catch(Exception $e) {
            echo BaseController::httpResponse(["error" => $e->getMessage()], $e->getCode());
        } catch(Error $e) {
            echo BaseController::httpResponse(["error" => $e->getMessage()], $e->getCode());
        }
    }
}
