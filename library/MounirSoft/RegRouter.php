<?php

namespace MounirSoft;

class RegRouter {

    private $routes = array();

    public function route($pattern, $callback) {
        $this->routes[$pattern] = $callback;
    }

    public function run($uri) {
        foreach ($this->routes as $pattern => $callback) {
            if (preg_match('#^' . $pattern . '$#', '/'.trim($uri, '/'), $params) === 1) {
                array_shift($params);
                return call_user_func_array($callback, array_values($params));
            }
        }
    }

    /*
        $router = new RegRouter();
        $router->add('/blog/(\w+)/(\d+)', function($category, $id){
            echo $category . ':' . $id;
        });

        $router->run($_SERVER['REQUEST_URI']);
    */

}