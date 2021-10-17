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

$app->group(['prefix' => 'api','namespace' => 'App\Http\Controllers'], function($app)
{
    //zach: auth controller
    $app->post('auth/register','AuthController@register');    
    $app->post('auth/login','AuthController@login');
    $app->post('auth/logout','AuthController@logout');

    $app->get('posts','PostController@index');
    $app->get('posts/{post_id}','PostController@get');
    //zach: protected methods
    $app->post('posts',[ 'middleware'=>'auth','uses'=>'PostController@create']);
    $app->put('posts/{post_id}',[ 'middleware'=>'auth','uses'=>'PostController@update']);
    $app->delete('posts/{post_id}',[ 'middleware'=>'auth','uses'=>'PostController@delete']);

    $app->get('tags','TagController@index');
    $app->get('tags/{tag_id}','TagController@get');
    //zach: protected methods
    $app->post('tags',[ 'middleware'=>'auth','uses'=>'TagController@create']);
    $app->put('tags/{tag_id}',[ 'middleware'=>'auth','uses'=>'TagController@update']);
    $app->delete('tags/{tag_id}',[ 'middleware'=>'auth','uses'=>'TagController@delete']);

    $app->get('users','UserController@index');
    $app->get('users/{user_id}','UserController@get');
    //zach: protected methods
    $app->post('users',[ 'middleware'=>'auth','uses'=>'UserController@create']);
    $app->put('users/{user_id}',[ 'middleware'=>'auth','uses'=>'UserController@update']);
    $app->delete('users/{user_id}',[ 'middleware'=>'auth','uses'=>'UserController@delete']);
});

