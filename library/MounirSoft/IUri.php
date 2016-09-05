<?php

namespace MounirSoft;

interface IUri {
    public function __construct($uri);
    public function getCleanedURI();
}