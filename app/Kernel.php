<?php

namespace App;

class Kernel
{
    private $excludeAutowires = [
        'App\\Model',
    ];

    public function __construct()
    {
        $container = new Container($this->excludeAutowires);
    }
}
