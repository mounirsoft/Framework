<?php

namespace MounirSoft\Container;

use Closure;
use Exception;
use ArrayAccess;
use ReflectionClass;
use ReflectionMethod;
use ReflectionFunction;
use ReflectionParameter;

class BundleManager implements ArrayAccess {

    protected $bindings = array();
    protected $instances = array();
    protected $aliasses = array();
    
    public function getInstances() {
        return $this->instances;
    }

    public function getBindings() {
        return $this->bindings;
    }

    public function instance($name, $instance) {
        return $this->instances[$name] = $instance;
    }

    public function alias($name, $alias) {
        $this->aliasses[$alias] = $name;
    }

    public function singleton($abstract, $concrete = null) {
        $this->bind($abstract, $concrete, true);
    }

    public function share(Closure $closure) {
        return function ($container) use ($closure) {
            static $instance;
            if (is_null($instance)) {
                $instance = $closure($container);
            }
            return $instance;
        };
    }

    public function bindShared($abstract, Closure $closure) {
        $this->bind($abstract, $this->share($closure), true);
    }

    public function bind($abstract, $concrete = null, $shared = false) {

        if (is_null($concrete)) {
            $concrete = $abstract;
        }

        if (!$concrete instanceof Closure) {
            $concrete = $this->getClosure($abstract, $concrete);
        }

        $this->bindings[$abstract] = compact('concrete', 'shared');
    }

    protected function getClosure($abstract, $concrete) {
        return function ($c, $parameters = []) use ($abstract, $concrete) {
            $method = ($abstract == $concrete) ? 'build' : 'make';
            return $c->$method($concrete, $parameters);
        };
    }

    public function make($abstract, array $parameters = []) {
        $abstract = $this->getAlias($abstract);

        if (isset($this->instances[$abstract])) {
            return $this->instances[$abstract];
        }

        $concrete = $this->getConcrete($abstract);
        
        if ($this->isBuildable($concrete, $abstract)) {
            $object = $this->build($concrete, $parameters);
        } else {
            $object = $this->make($concrete, $parameters);
        }

        if ($this->isShared($abstract)) {
            $this->instances[$abstract] = $object;
        }

        return $object;
    }

    public function build($concrete, array $parameters = []) {

        if ($concrete instanceof Closure) {
            return $concrete($this, $parameters);
        }
        
        $reflector = new ReflectionClass($concrete);

        if (!$reflector->isInstantiable()) {
            throw new Exception("Failed to instantiate [".$concrete."]");
        }

        $constructor = $reflector->getConstructor();

        if (is_null($constructor)) {
            return new $concrete;
        }

        $dependencies = $constructor->getParameters();

        $parameters = $this->keyParametersByArgument(
                $dependencies, $parameters
        );

        $instances = $this->getDependencies(
                $dependencies, $parameters
        );

        return $reflector->newInstanceArgs($instances);
    }
    
    protected function keyParametersByArgument(array $dependencies, array $parameters) {
        foreach ($parameters as $key => $value) {
            if (is_numeric($key)) {
                unset($parameters[$key]);
                $parameters[$dependencies[$key]->name] = $value;
            }
        }
        return $parameters;
    }

    protected function getDependencies(array $parameters, array $primitives = []) {
        $dependencies = [];
        foreach ($parameters as $parameter) {
            $dependency = $parameter->getClass();
            if (array_key_exists($parameter->name, $primitives)) {
                $dependencies[] = $primitives[$parameter->name];
            } elseif (is_null($dependency)) {
                $dependencies[] = $this->resolveNonClass($parameter);
            } else {
                $dependencies[] = $this->resolveClass($parameter);
            }
        }
        return (array) $dependencies;
    }

    protected function resolveNonClass(ReflectionParameter $parameter) {
        if ($parameter->isDefaultValueAvailable()) {
            return $parameter->getDefaultValue();
        }
        throw new Exception("Unresolvable dependency resolving [$parameter] in class {$parameter->getDeclaringClass()->getName()}");
    }

    protected function resolveClass(ReflectionParameter $dependency) {
        $class = $dependency->getClass()->name;
        try {
            return $this->make($class);
        } catch (ClassResolveException $e) {
            if ($dependency->isDefaultValueAvailable()) {
                return $dependency->getDefaultValue();
            }
            throw $e;
        }
    }

    protected function getAlias($abstract) {
        return isset($this->aliases[$abstract]) ? $this->aliases[$abstract] : $abstract;
    }

    protected function getConcrete($abstract) {
        return isset($this->bindings[$abstract]) ? $this->bindings[$abstract]['concrete'] : $abstract;
    }

    protected function isBuildable($concrete, $abstract) {
        return $concrete === $abstract || $concrete instanceof Closure;
    }

    public function isShared($abstract) {
        $shared = isset($this->bindings[$abstract]['shared']) ? $this->bindings[$abstract]['shared'] : false;
        return isset($this->instances[$abstract]) || $shared === true;
    }

    public function flush() {
        $this->_aliasses = [];
        $this->_bindings = [];
        $this->_instances = [];
    }
    
    public function offsetExists($key) {
        return isset($this->bindings[$key]);
    }
    
    public function offsetGet($key) {
        return $this->make($key);
    }
    
    public function offsetSet($key, $value) {
        if (!$value instanceof Closure) {
            $value = function () use ($value) {
                return $value;
            };
        }
        $this->bind($key, $value);
    }
    
    public function offsetUnset($key) {
        unset($this->bindings[$key], $this->_instances[$key]);
    }

    public function get($key) {
        return $this[$key];
    }

    public function set($key, $value) {
        $this[$key] = $value;
    }
    
    public function register(IBundle $bundle) {
        $bundle->register($this);
    }

}