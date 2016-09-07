<?php

namespace MounirSoft\Container;

class Bundle implements IBundle {
    
    public function register(\MounirSoft\Container $container) {
        $container->set('MounirSoft\Config', function () {
            return new \MounirSoft\Config();
        });
        $container->set('MounirSoft\Request', function () {
            return new \MounirSoft\Request();
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
            return new \MounirSoft\View();
        });
        
        /*$container->singleton('database', function ($container) {
            return new Acme\Database('username', 'password', 'host', 'database');
        });*/
        
    }
    
}