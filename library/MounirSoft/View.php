<?php

namespace MounirSoft;

class View {

    private $_viewDir = '';
    private $_layoutFile = 'layout.html';
    private $_layoutDir = '';
    private $_data = [];
    private $_controller;
    private $_action;
    private $_debugbarRenderer;

    public function __construct() {
        $this->_viewDir = ROOT_PATH . '/application/views/scripts';
        $this->_layoutDir = ROOT_PATH . '/application/views/layouts';
    }

    public function setController($controller) {
        $this->_controller = $controller;
    }
    
    public function getController() {
        return $this->_controller;
    }

    public function setAction($action) {
        $this->_action = $action;
    }
    
    public function getAction() {
        return $this->_action;
    }

    public function setDebugbarRenderer($debugbarRenderer) {
        $this->_debugbarRenderer = $debugbarRenderer;
    }
    
    public function getDebugbarRenderer() {
        return $this->_debugbarRenderer;
    }




    public function setTitle($title) {
        $this->_data['title'] = $title;
    }
    
    public function headTitle() {
        return isset($this->_data['title']) ? $this->_data['title'] : 'Sans Titre';
    }
    
    public function setStyle($style) {
        $this->_data['styles'] = $style;
    }
    
    public function getStyle() {
        return isset($this->_data['styles']) ? $this->_data['styles'] : array();
    }
    
    public function headStyle() {
        $__data = $this->getStyle();
        $__result = null;
        foreach($__data as $style) {
            $__result = $__result . '<link rel="stylesheet" type="text/css" href="' . $this->url('css/'.$style) . '">';
        }
        return $__result;
    }
    
    public function setScript($javascript) {
        $this->_data['javascript'] = $javascript;
    }
    
    public function getScript() {
        return isset($this->_data['javascript']) ? $this->_data['javascript'] : array();
    }
    
    public function headScript() {
        $__data = $this->getScript();
        $__result = null;
        foreach($__data as $script) {
            $__result = $__result . '<script type="text/javascript" src="' . $this->url('js/'.$script) . '"></script>';
        }
        return $__result;
    }
    
    
    protected function formatArray(array $data, $path = null) {
        foreach($data as $k => $v) {
            $data[$k] = rtrim($path, '/\\') .'/'.$v;
        }
        return $data;
    }
    
    public function url($file = null) {
        $baseUrl = $_SERVER['REQUEST_URI'] . 'public';
        if (null !== $file) {
            $file = '/' . ltrim($file, '/\\');
        }

        return $baseUrl . $file;
    }
    
    /*public function getHelper($helper) {
        $class = '\\Application\\Views\\helpers\\' . ucfirst($helper);
        return $this->container->get($class);
    }*/
    
    public function renderView() {
        $dir = strtolower($this->getController());
        $scriptfile = $this->getAction() . '.html';
        $file = $this->_viewDir . '/' . $dir . '/' . $scriptfile;
    
        ob_start();
        include $file;
        $content = ob_get_contents();
        ob_end_clean();
        return $content;
    }
    
    public function render() {
        $file =  $this->_layoutDir . '/' . $this->_layoutFile;
    
        ob_start();
        include $file;
        $layout = ob_get_contents();
        ob_end_clean();
        return $layout;
    }

}