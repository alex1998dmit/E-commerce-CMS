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
// TODO middleware, метод Делит
Route::get('orders/permanentDelete/{id}', 'OrdersController@permanentDelete')->name('order.permanentDelete');
Route::get('orders/delete/{id}', 'OrdersController@delete')->name('order.delete');
Route::get('orders/restore/{id}', 'OrdersController@restore')->name('order.restore');
// Route::get('v2/notes/{id}', 'NotesController@softdelete');

Route::group(['prefix' => 'admin', 'middleware' => 'auth'], function(){
    Route::get('/dashboard', 'AdminController@index')->name('index');
    Route::get('/fromcarts', 'AdminController@fromCarts')->name('carts');
    Route::get('/categories', 'AdminController@categories')->name('categories');
    Route::post('/categories', 'CategoriesController@addCategory')->name('add.category');
    Route::prefix('orders')->group(function() {
        Route::get('/', 'AdminController@orders')->name('orders');
        Route::get('/trashed', 'AdminController@trashedOrders')->name('orders.trashed');
    });
});
