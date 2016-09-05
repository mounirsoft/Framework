<?php

return [
    '/blog/(\w+)/(\d+)' => ['controller' => 'index','action'=>'index']
];

//$this->router->get('/', 'HomeController@index');
//$this->router->get('/example', 'HomeController@example');