<?php

namespace App\Controllers;


use Slim\Container;

class BaseController
{

    protected $container;

    public function __construct(Container $container)
    {
        $this->container = $container;
    }


    public function __get($method)
    {
        if ( $this->container->has($method) ) {
            return $this->container->get($method);
        }
    }
}