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
    return $router->app->version();
});
// $router->get('/', function (){
//     return "hi";
// });


//$router->post('/login','BoardController@login');
//$router->get('/logout','BoardController@logout');
//$router->post('/register','BoardController@register');



$router->get('/boards/{userID}','BoardController@index');
$router->get('/boards/{boardID}/{userID}','BoardController@show');
$router->post('	/boards/{userID}','BoardController@store');
$router->put('/boards/{boardID}/{userID}','BoardController@update');
$router->delete('/boards/{boardID}/{userID}','BoardController@destroy');



$router->get('/boards/{boardID}/{userID}/list','ListController@index');
$router->post('/boards/{boardID}/{userID}/list','ListController@store');
$router->get('/boards/{boardID}/{userID}/list/{listID}','ListController@show');
$router->put('/boards/{boardID}/list/{listID}','ListController@update');
$router->delete('/boards/{boardID}/{userID}/list/{listID}','ListController@destroy');



$router->get('/boards/{boardID}/{userID}/list/{listID}/card','CardController@index');

$router->post('/boards/{boardID}/{userID}/list/{listID}/card','CardController@store');

$router->get('/boards/{boardID}/{userID}/list/{listID}/card/{cardID}','CardController@show');

$router->put('/boards/{boardID}/{userID}/list/{listID}/card/{cardID}','CardController@update');
$router->delete('/boards/{boardID}/{userID}/list/{listID}/card/{cardID}','CardController@destroy');

