<?php

$resource = ['except' => ['edit', 'create']];
$extra = ['only' => ['store', 'destroy']];

// Schools
Route::get('/schools', 'Schools\SchoolController@index');
Route::get('/school', 'Schools\CurrentSchoolController@index');
Route::put('/school', 'Schools\CurrentSchoolController@update');
Route::post('/school/logo', 'Schools\FileController@store');

Route::resource('/disciplines', 'Schools\DisciplineController', $resource);
Route::resource('/departments', 'Schools\DepartmentController', $resource);
Route::resource('/semesters', 'Schools\SemesterController', $resource);

// Cities
Route::get('/geo/cities', 'CitiesController@index');

Route::get('/me', 'Users\CurrentUserController@index');
Route::put('/me', 'Users\CurrentUserController@update');
Route::get('/me/dashboard', 'Users\DashboardController@index');

// Students
Route::resource('/people/students', 'Students\StudentController', ['only' => ['index', 'show', 'update']]);
Route::post('/people/students/invite', 'Students\StudentController@invite');
Route::post('/people/students/{uid}/photo', 'Students\PhotoController@store');

// Teachers
Route::resource('/people/teachers', 'Teachers\TeacherController', ['only' => ['index', 'show', 'update']]);
Route::post('/people/teachers/invite', 'Teachers\TeacherController@invite');
Route::post('/people/teachers/{uid}/photo', 'Students\PhotoController@store');


// Employees
Route::resource('/people/employees', 'Employees\EmployeeController', ['only' => ['index', 'show']]);
Route::post('/people/employees/invite', 'Employees\EmployeeController@invite');

// People
Route::get('/people', 'PeopleController@index');
Route::get('/people/stats', 'PeopleController@stats');
Route::get('/people/{person}', 'PeopleController@show');

Route::get('people/roles/{role}', 'RoleController@index');
Route::post('people/roles', 'RoleController@store');


// Groups
Route::resource('/groups', 'Groups\GroupController', $resource);

Route::get('/groups/{group}/members', 'Groups\MemberController@index');
Route::post('/groups/{group}/members/add', 'Groups\MemberController@store');
Route::delete('/groups/{group}/members/remove', 'Groups\MemberController@destroy');

Route::put('/groups/{group}/messages/{message}/read', 'Groups\MessageController@read');
Route::resource('/groups/{group}/messages', 'Groups\MessageController', ['only' => ['index', 'store']]);

Route::post('/groups/{group}/photo', 'Groups\PhotoController@store');
Route::delete('/groups/{group}/photo', 'Groups\PhotoController@destroy');

Route::get('/me/groups', 'Groups\CurrentUserController@index'); // NOTE: Lists groups current user is member of.
Route::get('/me/groups/{group}', 'Groups\CurrentUserController@show');
Route::post('/groups/{group}/join', 'Groups\CurrentUserController@store');
Route::delete('/groups/{group}/leave', 'Groups\CurrentUserController@delete');

Route::post('/groups/{group}/attachment', 'Groups\FileController@store');

// Messages
Route::post('/messages/attachment', 'Messages\FileController@store');
Route::put('/messages/{message}/read', 'Messages\MessageController@read');
Route::put('/me/messages/{message}/read', 'Messages\MessageController@read'); // TODO: Remove this.
Route::post('/me/messages/users/{user}', 'Messages\MessageController@store'); // TODO: Remove this.
Route::resource('/messages', 'Messages\MessageController', ['only' => ['store']]);

Route::get('/me/messages/users/{user}', 'Messages\MessageController@index');
Route::get('/me/messages/users', 'Messages\CurrentUserController@index');

// Courses
Route::get('/me/courses', 'Courses\CurrentUserController@index');
Route::get('me/courses/{course}/enrolled', 'Courses\EnrollmentController@index');
Route::post('/courses/{course}/enroll', 'Courses\EnrollmentController@store');
Route::resource('courses', 'Courses\CourseController', $resource);

// Intents
Route::post('/intents/{intent}/accept', 'Users\IntentController@accept');
Route::post('/intents/{intent}/reject', 'Users\IntentController@reject');
Route::post('/intents/{intent}/lock', 'Users\IntentController@lock');
Route::resource('intents', 'Users\IntentController', $resource);
