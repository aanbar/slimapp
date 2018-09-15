<?php

namespace App\Middleware;

use Slim\Http\Request;
use Slim\Http\Response;

class CsrfHandlerMiddleware extends Middleware
{

    protected $ignoreCsrf = [

    ];

    public function __invoke(Request $request, Response $response, $next)
    {
        $csrfNameKey    = $this->container->csrf->getTokenNameKey();
        $csrfName       = $this->container->csrf->getTokenName();
        $csrfValueKey   = $this->container->csrf->getTokenValueKey();
        $csrfValue      = $this->container->csrf->getTokenValue();

        // add csrf.field to twig templates for easier implementation
        $field = '<input type="hidden" name="'.$csrfNameKey.'" value="'.$csrfName.'">';
        $field .= '<input type="hidden" name="'.$csrfValueKey.'" value="'.$csrfValue.'">';
        $this->container->get('view')->getEnvironment()->addGlobal('csrf', ['field' => $field]);

        // grab the route & check it against excluded routes above then apply csrf if no match found
        $route      = $request->getAttribute('route');
        $Pattern    = $route->getPattern();

        $csrfPassed = $request->getAttribute('csrf_status');
        if ( $csrfPassed === false && ! in_array($Pattern, $this->ignoreCsrf) ) {
            return $response->withStatus(400, 'Csrf Check Failed')->write('Csrf Check Failed');
        }

        // pass state to next middleware
        return $next($request, $response);
    }

}