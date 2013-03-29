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

// Default root route
Route::get('/', array('before' => 'auth', function()
{
  return View::make('hello');
}));

// Route for `login` GET
Route::get('/login', array('before' => 'guest', function()
{
  return View::make('login');
}));

// Route for `login` POST
Route::post('/login', array('before' => 'guest|csrf', function() 
{
  $creds = array('email' => Input::get('email'), 'password' => Input::get('password'));
  $remember = Input::has('remember');

  if( ! Auth::attempt($creds, $remember) ) {
    Session::flash('auth_error', 'Invalid email and/or password entered.');
    return Redirect::to('login')->withInput();
  }

  return Redirect::to('/');
}));

// Route for `logout` GET
Route::get('/logout', function()
{
  Auth::logout();
  return Redirect::to('/');
});
