<?php

/*
 * |--------------------------------------------------------------------------
 * | Application Routes
 * |--------------------------------------------------------------------------
 * |
 * | Here is where you can register all of the routes for an application.
 * | It is a breeze. Simply tell Lumen the URIs it should respond to
 * | and give it the Closure to call when that URI is requested.
 * |
 */
$router->get('/', function () use ($router) {
    return $router->app->version();
});

$router->post('/login', [
    'uses' => 'Api\UserController@login'
]);

$router->group([
    'middleware' => 'auth'
], function () use ($router) {

    $router->get('/users', [
        'uses' => 'Api\UserController@index'
    ]);

    $router->get('/users/{id}', [
        'uses' => 'Api\UserController@show'
    ]);

    $router->put('/users', [
        'uses' => 'Api\UserController@store'
    ]);

    $router->post('/users/{id}', [
        'uses' => 'Api\UserController@update'
    ]);

    $router->delete('/users/{id}', [
        'uses' => 'Api\UserController@destroy'
    ]);
});
