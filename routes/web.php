<?php

Route::get('/admin/{any}', function() {
    return view('welcome');
})->where('any', '.*');

Route::get('{any}', function () {
    return view('client');
})->where('any', '.*');

Route::get('/home', 'HomeController@index')->name('home');
