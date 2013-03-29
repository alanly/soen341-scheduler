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
Route::get('/admin/users', function()
{
        return View::make('admin-users');
});
Route::get('/admin/programs', function()
{
        return View::make('admin-programs');
});
Route::get('/admin/options', function()
{
        return View::make('admin-options');
});



