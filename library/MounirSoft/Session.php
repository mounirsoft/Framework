<?php

namespace MounirSoft;

class Session extends \ArrayObject {

    public function __construct() {
        if (!\session_id()) {
            \session_name('sid');
            \session_start();
        }
        parent::__construct($_SESSION, \ArrayObject::ARRAY_AS_PROPS);
        \register_shutdown_function(array($this, 'commit'));
    }

    public function commit() {
        \session_unset();
        foreach ($this as $key => $value) {
            $_SESSION[$key] = $value;
        }
    }

}