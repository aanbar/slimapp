<?php

namespace App\Core;

class Container extends \Slim\Container
{

    public function has($id)
    {
        $className = 'App\Controllers\\'.$id;
        if ( class_exists($className) ) {
            $this->offsetSet($id, function () use ($id) {
                $className = "App\Controllers\\{$id}";
                return new $className($this);
            });
            return true;
        }
        return parent::has($id);
    }
}