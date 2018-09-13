<?php


$app->get('/', 'HomeController:index')->setName('home');
$app->post('/', 'HomeController:postExample');
$app->get('/admin', 'Admin\HomeController:index');

