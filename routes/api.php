<?php

$resource = ['except' => ['edit', 'create']];
$extra = ['only' => ['store', 'destroy']];
// Schools
Route::get('/schools', 'Schools\SchoolController@index');

// Cities
Route::get('/geo/cities', 'CitiesController@index');

// Current School
Route::get('/school', 'Schools\CurrentSchoolController@index');
Route::put('/school', 'Schools\CurrentSchoolController@update');

// Current User
Route::get('/me', 'Users\CurrentUserController@index');
Route::put('/me', 'Users\CurrentUserController@update');
Route::get('/me/dashboard', 'Users\DashboardController@index');

// Disciplines
Route::get('/disciplines', 'DisciplineController@index');
Route::post('/disciplines', 'DisciplineController@store');
Route::put('/disciplines/{discipline}', 'DisciplineController@update');

// Departments
Route::get('/departments', 'DepartmentController@index');
Route::post('/departments', 'DepartmentController@store');
Route::put('/departments/{department}', 'DepartmentController@update');

// People
Route::get('/people', 'PeopleController@index');
Route::get('/people/{person}', 'PeopleController@show');
Route::get('/people/stats', 'PeopleController@stats');
Route::get('/people/students', 'StudentController@index');
Route::get('/people/students/{student}', 'StudentController@show');
Route::get('/people/teachers', 'TeacherController@index');
Route::get('/people/teachers/{teacher}', 'TeacherController@show');
Route::get('/people/employees', 'EmployeeController@index');
Route::get('/people/employees/{employee}', 'EmployeeController@show');

// Groups
Route::get('/groups', 'Groups\GroupController@index');
Route::post('/groups', 'Groups\GroupController@store');
Route::get('/groups/{group}', 'Groups\GroupController@show');
Route::put('/groups/{group}', 'Groups\GroupController@update');

// Group & Members
Route::put('/groups/{group}/add', 'Groups\MemberController@addMember');
Route::delete('/groups/{group}/remove', 'Groups\MemberController@removeMember');
Route::get('/groups/{group}/members', 'Groups\MemberController@index');

// Group & Messages
Route::get('/groups/{group}/messages', 'Groups\MessageController@index');
Route::post('/groups/{group}/messages', 'Groups\MessageController@store');
Route::put('/groups/messages/{message}', 'Groups\MessageController@update'); // THIS BREAKS RESOURCE API.
Route::put('/groups/{group}/messages/{message}', 'Groups\MessageController@update');

// Group & Users
Route::put('/groups/{group}/join', 'Users\GroupController@store');
Route::delete('/groups/{group}/leave', 'Users\GroupController@delete');

Route::post('/groups/{group}/photo', 'Groups\PhotoController@store');
Route::delete('/groups/{group}/photo', 'Groups\PhotoController@destroy');

// User & Groups
Route::get('/me/groups', 'Users\GroupController@index');

// Message
Route::get('/me/messages/users/{user}', 'Messages\MessageController@index');
Route::post('/me/messages/users/{user}', 'Messages\MessageController@store');
Route::put('/me/messages/{message}/read', 'Messages\MessageController@update');

// User & Messaged Users.
Route::get('/me/messages/users', 'Messages\UserController@index');

// Courses
Route::resource('courses', 'CourseController', $resource);

// -- Authenticated routes.
Route::group(['middleware' => 'auth:api,web'],
    function () {
        Route::get('/me/request', 'AccountIntentController@show');
        Route::post('/me/request', 'AccountIntentController@update');
        Route::post('/me/request/submit', 'AccountIntentController@submit');

        Route::get('/intents', 'IntentController@index');
        Route::get('/intents/{intent}', 'IntentController@show');
        Route::put('/intents/{intent}', 'IntentController@update');
        Route::post('/intents/{intent}/accept', 'IntentController@accept');
        Route::post('/intents/{intent}/reject', 'IntentController@reject');
    }
);
