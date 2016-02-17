<?php

use Crip\UserManager\App\Controllers\UserController;

Route::group(['prefix' => 'api/v1/user'], function () {

    Route::post('/', UserController::class . '@createUser');

    Route::get('{id}', UserController::class . '@user');

});
