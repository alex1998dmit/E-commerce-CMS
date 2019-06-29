<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
Route::get('orders/permanentDelete/{id}', 'OrdersController@permanentDelete')->name('order.delete');

Route::group(['prefix' => 'admin', 'middleware' => 'auth'], function(){
    Route::get('/dashboard', 'AdminController@index')->name('index');
    Route::get('/fromcarts', 'AdminController@fromCarts')->name('carts');
    Route::get('/categories', 'AdminController@categories')->name('categories');
    Route::post('/categories', 'CategoriesController@addCategory')->name('add.category');
    Route::prefix('orders')->group(function() {
        Route::get('/', 'AdminController@orders');
        // Route::delete('permanentDelete/{id}', 'OrdersController@permanentDelete');
        // Route::delete('permanentDelete/{id}', function() {
        //     dd("here");
        // });
    });
});
