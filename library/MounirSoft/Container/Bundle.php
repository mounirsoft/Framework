<?php

namespace MounirSoft\Container;

class Bundle implements IBundle {
    
    public function register(IContainer $container) {
        $container->set('MounirSoft\Loader', function () {
            return new Loader();
        });
        $container->set('MounirSoft\Config', function () {
            return new Config();
        });
        $container->set('MounirSoft\Request', function () {
            return new Request();
        });
        $container->set('MounirSoft\Router' , function() {
            return new \MounirSoft\Router(
                array(
                    '/' => 'HomeController@index',
                    '/example' => 'HomeController@example',
                    '/blog/(\w+)/(\d+)' => 'BlogController@test'
                )
            );
        });
        $container->set('MounirSoft\View', function () {
            return new View();
        });
        
        /*$container->singleton('database', function ($container) {
            return new Acme\Database('username', 'password', 'host', 'database');
        });*/
        
    }
    
}