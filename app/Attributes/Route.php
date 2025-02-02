<?php

namespace App\Attributes;

#[\Attribute]
class Route
{
    public function __construct(public string $path, public string $method = 'GET') {}
}
