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
    //set xdebug level to 200 for a higher recursive method threshold
    ini_set('xdebug.max_nesting_level', 200);
    
    Route::auth();

    //home
    Route::get('/', [
        'uses' => 'IndexController@indexFilter',
        'as' => 'index'
    ]);
    //when you search an item
    Route::get('/item_search', [
        'uses' => 'IndexController@search',
        'as' => 'item_search'
    ]);
    //the about page
    Route::get('/about', [
        'uses' => 'HomeController@about',
        'as' => 'about'
    ]);
    //your personal profile
    Route::get('/profile', [
        'uses' => 'ProfileController@profile',
        'as' => 'profile'
    ]);
    //edit your profile details
    Route::post('/editProfile', [
        'uses' => 'ProfileController@editProfile',
        'as' => 'profile.edit'
    ]);
    //admin dashboard
    Route::get('/admindash', [
        'uses' => 'HomeController@admindash',
        'as' => 'admindash'
    ], ['middleware' => 'admin']);
    //when you create a new item
    Route::post('/new_item', [
        'uses' => 'ItemPageController@new_item',
        'as' => 'new_item'
    ], ['middleware' => 'admin']);
    //change an item's details
    Route::post('/change_item', [
        'uses' => 'ItemPageController@change_item',
        'as' => 'change_item'
    ], ['middleware' => 'admin']);
    //add stock/quantity to an item
    Route::post('/add_stock', [
        'uses' => 'ItemPageController@add_stock',
        'as' => 'add_stock'
    ], ['middleware' => 'admin']);
    //delete an item with id
    Route::get('/item_delete/{item_id}', [
        'uses' => 'ItemPageController@item_delete',
        'as' => 'item.delete',
        function ($item_id = '0') {
    }], ['middleware' => 'admin']);
    //view an item's page
    Route::get('/item/{item_id}', [
        'uses' => 'ItemPageController@item_page',
        'as' => 'item.view',
        function ($item_id = '0') {
    }]);
    //rate an item once bought
    Route::post('/rate', [
        'uses' => 'ItemPageController@rate',
        'as' => 'item.rate'
    ]);
    //check your shopping cart
    Route::get('/mycart', [
        'uses' => 'CartController@mycart',
        'as' => 'cart'
    ]);
    //empty the cart
    Route::get('/delete_cart', [
        'uses' => 'CartController@delete_cart',
        'as' => 'cart.delete'
    ]);
    //delete an item from cart
    Route::get('/cart_delete_item/{item_id}', [
        'uses' => 'CartController@cart_delete_item',
        'as' => 'cart.delete_item',
        function ($item_id = '0') {
    }]);
    //checkout with items in shopping cart
    Route::get('/checkout', [
        'uses' => 'CartController@checkout',
        'as' => 'cart.checkout'
    ]);
    //add an item to cart
    Route::post('/add_to_cart', [
        'uses' => 'CartController@add_to_cart',
        'as' => 'cart.add'
    ]);
    //error page
    Route::get('/error', [
        'as' => 'error',
        function () {
        $data = "Well this was unexpected!";
        return view('error')->withdata($data);
    }]);

});

