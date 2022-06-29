<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

// $router->get('/', function () use ($router) {
//     //return $router->app->version();
// });

$router->group(['prefix' => 'v1/'], function () use ($router) {
    $router->group(['prefix' => 'website'], function () use ($router) {
        $router->get('/', 'WebsiteController@getAllRecords');
        $router->get('/{id}', 'WebsiteController@getRecord');
        $router->post('/', 'WebsiteController@create');
    });
    $router->group(['prefix' => 'user'], function () use ($router) {
        $router->get('/{id}', 'UserController@getRecord');
        $router->post('/', 'UserController@create');
    });
    $router->group(['prefix' => 'posts'], function () use ($router) {
        $router->get('/{id}', 'PostController@getRecord');
        $router->post('/', 'PostController@create');
    });
    $router->group(['prefix' => 'subscribe'], function () use ($router) {
        $router->get('/{id}', 'SubscriberController@getRecord');
        $router->post('/', 'SubscriberController@create');
    });
});