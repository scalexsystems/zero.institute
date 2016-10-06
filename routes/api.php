<?php

Route::get('/schools', 'SchoolController@index');

// -- Authenticated routes.
Route::get('/geo/cities', 'GeoController@cities');

Route::get('/school', 'SchoolController@show');
Route::put('/school', 'SchoolController@update');
