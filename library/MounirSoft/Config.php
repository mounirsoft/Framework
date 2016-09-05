<?php

namespace MounirSoft;

class Config {

    protected $_config = array();
    
    public function __construct($filename) {
        $this->_config = require $filename;
    }

    public function getConfigs() {
        return $this->_config;
    }

    public function get($key) {
        return $this->_config[$key];
    }

}