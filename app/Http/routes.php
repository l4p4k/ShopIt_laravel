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

    Route::get('/item_search', [
        'uses' => 'IndexController@search',
        'as' => 'item_search'
    ]);

    Route::get('/about', [
        'uses' => 'HomeController@about',
        'as' => 'about'
    ]);

    Route::get('/profile', [
        'uses' => 'HomeController@profile',
        'as' => 'profile'
    ]);

    Route::get('/admindash', [
        'uses' => 'HomeController@admindash',
        'as' => 'admindash'
    ], ['middleware' => 'admin']);

    Route::post('/new_item', [
        'uses' => 'ItemPageController@new_item',
        'as' => 'new_item'
    ], ['middleware' => 'admin']);

    Route::get('/item/{item_id}', [
        'uses' => 'ItemPageController@item_page',
        'as' => 'item.view',
        function ($item_id = '0') {
    }]);

    Route::get('/item_delete/{item_id}', [
        'uses' => 'ItemPageController@item_delete',
        'as' => 'item.delete',
        function ($item_id = '0') {
    }]);

    Route::get('/mycart', [
        'uses' => 'CartController@mycart',
        'as' => 'cart'
    ]);

    Route::get('/delete_cart', [
        'uses' => 'CartController@delete_cart',
        'as' => 'cart.delete'
    ]);

    Route::get('/cart_delete_item/{item_id}', [
        'uses' => 'CartController@cart_delete_item',
        'as' => 'cart.delete_item',
        function ($item_id = '0') {
    }]);

    Route::get('/checkout', [
        'uses' => 'CartController@checkout',
        'as' => 'cart.checkout'
    ]);

    Route::post('/add_to_cart', [
        'uses' => 'CartController@add_to_cart',
        'as' => 'cart.add'
    ]);

});

