<?php

namespace MounirSoft\Container;

interface IBundle {
    public function register(BundleManager $bundleManager);
}