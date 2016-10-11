<?php

Route::get('/schools', 'SchoolController@index');

// -- Authenticated routes.
Route::group(['middleware' => 'auth:api,web'],
    function () {
        Route::get('/geo/cities', 'GeoController@cities');

        /**
         * Current School
         */
        Route::get('/school', 'SchoolController@show');
        Route::put('/school', 'SchoolController@update');

        /**
         * Current User
         */
        Route::get('/me', 'UserController@showCurrent');
        Route::put('/me', 'UserController@updateCurrent');
        Route::get('/me/dashboard', 'UserController@dashboard');

        Route::get('/me/request', 'AccountIntentController@show');
        Route::post('/me/request', 'AccountIntentController@update');
        Route::post('/me/request/submit', 'AccountIntentController@submit');

        /*
         * Departments and Disciplines.
         */
        Route::get('/disciplines', 'DisciplineController@index');
        Route::post('/disciplines', 'DisciplineController@store');
        Route::put('/disciplines/{discipline}', 'DisciplineController@update');

        Route::get('/departments', 'DepartmentController@index');
        Route::post('/departments', 'DepartmentController@store');
        Route::put('/departments/{department}', 'DepartmentController@update');

        /**
         * People.
         */
        Route::get('/people/stats', 'PeopleController@stats');
        Route::get('/people/students', 'StudentController@index');
        Route::get('/people/students/{student}', 'StudentController@show');
        Route::get('/people/teachers', 'TeacherController@index');
        Route::get('/people/teachers/{teacher}', 'TeacherController@show');
        Route::get('/people/employees', 'EmployeeController@index');
        Route::get('/people/employees/{employee}', 'EmployeeController@show');

        /**
         * Intents.
         */
        Route::get('/intents', 'IntentController@index');
        Route::get('/intents/{intent}', 'IntentController@show');
        Route::put('/intents/{intent}', 'IntentController@update');
        Route::post('/intents/{intent}/accept', 'IntentController@accept');
        Route::post('/intents/{intent}/reject', 'IntentController@reject');


        /**
         * Groups.
         */
        Route::get('/groups', 'GroupController@index');
        Route::post('/groups', 'GroupController@store');
        Route::get('/groups/{group}', 'GroupController@show');
        Route::put('/groups/{group}', 'GroupController@update');
        Route::get('/groups/{group}/members', 'GroupController@members');
        Route::put('/groups/{group}/add', 'GroupController@addMember');
        Route::delete('/groups/{group}/remove', 'GroupController@addMember');
    }
);
