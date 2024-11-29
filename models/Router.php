<?php
namespace Models;

use Controllers\ArticlesController;

class Router{

    private $routes = [];

    public function get($uri, $callback): void{
        $this->routes["GET"][$uri] = $callback;
    }

    public function post ($uri, $callback): void{
        $this->routes["POST"][$uri] = $callback;
    }

    public function run(): void{
        $uri = parse_url(url: $_SERVER["REQUEST_URI"], component: PHP_URL_PATH);
        $method = $_SERVER["REQUEST_METHOD"];

        if(!isset($this->routes[$method][$uri])){
            exit;
        }

        call_user_func(callback: $this->routes[$method][$uri]);
    }
}