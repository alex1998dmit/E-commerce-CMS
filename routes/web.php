<?php

Auth::routes(['verify' => true]);

Route::get('/confirm', 'API\V1\VerificationController@confirm');

Route::get('/admin/{any}', function() {
    return view('welcome');
})->where('any', '.*');

Route::get('{any}', function () {
    return view('client');
})->where('any', '.*');

Route::get('/home', 'HomeController@index')->name('home');
