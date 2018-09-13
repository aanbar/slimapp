<?php

// authenticated users only.
$app->group('', function (){
    $this->get('/admin', 'Admin\HomeController:index')->setName('admin.dashboard');
    $this->get('/admin/logout', 'Admin\AuthController:logout')->setName('auth.logout');
})->add(new \App\Middleware\AuthMiddleware($app->getContainer()));


// non-authenticated users only.
$app->group('', function (){
    $this->get('/admin/login', 'Admin\AuthController:get_login')->setName('auth.login');
    $this->post('/admin/login', 'Admin\AuthController:post_login');
})->add(new App\Middleware\GuestMiddleware($app->getContainer()));

$app->get('/', 'HomeController:index')->setName('home');
$app->post('/', 'HomeController:postExample');


