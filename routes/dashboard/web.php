<?php

use Illuminate\Support\Facades\Route;


Route::group(
    [
        'prefix' => LaravelLocalization::setLocale(),
        'middleware' => [ 'localeSessionRedirect', 'localizationRedirect', 'localeViewPath' ]
    ], function(){ 

        Route::group(['prefix' => 'dashboard'], function () {
            Route::get('/', 'AdminController@index')->name('dashboard.home');
            //users route
            Route::resource('users', 'UserController')->except('show');
            //categories route
            Route::resource('categories', 'CategroyController')->except('show');
        });
        

});