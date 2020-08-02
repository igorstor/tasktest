<?php

use Illuminate\Routing\Router;

/** @var Router $router */
$router->prefix('phones')->group(
    function () use ($router) {
        $router->get('/', [
            'as' => 'api.phones.index',
            'uses' => 'Api\PhonesController@index',
        ]);
        $router->get('/{id}', [
            'as' => 'api.phones.show',
            'uses' => 'Api\PhonesController@show'
        ]);
        $router->post('/', [
            'as' => 'api.phones.create',
            'uses' => 'Api\PhonesController@create'
        ]);
        $router->put('/update/{id}', [
            'as' => 'api.phones.update',
            'uses' => 'Api\PhonesController@update'
        ]);
        $router->delete('/{id}', [
            'as' => 'api.phones.delete',
            'uses' => 'Api\PhonesController@delete'
        ]);
    });

$router->prefix('auth')->group(
    function () use ($router) {

        $router->post('register', [
            'as' => 'api.users.register',
            'uses' => 'Api\Auth\AuthController@register'
        ]);

        $router->post('login', [
            'as' => 'api.users.login',
            'uses' => 'Api\Auth\AuthController@login'
        ]);

        $router->get('confirm/{token}', [
            'as' => 'api.users.confirm.register',
            'uses' => 'Api\Auth\AuthController@confirmRegister'
        ]);

    }
);
