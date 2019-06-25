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
// User's action
Route::post("register", 'Auth\RegisterController@register');

//-- React's actions without auth

    //---- Categories
Route::get('/categories/{category}', 'CategoriesController@show');
Route::get('categories', 'CategoriesController@index');
// Route::delete('/categories/{category}', 'CategoriesController@delete');

    //---- Products
Route::get('/products/{product}', 'ProductsController@show');
Route::get('products', 'ProductsController@index');
Route::get('user/removefromwishlist/{wishList}', 'WishListController@delete')->middleware('auth:api');


//-- Auth's actions
Route::group(['middleware' => 'auth:api'], function() {
    //-- Admin's actions
    Route::group(['prefix' => 'admin'], function() {
        //-- Products
        Route::post('products', 'ProductsController@store');
        Route::put('products/{product}', 'ProductsController@update');

        //-- Categories
        Route::post('categories', 'CategoriesController@store');
        Route::put('/categories/{category}', 'CategoriesController@update');

        // -- Users
        Route::get('/users/index', 'UserController@index');
    });

    //-- User's info
    // Route::post('user/wishlist', 'WishListController@store');
    Route::group(['prefix' => 'user'], function() {
        Route::get('show/{id}', 'UserController@show');
        Route::post('logout', 'AuthenticationController@logoutAPI');

    //---- WishList
        Route::get('/wishlist', 'WishListController@index');
        Route::post('/wishlist', 'WishListController@store');

    //---- Product Cart
        Route::get('/cart', 'ShoppingCartController@index');
        Route::get('/removefromcart/{shoppingCart}', 'ShoppingCartController@delete');
        Route::post('/cart', 'ShoppingCartController@store');
        Route::put('/cart/{shoppingCart}', 'ShoppingCartController@update');
    });

    // For react app
});
