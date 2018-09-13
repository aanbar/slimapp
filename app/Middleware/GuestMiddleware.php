<?php

namespace App\Middleware;


use Slim\Http\Request;
use Slim\Http\Response;

class GuestMiddleware extends Middleware
{

    public function __invoke(Request $request, Response $response, $next)
    {
        if ($this->container->auth->check() ) {
            return $response->withRedirect($this->container->router->pathFor('admin.dashboard'));
        }
        // pass state to next middleware
        return $next($request, $response);
    }
}