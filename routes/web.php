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

Route::get('profile', function () {
    // Only verified users may enter...
})->middleware('verified');

Route::get('/home', 'HomeController@index')->name('home');
// TODO middleware, метод Делит
Route::get('orders/permanentDelete/{id}', 'OrdersController@permanentDelete')->name('order.permanentDelete');
Route::get('orders/delete/{id}', 'OrdersController@delete')->name('order.delete');
Route::get('orders/restore/{id}', 'OrdersController@restore')->name('order.restore');
// Route::get('v2/notes/{id}', 'NotesController@softdelete');

Route::group(['prefix' => 'admin', 'middleware' => 'auth'], function() {
    Route::get('/dashboard', 'AdminController@index')->name('index');

    Route::get('/categories', 'AdminController@categories')->name('categories');
    Route::post('/categories', 'CategoriesController@create')->name('category.add');
    Route::get('/categories/{id}', 'AdminController@editCategory')->name('category.edit');
    Route::put('/categories/{id}', 'CategoriesController@update')->name('category.update');
    Route::get('/categories/trash/{id}', 'CategoriesController@trash')->name('category.trash');

    Route::get('/fromcarts', 'AdminController@fromCarts')->name('carts');

    Route::prefix('orders')->group(function() {
        Route::get('/', 'AdminController@orders')->name('orders');
        Route::get('/trashed', 'AdminController@trashedOrders')->name('orders.trashed');
    });
});
