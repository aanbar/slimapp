<?php

namespace App\Controllers\Admin;


use App\Controllers\BaseController;
use App\Models\User;
use Slim\Http\Request;
use Slim\Http\Response;

class HomeController extends BaseController
{
    public function index(Request $request, Response $response)
    {

        return $this->view->render($response, 'admin/home.twig');
    }
}