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

use App\Question;
use App\User;

Route::get('/', function ()
{
	return redirect('/course');
});


Route::get('make', function()
{
	// $user = new User();
	// $user->email = "temu92@gmail.com";
	// $user->password = bcrypt("asdfasdf");
	// $user->save();
});

Route::group(['prefix' => 'course'], function()
{
	Route::get('/', function()
	{
		return view('course.list', [
			'courses' => App\Course::all(),
		]);
	});

	Route::get('{id}', function($id)
	{
		return view('course.tests', [
			'course' => App\Course::findOrFail($id),
		]);
	});
});

// Route::get('test/{id}', function($id)
// {
// 	$test = App\Test::findOrFail($id);
	
// 	return view('test.show')
// 			->with([
// 				'test' => $test,
// 			]);
// });

// Route::post('test/{id}', function($id, Request $request)
// {
// 	$test = App\Test::findOrFail($id);
	
// 	return view('test.show')
// 			->with([
// 				'test' => $test,
// 			])
// 			->withInput();
// });

Route::get('test/{id}', 'TestsController@show');
Route::post('test/{id}', 'TestsController@check');

Route::group(['prefix' => 'ajax', 'middleware' => 'auth.ajax'], function()
{
	Route::get('/', function ()
	{
		return redirect('/');
	});

	Route::get('/questions', function ()
	{
		$question = Question::all();
		return $question;
	});

	Route::get('/questions/{id}', function ($id)
	{
		$question = Question::findOrFail($id);
		$question->answers;
		return $question;
	});

	Route::resource('courses', 'Ajax\CoursesController');
	Route::resource('tests', 'Ajax\TestsController');

});

Route::group(['prefix' => 'admin', 'middleware' => 'auth.admin'], function()
{
	Route::get('/', function ()
	{
		return view('admin.index');
	});
});


Route::group(['prefix' => 'auth'], function()
{
	Route::get('login', 'AuthController@index');
	Route::post('login', 'AuthController@login');
	Route::get('logout', 'AuthController@logout');
});