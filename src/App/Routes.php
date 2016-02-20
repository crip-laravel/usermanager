<?php

use Crip\UserManager\App\Controllers\UserController;
use Illuminate\Routing\Router;
use Mcamara\LaravelLocalization\LaravelLocalization;

Route::group(['prefix' => app(LaravelLocalization::class)->setLocale() . '/api/v1/user'], function (Router $router) {

    $router->post('/', UserController::class . '@createUser');

    $router->post('/auth', UserController::class . '@authenticate');
});
