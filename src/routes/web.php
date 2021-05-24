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

$router->post('/upload-image', 'ImageController@store');
$router->get('/get-image/{image}', 'ImageController@show');
$router->delete('/delete-image/{param}', 'ImageController@delete');
