<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use Slim\Http\Request;
use Slim\Http\Response;

class AuthController extends BaseController
{

    protected $redirect_after_login = 'admin.dashboard';

    public function logout(Request $request, Response $response)
    {
        $this->auth->logout();
        return $response->withRedirect($this->router->pathFor($this->redirect_after_login));

    }

    public function get_login(Request $request, Response $response)
    {
        return $this->view->render($response, 'admin/login.twig');
    }


    public function post_login(Request $request, Response $response)
    {
        $auth = $this->auth->attempt($request->getParam('email'), $request->getParam('password'));

        if ( $auth ) {
            return $response->withRedirect($this->router->pathFor($this->redirect_after_login));
        }else{
            $this->flash->addMessage('error', 'Invalid email and/or password');
            return $response->withRedirect($this->router->pathFor('auth.login'));
        }
    }
}