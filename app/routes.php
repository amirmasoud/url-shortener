<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the Closure to execute when that URI is requested.
|
*/
Route::get('/not-found', array('as'=>'404', 'uses'=>'HomeController@notfound') );

Route::get('/{shorturl}', array('as'=>'short', 'uses'=>'HomeController@redirect') );

Route::get('/', array('as'=>'get.home', 'uses'=>'HomeController@index') );

Route::post('/short-url', array('as'=>'short.url', 'uses'=>'HomeController@short') );
