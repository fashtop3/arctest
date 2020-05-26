<?php

/** @var \Laravel\Lumen\Routing\Router $router */

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
*/

$router->get('/', function () use ($router) {
    return $router->app->version();
});

$router->group(['prefix' => 'api'], function () use ($router) {
    // Matches "/api/register
    $router->post('register', 'AuthController@register');

    $router->post('login', 'AuthController@login');

    // Matches "/api/profile
    $router->get('profile', 'UserController@profile');

    // Matches "/api/users/1
    //get one user by id
    $router->get('users/{id}', 'UserController@singleUser');

    // Matches "/api/users
    $router->get('users', 'UserController@allUsers');


    $router->get('services', 'ServicesController@index');
    $router->get('services/{id}', 'ServicesController@show');
    $router->put('services/{id}', 'ServicesController@update');
    $router->post('services', 'ServicesController@store');
    $router->delete('services/{id}', 'ServicesController@destroy');


    $router->get('subscriptions', 'SubscriptionController@index');
    $router->post('subscriptions', 'SubscriptionController@initTransaction');
    $router->post('subscriptions/callback', 'SubscriptionController@callback');

});
