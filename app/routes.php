<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the Closure to execute when that URI is requested.
|
*/
Route::get('/', function()
{
        return View::make('main');
});
Route::get('/acedemic', function()
{
        return View::make('acedemic');
});
Route::resource('admin/users', 'AdminUserController');
Route::resource('admin/programs', 'AdminProgramController');
Route::resource('admin/options', 'AdminProgramOptionController');
Route::resource('admin/courses', 'AdminCourseController');
