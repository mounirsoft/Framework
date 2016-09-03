<?php

namespace MounirSoft;

use DebugBar\StandardDebugBar;

require_once 'Loader.php';
require_once 'Container.php';

class Application {

    protected $_container = null;
    protected $_loader = null;

    public function __construct() {
        $this->_container = new Container();
        $this->_loader = new Loader();
        $this->_container->set('Request' , function () {
            return new Request();
        });
        $this->_container->set('Router' , function ($c) {
            return new Router($c->get('Request'));
        });
    }
    
    public function run() {
        
        $debugbar = new StandardDebugBar();
        $debugbarRenderer = $debugbar->getJavascriptRenderer();

        $debugbar["messages"]->addMessage("hello world!");

        
        $controller = $this->_container->get('Router')->getControllerClass();
        $controller = new $controller();
        
        $view = new View();
        $view->setDebugbarRenderer($debugbarRenderer);
        $view->setController($this->_container->get('Router')->getController());
        $view->setAction($this->_container->get('Router')->getAction());
        
        $controller->setView($view);
        
        $controller->{$this->_container->get('Router')->getActionMethod()}();
        
        echo $controller->getView()->render();
        
        
        //)->{$this->_container->get('Router')->getActionMethod()}();
        
        /*$router = $this['MounirSoft\Router'];
        $ctrl_class = $router->getControllerClass();
        $act_method = $router->getActionMethod();
        
        $controller = new $ctrl_class();
        $controller->setView($this['MounirSoft\View']);
        
        $controller->$act_method();
        
        echo $controller->getView()->render();*/




    	/*$this->singleton($controller, function($c) use ($controller) {
    		
    		$ctrl = new $controller($c);
    		
    		$ctrl->setView($c);
    		
    		return $ctrl;
    	});*/
    	
    	
    	//print_r($this);
    	
		//$response = $this->get($controller)->{$this->get('MounirSoft\Router')->getAction()}('mounirrrrrrrrrrr');
    	
    	
    	//$response = new $controller();
    	//$response->{$this->get('MounirSoft\Router')->getAction()}('mounirrrrrrrrrrr');
    	
    	//echo '<pre>';
        //print_r(array($this->get('MounirSoft\Router')->getController(), $this->get('MounirSoft\Router')->getAction(), $this->get('MounirSoft\Router')->getParams()));
    	
    	//$request = new Request(new Session());
        //$uri = parse_url('http://dummy'.$_SERVER['REQUEST_URI']);
        
        /*if (strpos($uri, $_SERVER['SCRIPT_NAME']) === 0) {
            $uri = (string) substr($uri, strlen($_SERVER['SCRIPT_NAME']));
        } elseif (strpos($uri, dirname($_SERVER['SCRIPT_NAME'])) === 0) {
            $uri = (string) substr($uri, strlen(dirname($_SERVER['SCRIPT_NAME'])));
        }*/
        
        //echo $uri['path'] . '<br />';
        //echo $_SERVER['SCRIPT_NAME'] . '<br />';
        //echo dirname(__FILE__) . '<br />';
        //echo substr(dirname(__FILE__), strlen($_SERVER['DOCUMENT_ROOT'])) . '<br />';
        
        //var_dump(substr($uri['path'], strlen(dirname($_SERVER['REQUEST_URI']))));
        
        /*if (version_compare(PHP_VERSION, '5.3.0') >= 0) {
            echo 'I am at least PHP version 5.3.0, my version: ' . PHP_VERSION . "\n";
        }*/
        
        //$token = new Token($request);
        //$token = $token->validate();
        
        //var_dump($request);
        //var_dump(pathinfo(__FILE__));
        //exit;
        
        //https://github.com/jaumemule/mpwarfwk/blob/bd60d4605159e1bae40443c2d44860400917d0a1/src/Mpwarfwk/Component/Session/Token.php
        
        /*if($token == true) {
            $Router = new Router($request);
            $ControllerUri = $Router->getRoute($request);
            $response = $this->executeController($ControllerUri, $request);
            return $response;
        } else {
            die();
        }*/
    }

    public function executeController(Route $route, Request $request) {
        $controller_class = $route->getRouteClass();
        return call_user_func_array(
            array(
                new $controller_class($request),
                $route->getRouteAction()
            ),
            array($request)
        );
    }
}