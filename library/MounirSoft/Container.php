<?php

namespace MounirSoft;

class Container {

    private $_values = array();
    private $_keys = array();

    public function set($id, $value) {
        $this->_values[$id] = $value;
        $this->_keys[$id] = true;
    }

    public function get($id) {
        if (!$this->has($id)) {
            throw new \InvalidArgumentException(sprintf('Identifier "%s" is not defined.', $id));
        }
        
        if (!is_object($this->_values[$id]) || !method_exists($this->_values[$id], '__invoke')) {
            return $this->_values[$id];
        }
        
        return $this->_values[$id]($this);
    }

    public function has($id) {
        return isset($this->_keys[$id]);
    }

    public function remove($id) {
        if ($this->has($id)) {
            unset($this->_values[$id], $this->_keys[$id]);
        }
    }

    public function keys() {
        return array_keys($this->_values);
    }

    public function register(Container\IBundle $provider) {
        $provider->register($this);
        return $this;
    }

}



/*class Container {

    private $values = array();
    private $factories;
    private $protected;
    private $frozen = array();
    private $raw = array();
    private $keys = array();

    public function __construct(array $values = array()) {
        $this->factories = new \SplObjectStorage();
        $this->protected = new \SplObjectStorage();
        foreach ($values as $key => $value) {
            $this->set($key, $value);
        }
    }

    public function set($id, $value) {
        if (isset($this->frozen[$id])) {
            throw new \RuntimeException(sprintf('Cannot override frozen service "%s".', $id));
        }
        $this->values[$id] = $value;
        $this->keys[$id] = true;
    }

    public function get($id) {
        if (!isset($this->keys[$id])) {
            throw new \InvalidArgumentException(sprintf('Identifier "%s" is not defined.', $id));
        }
        if (
            isset($this->raw[$id])
            || !is_object($this->values[$id])
            || isset($this->protected[$this->values[$id]])
            || !method_exists($this->values[$id], '__invoke')
        ) {
            return $this->values[$id];
        }
        if (isset($this->factories[$this->values[$id]])) {
            return $this->values[$id]($this);
        }
        $raw = $this->values[$id];
        $val = $this->values[$id] = $raw($this);
        $this->raw[$id] = $raw;
        $this->frozen[$id] = true;
        return $val;
    }

    public function has($id) {
        return isset($this->keys[$id]);
    }

    public function remove($id) {
        if (isset($this->keys[$id])) {
            if (is_object($this->values[$id])) {
                unset($this->factories[$this->values[$id]], $this->protected[$this->values[$id]]);
            }
            unset($this->values[$id], $this->frozen[$id], $this->raw[$id], $this->keys[$id]);
        }
    }

    public function factory($callable) {
        if (!method_exists($callable, '__invoke')) {
            throw new \InvalidArgumentException('Service definition is not a Closure or invokable object.');
        }
        $this->factories->attach($callable);
        return $callable;
    }

    public function protect($callable) {
        if (!method_exists($callable, '__invoke')) {
            throw new \InvalidArgumentException('Callable is not a Closure or invokable object.');
        }
        $this->protected->attach($callable);
        return $callable;
    }

    public function raw($id) {
        if (!isset($this->keys[$id])) {
            throw new \InvalidArgumentException(sprintf('Identifier "%s" is not defined.', $id));
        }
        if (isset($this->raw[$id])) {
            return $this->raw[$id];
        }
        return $this->values[$id];
    }

    public function extend($id, $callable) {
        if (!isset($this->keys[$id])) {
            throw new \InvalidArgumentException(sprintf('Identifier "%s" is not defined.', $id));
        }
        if (!is_object($this->values[$id]) || !method_exists($this->values[$id], '__invoke')) {
            throw new \InvalidArgumentException(sprintf('Identifier "%s" does not contain an object definition.', $id));
        }
        if (!is_object($callable) || !method_exists($callable, '__invoke')) {
            throw new \InvalidArgumentException('Extension service definition is not a Closure or invokable object.');
        }
        $factory = $this->values[$id];
        $extended = function ($c) use ($callable, $factory) {
            return $callable($factory($c), $c);
        };
        if (isset($this->factories[$factory])) {
            $this->factories->detach($factory);
            $this->factories->attach($extended);
        }
        return $this[$id] = $extended;
    }

    public function keys() {
        return array_keys($this->values);
    }

    public function register(Container\IBundle $provider, array $values = array()) {
        $provider->register($this);
        foreach ($values as $key => $value) {
            $this[$key] = $value;
        }
        return $this;
    }

}*/