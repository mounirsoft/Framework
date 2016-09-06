<?php

//https://github.com/ianlucas/dashboard/blob/eb888b1babfa6b4641574e0225a14ac1c326f979/core/Router.php

namespace MounirSoft;

class Router {

    private $_routes;
    private $_url_params;

    public function __construct($routes = array()) {
        $this->_routes = $routes;

        //$params = $request->getParams();
        //$this->setController(array_shift($params));
        //$this->setAction(array_shift($params));
        //$this->setParams($params);
        
        /*$this->_router = array(
            'controller' => '',
            'action' => '',
            'params' => array()
        );*/
        
    }

    public function parse($url) {
        
        $segments = explode('/', $url);
        
        $controller = array_shift($segments);
        $action = array_shift($segments);
        
        $this->_url_params = array(
            'controller' => !empty($controller) ? $controller : 'index',
            'action' => !empty($action) ? $action : 'index',
            'params' => $this->formatParams($segments)
        );
        
        return ($this->_url_params);
        
        /*foreach ($this->_routes as $pattern => $path) {
            
            
            
            
            if (preg_match('#^' . $pattern . '$#', '/'.trim($url, '/'), $params) === 1) {
                
                return $this->_routes[$pattern];
            
            }
        }*/
    
        /*foreach ($this->routes as $pattern => $callback) {
            if (preg_match('#^' . $pattern . '$#', '/'.trim($uri, '/'), $params) === 1) {
                array_shift($params);
                return call_user_func_array($callback, array_values($params));
            }
        }*/
    
    }

    public function get($key) {
        return $this->_url_params[$key];
    }

    public function setController($controller) {
        $this->controller = $controller;
    }

    public function getController() {
        return ((isset($this->controller) && !empty($this->controller)) ? strtolower($this->controller) : 'index');
    }

    public function getControllerClass() {
        return 'Application\Controllers\\' . ucfirst($this->getController()) . 'Controller';
    }

    public function setAction($action) {
        $this->action = $action;
    }

    public function getAction() {
        return (isset($this->action) && !empty($this->action)) ? strtolower($this->action) : 'index';
    }

    public function getActionMethod() {
        return $this->getAction() . 'Action';
    }

    public function getParams() {
        return $this->_url_params['params'];
    }

    public function formatParams($params) {
        $__tmp = array();
        $size = count($params);
        for ($i = 0; $i < $size; $i += 2) {
            $__tmp[array_shift($params)] = array_shift($params);
        }
        
        return $__tmp;
    }

    public function setParams($params) {
        $size = count($params);
        for ($i = 0; $i < $size; $i += 2) {
            if (isset($params[$i+1])) {
                $this->_url_params['params'][$params[$i]] = $params[$i+1];
            }
        }
    }

}