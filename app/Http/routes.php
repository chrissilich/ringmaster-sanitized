<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::get('/', 'HomeController@index');
// classes
Route::get('class/all', 						'ClassroomController@all');
Route::get('class/join', 						'ClassroomController@join');
Route::post('class/join', 						'ClassroomController@storejoin');
Route::delete('class/{class}/upload/{upload}', 	'ClassroomController@upload_detach');
Route::get('class/{id}/leave/', 				'ClassroomController@leave');
Route::get('class/{id}/code/', 					'ClassroomController@generate_code');
Route::any('class/{id}/role/{user}/{role}', 	'ClassroomController@role');
Route::any('class/{id}/gather', 				'ClassroomController@gather');

// setup
Route::get('/setup', 							'SetupController@index');
Route::get('/setup/name', 						'SetupController@name');
Route::post('/setup/name', 						'SetupController@doName');
Route::get('/setup/classes', 					'SetupController@classes');
Route::post('/setup/classes', 					'SetupController@doClasses');
Route::get('/setup/done', 						'SetupController@done');


Route::get('user/login', 						'UserController@login');
Route::post('user/login', 						'UserController@doLogin');
Route::any('user/logout', 						'UserController@logout');
Route::any('user/validate',		 				'UserController@tokenNotValidated');
Route::any('user/validate/resend',				'UserController@requestNewValidationToken');
Route::get('user/validate/{token}', 			'UserController@validateToken');
Route::any('user/validated', 					'UserController@validatedToken');
Route::get('user/forgot',		 				'UserController@forgot');
Route::post('user/forgot',						'UserController@forgotSend');
Route::any('user/forgot/bad', 					'UserController@forgotBadCode');
Route::get('user/forgot/{token}', 				'UserController@forgotToken');
Route::post('user/forgot/{token}', 				'UserController@forgotValidate');

// events
Route::get('{belongs_to_type}/{belongs_to_id}/event/create', 	'CalendarEventController@create');

// posts
Route::get('{belongs_to_type}/{belongs_to_id}/post/create', 	'PostController@create');

// grades
Route::post('grade/update', 					'GradeController@update');
Route::post('class/{cid}/assignment/weight', 	'AssignmentController@weight');


// RESTFUL STUFF
Route::resource('user', 						'UserController');
Route::resource('class', 						'ClassroomController');
Route::resource('class.assignment',				'AssignmentController');
Route::resource('class.assignment.submission',	'AssignmentSubmissionController', ['only' => 'store']);
Route::resource('upload', 						'UploadController', ['only' => ['store', 'destroy']]);


Route::get('event/create/{type}/{id}', 			'CalendarEventController@create');
Route::get('post/create/{type}/{id}', 			'PostController@create');

// Formerly RESTful stuff that had custom "belongs to" logic and needs explicitly defined routes
Route::resource('event', 						'CalendarEventController', ['only' => ['show', 'store']]);
Route::resource('post', 						'PostController', ['only' => ['index', 'show', 'store']]);

Route::get('upload-modern/create', 				'UploadModernController@create');
Route::post('upload-modern/store', 				'UploadModernController@store');



Route::get('/debug-sentry', function () {
    throw new Exception('My first Sentry error!');
});
