<?php

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

$app->get('/', function () use ($app) {
    //return $app->version();
    return view('index', ['API_KEY' => $_ENV['GOOGLE_MAPS_API_KEY']]);
});


$app->group(['prefix' => 'api/v1'], function($app)
{
    $app->get('gasstations', 'GasStationController@index');
    $app->get('gasstations/count', 'GasStationController@count');

    $app->get('gasstations/{id}/pricedata', 'PriceDataController@getPriceData');
    $app->get('pricedata', 'PriceDataController@index');

    $app->post('login', 'UserController@login');
    $app->post('register', 'UserController@register');

    $app->get('info', ['middleware' => 'access', 'uses' => 'UserController@info']);

    $app->group(['middleware' => 'auth'], function () use ($app){
        $app->put('pricedata/{priceDataID}', ['middleware' => 'access', 'uses' => 'PriceDataController@update']);

        $app->post('orders', ['middleware' => 'access', 'uses' => 'OrderController@create']);
        $app->get('orders', ['middleware' => 'access', 'uses' => 'Order@getOrders']);
    });

});
