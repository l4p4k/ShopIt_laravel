<?php

/*
|--------------------------------------------------------------------------
| Routes File
|--------------------------------------------------------------------------
|
| Here is where you will register all of the routes in an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/



/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| This route group applies the "web" middleware group to every route
| it contains. The "web" middleware group is defined in your HTTP
| kernel and includes session state, CSRF protection, and more.
|
*/

Route::group(['middleware' => 'web'], function () 
{
    ini_set('xdebug.max_nesting_level', 200);
    
    Route::auth();

    Route::get('/', [
        'uses' => 'IndexController@index',
        'as' => 'index'
    ]);

    Route::post('/', [
        'uses' => 'IndexController@indexFilter',
        'as' => 'index.filter'
    ]);

    Route::get('/about', [
        'uses' => 'HomeController@about',
        'as' => 'about'
    ]);

    Route::get('/home', [
        'uses' => 'HomeController@home',
        'as' => 'home'
    ]);

});
