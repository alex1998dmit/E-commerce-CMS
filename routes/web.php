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

// TODO вопрос тот же почему не работает когда в префиксе админа
Route::get('admin/users/trashed/', 'UsersController@trashed')->name('users.trashed')->middleware(['auth', 'admin']);

// TODO Почему ларавел вызывает ненужные методы ?
Route::get('admin/categories/trashed', 'CategoriesController@trashed')->name('category.trashed')->middleware(['auth', 'admin']);

Route::get('categories/restore/{id}', 'CategoriesController@restore')->name('category.restore')->middleware(['auth', 'admin']);

Route::group(['prefix' => 'admin', 'middleware' => ['auth', 'admin']], function() {
    Route::get('/dashboard', 'AdminController@index')->name('admin.index');

    // Categories
    Route::get('/categories', 'CategoriesController@index')->name('categories');
    Route::post('/categories', 'CategoriesController@create')->name('category.add');
    Route::get('/categories/{id}', 'CategoriesController@edit')->name('category.edit');
    Route::put('/categories/{id}', 'CategoriesController@update')->name('category.update');
    // Route::get('/categories/trashed', 'AdminController@trashedCategories')->name('category.trashed');
    Route::get('/categories/trash/{id}', 'CategoriesController@trash')->name('category.trash');

    // Products
    Route::get('/products', 'ProductsController@index')->name('products');
    Route::get('/products/trashed', 'ProductsController@trashed')->name('products.trashed');
    Route::get('/products/{product}', 'ProductsController@show')->name('product');
    Route::get('/products/edit/{product}', 'ProductsController@edit')->name('product.edit');
    Route::get('/products/trash/{product}', 'ProductsController@trash')->name('product.trash');
    Route::post('/products', 'ProductsController@store')->name('product.store');
    Route::put('/products/{product}', 'ProductsController@update')->name('product.update');

    // Fromcarts
    Route::get('/fromcarts', 'ShoppingCartController@index')->name('carts');

    // Orders
    Route::get('/orders', 'AdminController@orders')->name('orders');
    Route::get('orders/trashed', 'AdminController@trashedOrders')->name('orders.trashed');

    // Requisites
    Route::get('/requisites', 'RequisitesController@index')->name('requisites');
    Route::get('/requisites/create', 'RequisitesController@create')->name('requisite.create');
    Route::post('/requisites', 'RequisitesController@store')->name('requisite.store');
    Route::get('/requisites/{id}', 'RequisitesController@edit')->name('requisite.edit');
    Route::put('/requisites/{id}', 'RequisitesController@update')->name('requisite.update');
    Route::get('/requisites/destroy/{id}', 'RequisitesController@destroy')->name('requisite.trash');

    // Users
    Route::get('/users', 'UsersController@index')->name('users');
    Route::get('/users/{id}', 'UsersController@show')->name('user');
    Route::get('/users/trash/{id}', 'UsersController@trash')->name('user.trash');
});
