<?php

use Illuminate\Http\Request;
    // use Auth;

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


Auth::routes(['verify' => true]);

// User's action
Route::post("register", 'Auth\RegisterController@register');

//-- React's actions without auth

    //---- Categories
Route::get('/categories/{id}', 'API\CategoriesController@show');
Route::get('categories', 'API\CategoriesController@index');

    //---- Products
Route::get('/products/{product}', 'ProductsController@show');
Route::get('products', 'ProductsController@index');
Route::get('user/removefromwishlist/{wishList}', 'WishListController@delete')->middleware('auth:api');


//-- Auth's actions
Route::group(['middleware' => 'auth:api'], function() {
    //-- User's info
    // Route::post('user/wishlist', 'WishListController@store');
    Route::group(['prefix' => 'user'], function() {
        Route::get('show/{id}', 'API\UserController@show');
        Route::post('logout', 'AuthenticationController@logoutAPI');

    //---- WishList
        Route::get('/wishlist', 'WishListController@index');
        Route::post('/wishlist', 'WishListController@store');

    //---- Product Cart
        Route::get('/cart', 'API\ShoppingCartController@index');
        Route::get('/removefromcart/{shoppingCart}', 'API\ShoppingCartController@delete');
        Route::post('/cart', 'API\ShoppingCartController@store');
        Route::post('/cart', 'API\ShoppingCartController@store');
        Route::put('/cart/{shoppingCart}', 'API\ShoppingCartController@update');

    //---- Order
        Route::get('/orders', 'OrdersController@index');
        Route::post('/orders', 'OrdersController@store');
        Route::get('/orders/{order}', 'OrdersController@show');
    });

    // For react app
});
