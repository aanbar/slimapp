<?php

namespace App\Middleware;


use Slim\Http\Request;
use Slim\Http\Response;

class OldInputMiddleware extends Middleware
{

    public function __invoke(Request $request, Response $response, $next)
    {
        // grab validation errors from session & register it in views.
        $old_input = isset($_SESSION['_old_input']) ? $_SESSION['_old_input'] : null;
        $this->container->get('view')->getEnvironment()->addGlobal('old', $old_input);
        // overwrite old input on every request using current data
        $_SESSION['_old_input'] = $request->getParams();

        // pass state to next middleware
        return $next($request, $response);
    }
}