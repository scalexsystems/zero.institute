<?php

Route::get('/', 'HomeController@home');

Route::get('/share', 'HomeController@share');
Route::get('/request', 'HomeController@request');
Route::post('/request', 'HomeController@request');

Route::get('/account/update/email/verify/{token}', 'Auth\VerificationController@updateEmail');
Route::get('/account/email/verify/{token}', 'Auth\VerificationController@verifyEmail');

Auth::routes();

// NOTE: **This should be last in list. It captures everything.**
Route::group(['middleware' => 'auth'], function () {
    Route::get('/{anything}', 'HomeController@app')->where('anything', '(.*)');
});
