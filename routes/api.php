<?php
use App\User;

Auth::routes(['verify' => true]);

Route::get('/v1/confirm', 'API\V1\VerificationController@confirm');
//Route::get()
Route::group(['namespace' => 'Auth', 'middleware' => 'api', 'prefix' => 'password'], function() {
    Route::post('create', 'PasswordResetController@create');
    Route::get('find/{token}', 'PasswordResetController@find');
    Route::post('reset', 'PasswordResetController@reset');
});


// Open shop api
Route::group(['prefix' => '/v1/client', 'namespace' => 'API\V1\Client'], function() {
    Route::post('/login', 'AuthController@login');

    Route::get('categories', 'CategoriesController@index');
    Route::get('categories/{id}', 'CategoriesController@single');
    Route::get('categories/{id}/products', 'CategoriesController@products');
    Route::get('finalcategories/{id}', 'CategoriesController@final');

    Route::post('search/products', 'ProductsController@search');
    Route::get('products', 'ProductsController@index');
    Route::get('products/{id}', 'ProductsController@single');
    Route::get('products/{id}/similar', 'ProductsController@similar');
});

// User api
Route::group(['prefix' => '/v1/client', 'namespace' => 'API\V1\Client', 'middleware' => ['auth:api', 'verified']], function() {
    Route::get('/requisites', 'RequisitesController@index');

    Route::get('/cart', 'ShoppingCartController@index');
    Route::post('/cart', 'ShoppingCartController@store');
    Route::get('/cart/{id}/remove', 'ShoppingCartController@delete');
    Route::put('/cart/{id}', 'ShoppingCartController@update');

    Route::get('/wishlist', 'WishListController@index');
    Route::post('/wishlist', 'WishListController@store');
    Route::get('/wishlist/{id}/remove', 'WishListController@remove');

    Route::post('/orders', 'OrdersController@store')->middleware('verified');
    Route::get('/orders', 'OrdersController@index')->middleware('verified');
    Route::put('/orders/{order_id}', 'OrdersController@update')->middleware('verified');
});

// register and login api
Route::group(['prefix' => '/v1','namespace' => 'API\V1'], function () {
    Route::post('/login', 'AuthController@login');
    Route::post('/register', 'AuthController@register');
    Route::get('/user', 'AuthController@about')->middleware(['auth:api']);
    Route::post('/logout', 'AuthController@logout')->middleware(['auth:api']);

});

// admin api
Route::group(['prefix' => '/v1','namespace' => 'API\V1', 'middleware' => ['auth:api', 'admin']], function () {
    // requisites
    Route::get('/requisites', 'RequisitesController@index');
    Route::get('/requisites/{requisite}', 'RequisitesController@single');
    Route::put('/requisites/{requisite}', 'RequisitesController@update');
    Route::delete('/requisites/{requisite}', 'RequisitesController@trash');
    Route::get('/requisites/restore/{requisite}', 'RequisitesController@restore');
    Route::post('/requisites', 'RequisitesController@store');
    Route::get('/trashed/requisites', 'RequisitesController@trashed');

    // discounts
    Route::get('/discounts', 'DiscountsController@index');
    Route::get('/discounts/{discount_id}', 'DiscountsController@single');
    Route::put('/discounts/{discount}', 'DiscountsController@update');
    Route::delete('/discounts/{discount}', 'DiscountsController@trash');
    Route::post('/discounts', 'DiscountsController@store');

    // users
    Route::delete('/users/{id}', 'UsersController@trash');
    Route::get('/users/{id}/restore', 'UsersController@restore');
    Route::get('/users/{id}', 'UsersController@single');
    Route::get('/trashedUsers', 'UsersController@trashed');
    Route::get('/users/{id}/restore', 'UsersController@restore');
    Route::post('users/search', 'UsersController@search');
    Route::put('/users/replaceDiscounts/{old_discount_id}', 'UsersController@replaceDiscountsIds');
    Route::put('/users/{id}', 'UsersController@update');
    Route::resource('users', 'UsersController', ['except' => 'create', 'edit']);

    // categories
    Route::post('/categories', 'CategoriesController@store');
    Route::get('/categories/{id}', 'CategoriesController@show');
    Route::get('categories', 'CategoriesController@index');
    Route::get('finalCategories', 'CategoriesController@finalCategories');
    Route::get('trashedCategories', 'CategoriesController@trashed');
    Route::get('categories/restore/{id}', 'CategoriesController@restore');
    Route::patch('categories/{category}','CategoriesController@update');
    Route::get('categories/trash/{id}', 'CategoriesController@trash');
    Route::delete('categories/{id}', 'CategoriesController@delete');

    // Products
    Route::get('/products', 'ProductsController@index');
    Route::post('/products/store', 'ProductsController@store');
    Route::delete('/products/trash/{id}', 'ProductsController@trash');
    Route::get('/products/{id}', 'ProductsController@single');
    Route::delete('/products/images', 'ProductsController@removeImage');
    Route::post('/products/update/{product}', 'ProductsController@update');
    Route::get('/search/products', 'ProductsController@search');

    // Orders
    Route::post('/filter/orders', 'OrdersController@filter');
    Route::get('/orders', 'OrdersController@index');
    Route::post('/orders', 'OrdersController@store');
    Route::get('/orders/{id}', 'OrdersController@single');
    Route::put('/orders/{order_id}', 'OrdersController@update');
    Route::get('/orders/{order_id}/history', 'OrderHistoryController@index');
    Route::post('/search/orders', 'OrdersController@filter');
    Route::delete('/orders/{order_id}', 'OrdersController@trash');

    // Orders Statuses
    Route::get('/orderStatuses/{status_id}', 'OrderStatusesController@single');
    Route::get('/orderStatuses', 'OrderStatusesController@index');

    // OrderItem
    Route::put('/orderItems/{item_id}', 'OrderItemsController@update');
    Route::delete('/orderItems/{item_id}', 'OrderItemsController@delete');
    Route::post('/orderItems', 'OrderItemsController@store');

    // Order notifications
    Route::get('/notifications/orders', 'NotificationsController@orders');
    Route::post('/notificatons/check/orders/', 'NotificationsController@checkAllOrders');
    Route::post('/notificatons/orders/{id}/check', 'NotificationsController@orderCheck');

    // Search
    Route::post('/search/globall', 'SearchController@index');

    // AUTH
    Route::get('/info', 'AuthController@info');
});



