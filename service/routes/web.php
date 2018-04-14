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

$router->get('/', function () use ($router) {
	echo "This is service 2 \r\n";
    return $router->app->version();
});


$router->get('/service', "ServiceController@serve");
$router->get('/logout', "ServiceController@logOut");