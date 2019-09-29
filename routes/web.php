<?php

Auth::routes(['verify' => true]);

Route::get('/email/show', function() {
    return view('emails.notification');
});

Route::get('/email/confirm', function () {
    return 123;
})->name('email.confirm');

Route::get('/admin/{any}', function() {
    return view('welcome');
})->where('any', '.*');

Route::get('{any}', function () {
    return view('client');
})->where('any', '.*');

Route::get('/home', 'HomeController@index')->name('home');
