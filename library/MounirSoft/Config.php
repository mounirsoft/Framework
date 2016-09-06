<?php

namespace MounirSoft;

class Config extends \ArrayObject {

    public function __construct(array $array) {
        parent::__construct($array, \ArrayObject::ARRAY_AS_PROPS);
    }

}