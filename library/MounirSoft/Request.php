<?php

namespace MounirSoft;

class Request {

    const METHOD_HEAD = 'HEAD';
    const METHOD_GET = 'GET';
    const METHOD_POST = 'POST';
    const METHOD_PUT = 'PUT';
    const METHOD_PATCH = 'PATCH';
    const METHOD_DELETE = 'DELETE';
    const METHOD_OPTIONS = 'OPTIONS';

    private $_params = array();

    public function __construct() {
        $this->_params = explode('/', $this->getServer('QUERY_STRING'));
        //http://stackoverflow.com/questions/30298189/parse-string-into-array-of-key-value-in-php
    }

    private function getValue(array $collection, $key, $default) {
        if(null === $key) {
            return $collection;
        }
        return isset($collection[$key]) ? $collection[$key] : $default;
    }

    public function getServer($key = null, $default = null) {
        return $this->getValue($_SERVER, $key, $default);
    }

    public function getQuery($key = null, $default = null) {
        return $this->getValue($_GET, $key, $default);
    }

    public function getPost($key = null, $default = null) {
        return $this->getValue($_POST, $key, $default);
    }

    public function getFile($key = null, $default = null) {
        return $this->getValue($_FILES, $key, $default);
    }

    public function getRequest($key = null, $default = null) {
        return $this->getValue($_REQUEST, $key, $default);
    }

    public function getSession($key = null, $default = null) {
        return $this->getValue($_SESSION, $key, $default);
    }

    public function getEnv($key = null, $default = null) {
        return $this->getValue($_ENV, $key, $default);
    }

    public function getCookie($key = null, $default = null) {
        return $this->getValue($_COOKIE, $key, $default);
    }

    public function getHeader($key = null, $default = null) {
        return $this->getValue(apache_request_headers(), $key, $default);
    }

    public function getMethod() {
        return $this->getServer('REQUEST_METHOD');
    }
    
    public function isGet() {
        return $this->getMethod() === self::METHOD_GET;
    }

    public function isPost() {
        return $this->getMethod() === self::METHOD_POST;
    }

    public function isPut() {
        return $this->getMethod() === self::METHOD_PUT;
    }

    public function isPatch() {
        return $this->getMethod() === self::METHOD_PATCH;
    }
    
    public function isDelete() {
        return $this->getMethod() === self::METHOD_DELETE;
    }

    public function isHead() {
        return $this->getMethod() === self::METHOD_HEAD;
    }

    public function isOptions() {
        return $this->getMethod() === self::METHOD_OPTIONS;
    }
    
    public function isAjax() {
        return ($this->getHeader('X_REQUESTED_WITH') == 'XMLHttpRequest');
    }

    public function getClientIp($checkProxy = true) {
        if ($checkProxy && $this->getServer('HTTP_CLIENT_IP') != null) {
            $ip = $this->getServer('HTTP_CLIENT_IP');
        } else if ($checkProxy && $this->getServer('HTTP_X_FORWARDED_FOR') != null) {
            $ip = $this->getServer('HTTP_X_FORWARDED_FOR');
        } else {
            $ip = $this->getServer('REMOTE_ADDR');
        }
        return $ip;
    }

    public function getParams() {
        return $this->_params;
    }

    public function setParams($params) {
        $this->_params = $params;
    }

}