<?php

namespace MounirSoft;

class Router {

    private $controller = null;
    private $action = null;
    private $params = array();

    public function __construct(Request $request) {
        $params = $request->getParams();
        $this->setController(array_shift($params));
        $this->setAction(array_shift($params));
        $this->setParams($params);
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
        return $this->params;
    }

    public function setParams($params) {
        $size = count($params);
        for ($i = 0; $i < $size; $i += 2) {
            if (isset($params[$i+1])) {
                $this->params[$params[$i]] = $params[$i+1];
            }
        }
    }

}