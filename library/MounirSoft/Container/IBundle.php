<?php

namespace MounirSoft\Container;

interface IBundle {
    public function register(IContainer $container);
}