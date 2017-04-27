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
    return $app->version();
});

$app->group(['prefix' => 'table'], function () use ($app) {
    $app->get('/', 'TableController@index');
    $app->post('/', 'TableController@create');
    $app->post('/submit', 'TableController@submit');
//    $app->post('/', 'TableController@submit');
});

$app->group(['prefix' => 'menu'], function () use ($app) {
    $app->get('/', 'MenuController@index');
    $app->post('/', 'MenuController@create');
    $app->get('/list_category', 'MenuController@list_category');
    $app->post('/category', 'MenuController@create_category');
});

$app->group(['prefix' => 'order'], function () use ($app) {
    $app->post('/', 'OrderController@order');
    $app->post('/payment', 'OrderController@payment');
    $app->post('/cash', 'OrderController@cash');
});

$app->group(['prefix' => 'image'], function () use ($app) {
    $app->post('/', 'ImageController@upload');
});

