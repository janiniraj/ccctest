<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/login', 'API\AuthController@login')->name('login');
Route::group(['middleware' => 'jwt.auth'], function(){
  Route::get('student/info', 'API\StudentController@info')->name('info');

  Route::get('admin/students', 'API\AdminController@studentListing')->name('students.index');
  Route::post('admin/student/create', 'API\AdminController@studentCreate')->name('students.create');
  Route::post('admin/student/edit/{id}', 'API\AdminController@studentUpdate')->name('students.update');
});
