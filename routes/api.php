<?php

Route::get('/schools', 'SchoolController@index');

// -- Authenticated routes.
Route::group(['middleware' => 'auth:api,web'],
    function () {
        Route::get('/geo/cities', 'GeoController@cities');

        Route::get('/school', 'SchoolController@show');
        Route::put('/school', 'SchoolController@update');

        Route::get('/me', 'UserController@show');
        Route::put('/me', 'UserController@update');
        Route::get('/me/dashboard', 'UserController@dashboard');
    }
);
