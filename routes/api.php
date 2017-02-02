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
Route::post('/people/teachers/{uid}/photo', 'Teachers\PhotoController@store');


// Employees
Route::resource('/people/employees', 'Employees\EmployeeController', ['only' => ['index', 'show', 'update']]);
Route::post('/people/employees/invite', 'Employees\EmployeeController@invite');
Route::post('/people/employees/{uid}/photo', 'Employees\PhotoController@store');


// People
Route::get('/people', 'PeopleController@index');
Route::get('/people/stats', 'PeopleController@stats');
Route::get('/people/{person}', 'PeopleController@show');

Route::get('people/roles/{role}', 'RoleController@index');
Route::post('people/roles', 'RoleController@store');

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

//======================================================================================//
//                                 Communication                                        //
//======================================================================================//

// - Groups
Route::get(     '/groups/{group}/members', 'Groups\MemberController@index');
Route::post(    '/groups/{group}/members/add', 'Groups\MemberController@store');
Route::delete(  '/groups/{group}/members/remove', 'Groups\MemberController@destroy');
Route::get(     '/groups/{group}/messages', 'Groups\MessageController@index');
Route::post(    '/groups/{group}/messages', 'Groups\MessageController@store');
Route::post(    '/groups/{group}/photo', 'Groups\ProfilePhotoController@store');
Route::delete(  '/groups/{group}/photo', 'Groups\ProfilePhotoController@destroy');
Route::post(    '/groups/{group}/join', 'Groups\CurrentUserController@store');
Route::delete(  '/groups/{group}/leave', 'Groups\CurrentUserController@delete');
Route::post(    '/groups/{group}/attachment', 'Groups\MessageAttachmentController@store');
Route::resource('/groups', 'Groups\GroupController', $resource);

// - Direct Messages
Route::get('/messages/direct/{user}', 'Messages\CurrentUserController@messages');
Route::post('/messages/direct/{user}/attachment', 'Messages\FileController@store');

// - Messages
Route::post('/messages', 'Messages\MessageController@store');
Route::put( '/messages/{message}/read', 'Messages\MessageController@read');

// - User Context
Route::get('/me/groups', 'Groups\CurrentUserController@index');
Route::get('/me/groups/{group}', 'Groups\CurrentUserController@show');
Route::get('/me/users', 'Messages\CurrentUserController@index');
Route::get('/me/users/{user}', 'Messages\CurrentUserController@show');

