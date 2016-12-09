<?php

$resource = ['except' => ['edit', 'create']];
$extra = ['only' => ['store', 'destroy']];

// Schools
Route::get('/schools', 'Schools\SchoolController@index');
Route::resource('/school', 'Schools\CurrentSchoolController', ['only' => ['index', 'update']]);
Route::resource('/disciplines', 'Schools\DisciplineController', $resource);
Route::resource('/departments', 'Schools\DepartmentController', $resource);


// Cities
Route::get('/geo/cities', 'CitiesController@index');

Route::get('/me', 'Users\CurrentUserController@index');
Route::put('/me', 'Users\CurrentUserController@update');
Route::get('/me/dashboard', 'Users\DashboardController@index');

// People
Route::get('/people', 'PeopleController@index');
Route::get('/people/{person}', 'PeopleController@show');
Route::get('/people/stats', 'PeopleController@stats');

// Students
Route::resource('/people/students', 'Students\StudentController', ['only' => ['index', 'show']]);

// Teachers
Route::resource('/people/teachers', 'Teachers\TeacherController', ['only' => ['index', 'show']]);

// Employees
Route::resource('/people/employees', 'Employees\EmployeeController', ['only' => ['index', 'show']]);

// Groups
Route::resource('/groups', 'Groups\GroupController', $resource);

Route::get('/groups/{group}/members', 'Groups\MemberController@index');
Route::post('/groups/{group}/members/add', 'Groups\MemberController@store');
Route::delete('/groups/{group}/members/remove', 'Groups\MemberController@destroy');

Route::put('/groups/{group}/messages/{message}/read', 'Groups\MessageController@read');
Route::resource('/groups/{group}/messages', 'Groups\MessageController', ['except' => ['edit', 'create', 'update']]);

Route::put('/groups/{group}/photo', 'Groups\PhotoController@store');
Route::delete('/groups/{group}/photo', 'Groups\PhotoController@destroy');

Route::get('/me/groups', 'Groups\CurrentUserController@index'); // NOTE: Lists groups current user is member of.
Route::post('/groups/{group}/join', 'Groups\CurrentUserController@store');
Route::delete('/groups/{group}/leave', 'Groups\CurrentUserController@delete');

// Messages
Route::put('/messages/{message}/read', 'Messages\MessageController@read');
Route::put('/me/messages/{message}/read', 'Messages\MessageController@read'); // TODO: Remove this.
Route::post('/me/messages/users/{user}', 'Messages\MessageController@store'); // TODO: Remove this.
Route::resource('/messages', 'Messages\MessageController', ['only' => ['store']]);

Route::get('/me/messages/users/{user}', 'Messages\MessageController@index');
Route::get('/me/messages/users', 'Messages\CurrentUserController@index');

// Courses
Route::resource('courses', 'Courses\CourseController', $resource);
