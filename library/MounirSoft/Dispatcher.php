<?php

namespace MounirSoft;

class Dispatcher {
    
    public function __construct() {
        //https://github.com/agustincl/bcnjul2016/blob/9a9a2bf2055a7a3801d7a56086ace1aa228ae2b6/crud/public/Router.php
    }

    public function dispatch(Router $router) {
        
        $router->parse($_SERVER['QUERY_STRING']);
        
        $controller = $router->get('controller');
        $action =     $router->get('action');
        $params =     $router->get('params');
        
        
        
        
        
        return $router->parse($_SERVER['QUERY_STRING']);
        
    }

}