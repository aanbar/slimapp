<?php

namespace App\Middleware;


use App\Core\Container;

class Middleware
{
    protected $container;

    public function __construct(Container $container)
    {
        $this->container = $container;
    }
}