<?php

namespace App\Middleware;


use Slim\Http\Request;
use Slim\Http\Response;

class ValidationErrorsMiddleware extends Middleware
{

    public function __invoke(Request $request, Response $response, $next)
    {
        // grab validation errors from session & register it in views.
        $errors = isset($_SESSION['_validation_errors']) ? $_SESSION['_validation_errors'] : null;
        $this->container->get('view')->getEnvironment()->addGlobal('errors', $errors);
        // remove validation errors from session
        unset($_SESSION['_validation_errors']);
        // pass state to next middleware
        return $next($request, $response);
    }

}