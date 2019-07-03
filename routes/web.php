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
Auth::routes(['verify' => true]);


Route::get('/home', 'HomeController@index')->name('home');
// TODO middleware, метод Делит
Route::get('orders/permanentDelete/{id}', 'OrdersController@permanentDelete')->name('order.permanentDelete');
Route::get('orders/delete/{id}', 'OrdersController@delete')->name('order.delete');
Route::get('orders/restore/{id}', 'OrdersController@restore')->name('order.restore');
Route::get('admin/categories/trashed', 'CategoriesController@trashed')->name('category.trashed');


Route::get('categories/restore/{id}', 'CategoriesController@restore')->name('category.restore');

Route::group(['prefix' => 'admin', 'middleware' => 'auth'], function() {
    Route::get('/dashboard', 'AdminController@index')->name('index');

    Route::get('/categories', 'CategoriesController@index')->name('categories');
    Route::post('/categories', 'CategoriesController@create')->name('category.add');
    Route::get('/categories/{id}', 'CategoriesController@edit')->name('category.edit');
    Route::put('/categories/{id}', 'CategoriesController@update')->name('category.update');
    // Route::get('/categories/trashed', 'AdminController@trashedCategories')->name('category.trashed');
    Route::get('/categories/trash/{id}', 'CategoriesController@trash')->name('category.trash');

    Route::get('/fromcarts', 'ShoppingCartController@index')->name('carts');

    Route::get('/orders', 'AdminController@orders')->name('orders');
    Route::get('orders/trashed', 'AdminController@trashedOrders')->name('orders.trashed');

    Route::get('/requisites', 'RequisitesController@index')->name('requisites');
    Route::get('/requisites/create', 'RequisitesController@create')->name('requisite.create');
    Route::post('/requisites', 'RequisitesController@store')->name('requisite.store');
    Route::get('/requisites/{id}', 'RequisitesController@edit')->name('requisite.edit');
    Route::put('/requisites/{id}', 'RequisitesController@update')->name('requisite.update');
    Route::get('/requisites/destroy/{id}', 'RequisitesController@destroy')->name('requisite.trash');
});
