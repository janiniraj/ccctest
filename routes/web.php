<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

/*
 * Backend Routes
 * Namespaces indicate folder structure
 */
Route::group(['namespace' => 'Backend', 'prefix' => 'admin', 'as' => 'admin.', 'middleware' => 'admin'], function ()
{
    Route::resource('students', 'StudentController');

    Route::resource('subjects', 'SubjectController');

    Route::resource('marks', 'MarkController');

    Route::get('/subjects/get-by-semester/{id}', 'SubjectController@getBySemester')->name('subjects.get-by-semester');
});

/*
 * Student Routes
 * Namespaces indicate folder structure
 */
Route::group(['namespace' => 'Student', 'prefix' => 'student', 'as' => 'student.', 'middleware' => 'student'], function ()
{
    Route::get('info', 'StudentController@info')->name('info');
    Route::get('marks/info', 'StudentController@marksInfo')->name('marks-info');
});
