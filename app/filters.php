<?php

/*
|--------------------------------------------------------------------------
| Application & Route Filters
|--------------------------------------------------------------------------
|
| Below you will find the "before" and "after" events for the application
| which may be used to do any work before or after a request into your
| application. Here you may also register your custom route filters.
|
*/

App::before(function($request)
{
	//
});


App::after(function($request, $response)
{
	//
});

/*
|--------------------------------------------------------------------------
| Authentication Filters
|--------------------------------------------------------------------------
|
| The following filters are used to verify that the user of the current
| session is logged into this application. Also, a "guest" filter is
| responsible for performing the opposite. Both provide redirects.
|
*/

Route::filter('auth', function()
{
	if (Auth::guest()) return Redirect::to('login');
});


Route::filter('guest', function()
{
	if (Auth::check()) return Redirect::to('/');
});

Route::filter('admin', function()
{
  if (Auth::user()->is_admin == 0) App::abort('401', 'You are not authorized to access this section.');
});

/*
|--------------------------------------------------------------------------
| CSRF Protection Filter
|--------------------------------------------------------------------------
|
| The CSRF filter is responsible for protecting your application against
| cross-site request forgery attacks. If this special token in a user
| session does not match the one given in this request, we'll bail.
|
*/

Route::filter('csrf', function()
{
	if (Session::getToken() != Input::get('_token'))
	{
		throw new Illuminate\Session\TokenMismatchException;
	}
});

/*
 * Set the current session.
 */

Route::filter('setSchoolSession', function()
{
  if( Input::has('session') ) {
    $validator = Validator::make(
      array('session' => Input::get('session')),
      array('session' => 'required|exists:school_sessions,id')
    );

    if( $validator->fails() ) {
      Session::flash('action_success', false);
      Session::flash('action_message', 'The requested section does not exist.');
    } else {
      Session::put('schoolSession', Input::get('session'));
    }
  } else if( ! Session::has('schoolSession') ) {
    Session::put('schoolSession', SchoolSession::orderBy('id', 'desc')->first()->id);
  }
});

