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

// Search actions
// Route::get('/search', 'Api\SearchController@search')->name('api.search');

// User's action
Route::post("register", 'Auth\RegisterController@register');

//-- React's actions without auth

    //---- Categories
Route::get('/categories/{id}', 'API\CategoriesController@show');
Route::get('categories', 'API\CategoriesController@index');

    //---- Products
Route::get('/products/{product}', 'API\ProductsController@show');
Route::get('products', 'API\ProductsController@index');

Route::get('user/removefromwishlist/{wishList}', 'API\WishListController@delete')->middleware('auth:api');

//-- Auth's actions
Route::group(['middleware' => 'auth:api'], function() {
    //-- User's info
    Route::group(['prefix' => 'user'], function() {
        Route::get('show/{id}', 'API\UserController@show');
        Route::post('logout', 'AuthenticationController@logoutAPI');

        //---- WishList
        Route::get('/wishlist', 'API\WishListController@index');
        Route::post('/wishlist', 'API\WishListController@store');

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
        Route::get('/orders/waitPayment/{id}', 'OrdersController@paymentWaiting');
        Route::get('/orders/paymentSent/{id}', 'OrdersController@paymentSent');
    });
});


Route::post('/admin/categories/', function() {
    return [];
});

Route::group(['prefix' => '/v1','namespace' => 'API\V1'], function () {

    Route::get('/discounts/show/{discount}', 'DiscountsController@show');
    Route::put('/discounts/{discount}', 'DiscountsController@update');
    Route::resource('discounts', 'DiscountsController', ['except' => ['create', 'edit']]);

    Route::get('users/search', 'UsersController@search');
    Route::resource('users', 'UsersController', ['except' => 'create', 'edit']);

    Route::post('/categories', 'CategoriesController@store');
    // Route::post('/categories', function() {
    //     return [];
    // });

    Route::delete('/categories/{id}', 'CategoriesController@trash');
    Route::get('/categories/{id}', 'CategoriesController@show');
    Route::get('categories', 'CategoriesController@index');
    Route::patch('categories/{category}','CategoriesController@update');
    // Route::resource('users', 'CategoriesController', ['except' => 'create', 'edit']);
});


