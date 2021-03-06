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
    return view('index');
});

$app->group(['prefix' => 'api/v1'], function($app)
{
    $app->get('gasstations', 'GasStationController@index');
    $app->get('gasstations/count', 'GasStationController@count');
    $app->get('gasstations/{id}/pricedata', 'PriceDataController@getPriceData');

    $app->get('pricedata', 'PriceDataController@index');
    $app->get('pricedata/analytics', 'PriceDataController@fuelanalytics');

    $app->post('login', 'UserController@login');
    $app->post('register', 'UserController@register');

    $app->group(['middleware' => ['auth', 'access']], function () use ($app){
        $app->put('pricedata/{priceDataID}', 'PriceDataController@update');

        $app->post('orders', 'OrderController@create');
        $app->get('orders', 'OrderController@getOrders');
    });

});
