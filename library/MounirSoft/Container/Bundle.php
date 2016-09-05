<?php

namespace MounirSoft\Container;

class Bundle implements IBundle {
    
    public function register(BundleManager $bundleManager) {
        $bundleManager->singleton('MounirSoft\Config');
        $bundleManager->singleton('MounirSoft\Request');
        $bundleManager->singleton('MounirSoft\Router' , function($c) {
            return new \MounirSoft\Router(
                array(
                    '/' => 'HomeController@index',
                    '/example' => 'HomeController@example',
                    '/blog/(\w+)/(\d+)' => 'BlogController@test'
                )
            );
        });
        $bundleManager->bind('MounirSoft\View');
        
        /*$bundleManager->singleton('database', function ($container) {
            return new Acme\Database('username', 'password', 'host', 'database');
        });*/
        
    }
    
}