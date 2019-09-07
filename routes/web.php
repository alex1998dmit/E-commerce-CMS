<?php

Route::get('{any}', function() {
    return view('welcome');
})->where('any', '.*');

Route::get('/home', 'HomeController@index')->name('home');
