<?php

namespace MounirSoft;

class Container {

    protected $_container = null;

    public function set($class, $closure) {
        $this->_container[$class] = $closure;
    }

    public function get($class) {
        return $this->_container[$class]($this);
    }

}