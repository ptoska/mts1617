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
    return "MTS1617 G10 Ushtrimi 9 API";
});

//client routes
$app->group(['prefix' => 'api/v1/client'], function($app){
	$app->post('add', 'ClientController@addClient');
	$app->get('{client}', 'ClientController@getClient');
	$app->put('update', 'ClientController@updateClient');
	$app->delete('delete/{client}', 'ClientController@deleteClient');
});

//porosi routes
$app->group(['prefix' => 'api/v1/porosi'], function($app){
	$app->post('add', 'PorosiController@addPorosi');
	$app->get('{porosi_id}', 'PorosiController@getPorosi');
	$app->put('update/{porosi_id}', 'PorosiController@updatePorosi');
	$app->delete('delete/{porosi_id}', 'PorosiController@deletePorosi');
});

//paypal routes
$app->group(['prefix' => 'api/v1/paypal'], function($app){
	$app->get('link/{porosi_id}', 'PayPalController@getLink');
	$app->get('confirm','PayPalController@confirmPagese');
	$app->get('cancel','PayPalController@cancelPagese');
});