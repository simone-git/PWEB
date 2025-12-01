<?php


class Router {
    private $basePath;

    private $routes = [];


    function __construct(string $basePath) {
        $this->basePath = $basePath;

        $this->routes = [];
    }
    
    
    public function route(string $path, string $controller, string $action) {
        $this->routes[$path] = [$controller, $action];
    }


    function resolve(string $uri) {
        // Rimozione del BASE_URL
        if (!empty($this->basePath) && strpos($uri, $this->basePath) === 0) {
            $path = substr($uri, strlen($this->basePath));
        } else {
            $path = $uri;
        }
        

        // Rimuove eventuale "index.php" dalla URL e le variabili GET
        $path = trim($path, '/');
        $path = preg_replace('/^index(\.php)?$|\?[A-z0-9\-=&,%]+$/', '', $path);
        

        // Controllo sulle route
        if (isset($this->routes[$path])) {
            [$controller, $method] = $this->routes[$path];

            if (method_exists($controller, $method)) {
                return (new $controller)->$method();
            } else {
                return "Errore: il metodo '{$method}' non esiste in '{$controller}'";
            }
        }

        http_response_code(404);
        return "Pagina non trovata.";
        // return (new PagesController())->page404();
    }
}
