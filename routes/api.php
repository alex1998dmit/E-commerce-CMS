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
Route::get('/categories/{category}', 'APICategoriesController@show');
Route::get('categories', 'APICategoriesController@index');
// Route::delete('/categories/{category}', 'CategoriesController@delete');

    //---- Products
Route::get('/products/{product}', 'APIProductsController@show');
Route::get('products', 'APIProductsController@index');
Route::get('user/removefromwishlist/{wishList}', 'APIWishListController@delete')->middleware('auth:api');


//-- Auth's actions
Route::group(['middleware' => 'auth:api'], function() {
    //-- Admin's actions
    Route::group(['prefix' => 'admin'], function() {
        //-- Products
        Route::post('products', 'APIProductsController@store');
        Route::put('products/{product}', 'APIProductsController@update');

        //-- Categories
        Route::post('categories', 'APICategoriesController@store');
        Route::put('/categories/{category}', 'APICategoriesController@update');

        // -- Users
        Route::get('/users/index', 'APIUserController@index');
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
