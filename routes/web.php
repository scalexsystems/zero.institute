<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of the routes that are handled
| by your application. Just tell Laravel the URIs it should respond
| to using a Closure or controller method. Build something great!
|
*/

Route::get('/', 'HomeController@home');

Route::get('/share', 'HomeController@share');
Route::get('/request', 'HomeController@request');
Route::post('/request', 'HomeController@request');

Route::get('/account/update/email/verify/{token}', 'Auth\VerificationController@updateEmail');
Route::get('/account/email/verify/{token}', 'Auth\VerificationController@verifyEmail');

Auth::routes();

Route::group(['middleware' => 'auth'], function () {
    Route::get('/{anything}', 'HomeController@app')->where('anything', '(.*)');
});
