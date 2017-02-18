<?php

$resource = ['except' => ['edit', 'create']];

// Schools
Route::get('/schools', 'Api\Schools\SchoolController@index');
Route::get('/school', 'Api\Schools\CurrentSchoolController@index');
Route::put('/school', 'Api\Schools\CurrentSchoolController@update');
Route::post('/school/logo', 'Api\Schools\FileController@store');

Route::get('/me', 'Api\Users\CurrentUserController@index');
Route::put('/me', 'Api\Users\CurrentUserController@update');
Route::get('/me/dashboard', 'Api\Users\DashboardController@index');

Route::get('people/roles/{role}', 'Api\RoleController@index');
Route::post('people/roles', 'Api\RoleController@store');


//======================================================================================//
//                                School Services                                       //
//======================================================================================//
Route::resource('/disciplines', 'Api\Schools\DisciplineController', $resource);
Route::resource('/departments', 'Api\Schools\DepartmentController', $resource);
Route::resource('/semesters',   'Api\Schools\SemesterController',   $resource);
Route::resource('/sessions',    'Api\Schools\SessionController',    $resource);


//======================================================================================//
//                                Shared Services                                       //
//======================================================================================//
Route::get(     '/geo/cities',        'Api\CitiesController@index');
Route::get(     '/geo/cities/{city}', 'Api\CitiesController@show');

//======================================================================================//
//                                    People                                            //
//======================================================================================//

// - Students
Route::get(     '/people/students/{student}/address', 'Api\People\Students\AddressController@show');
Route::put(     '/people/students/{student}/address', 'Api\People\Students\AddressController@update');
Route::get(     '/people/students/{student}/photo',   'Api\People\Students\PhotoController@show');
Route::post(    '/people/students/{student}/photo',   'Api\People\Students\PhotoController@store');
Route::get(     '/people/students/{student}/father',  'Api\People\Students\GuardianController@father');
Route::put(     '/people/students/{student}/father',  'Api\People\Students\GuardianController@updateFather');
Route::get(     '/people/students/{student}/mother',  'Api\People\Students\GuardianController@mother');
Route::put(     '/people/students/{student}/mother',  'Api\People\Students\GuardianController@updateMother');
Route::resource('/people/students',                   'Api\People\Students\StudentController', $resource);

// - Teachers
Route::get(     '/people/teachers/{teacher}/address', 'Api\People\Teachers\AddressController@show');
Route::put(     '/people/teachers/{teacher}/address', 'Api\People\Teachers\AddressController@update');
Route::get(     '/people/teachers/{teacher}/photo',   'Api\People\Teachers\PhotoController@show');
Route::post(    '/people/teachers/{teacher}/photo',   'Api\People\Teachers\PhotoController@store');
Route::resource('/people/teachers',                   'Api\People\Teachers\TeacherController', $resource);

// - Employees
Route::get(     '/people/employees/{employee}/address', 'Api\People\Employees\AddressController@show');
Route::put(     '/people/employees/{employee}/address', 'Api\People\Employees\AddressController@update');
Route::get(     '/people/employees/{employee}/photo', 'Api\People\Employees\PhotoController@show');
Route::post(    '/people/employees/{employee}/photo', 'Api\People\Employees\PhotoController@store');
Route::resource('/people/employees',                  'Api\People\Employees\EmployeeController', $resource);

// - People Common
Route::get(     '/people',            'Api\People\PersonController@index');
Route::get(     '/people/statistics', 'Api\People\StatisticsController@index');
Route::post(    '/people/invite',     'Api\People\InvitationController@invite');
Route::get(     '/people/{user}',     'Api\People\PersonController@show');

//======================================================================================//
//                                 Communication                                        //
//======================================================================================//

// - Groups
Route::get(     '/groups/{group}/members',        'Api\Groups\MemberController@index');
Route::post(    '/groups/{group}/members',        'Api\Groups\MemberController@store');
Route::delete(  '/groups/{group}/members',        'Api\Groups\MemberController@destroy');
Route::get(     '/groups/{group}/messages',       'Api\Groups\MessageController@index');
Route::post(    '/groups/{group}/messages',       'Api\Groups\MessageController@store');
Route::post(    '/groups/{group}/photo',          'Api\Groups\ProfilePhotoController@store');
Route::delete(  '/groups/{group}/photo',          'Api\Groups\ProfilePhotoController@destroy');
Route::post(    '/groups/{group}/join',           'Api\Groups\CurrentUserController@store');
Route::delete(  '/groups/{group}/leave',          'Api\Groups\CurrentUserController@delete');
Route::post(    '/groups/{group}/attachment',     'Api\Groups\MessageAttachmentController@store');
Route::resource('/groups',                        'Api\Groups\GroupController', $resource);

// - Direct Messages
Route::get(     '/messages/direct/{user}/messages',   'Api\Messages\Direct\MessageController@index');
Route::post(    '/messages/direct/{user}/messages',   'Api\Messages\Direct\MessageController@store');
Route::post(    '/messages/direct/{user}/attachment', 'Api\Messages\Direct\MessageAttachmentController@store');

// - Messages
Route::put(     '/messages/read', 'Api\Messages\MessageController@read');

// - User Context
Route::get(     '/me/groups',         'Api\Groups\CurrentUserController@index');
Route::get(     '/me/groups/{group}', 'Api\Groups\CurrentUserController@show');
Route::get(     '/me/users',          'Api\Messages\CurrentUserController@index');
Route::get(     '/me/users/{user}',   'Api\Messages\CurrentUserController@show');


//======================================================================================//
//                                  Academics                                           //
//======================================================================================//

Route::get(     'courses/{course}/enrolled',                    'Api\Courses\EnrollmentController@index');
Route::get(     'courses/{course}/sessions/{session}/enrolled', 'Api\Courses\EnrollmentController@index');
Route::post(    'courses/{course}/sessions/{session}/enroll',   'Api\Courses\EnrollmentController@store');
Route::delete(  'courses/{course}/sessions/{session}/expel',    'Api\Courses\EnrollmentController@destroy');
Route::resource('courses/{course}/sessions',                    'Api\Courses\SessionController', $resource);
Route::get(     'courses/{course}/instructors',                 'Api\Courses\InstructorController@index');
Route::post(    'courses/{course}/instructors',                 'Api\Courses\InstructorController@store');
Route::delete(  'courses/{course}/instructors',                 'Api\Courses\InstructorController@destroy');
Route::resource('courses',                                      'Api\Courses\CourseController', $resource);

Route::get('me/courses', 'Api\Courses\CurrentUserController@index');
