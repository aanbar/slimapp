<?php

namespace App\Controllers;


use Slim\Http\Request;
use Slim\Http\Response;
use Respect\Validation\Validator as v;

class HomeController extends BaseController
{

    public function index(Request $request, Response $response)
    {
        return $this->view->render($response, 'welcome.twig');
    }

    public function postExample (Request $request, Response $response)
    {
        $rules = [
            'email' => ['name' => 'Email', 'rules' => v::notEmpty()->email()]
        ];

        $validation = $this->validator->validate($request, $rules);
        if ( ! $validation->failed() ) {
            $this->flash->addMessage('success', 'Your application has been submitted');
        }
        return $response->withRedirect($this->router->pathFor('home'));
    }
}