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
  return View::make('dashboard');
}));

// Route for `login` GET
Route::get('/login', array('as' => 'login', 'before' => 'guest', function()
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

// Route for `register` GET
Route::get('/register', array('as' => 'register', 'before' => 'guest', function()
{
  $programs = Program::all();
  $programOptions = array();

  foreach($programs as $p)
    $programOptions[$p->id] = $p->programOptions;

  return View::make('register')->with('programs', $programs)->with('programOptions', $programOptions);
}));

// Route for `register` POST; handles registration process.
Route::post('/register', array('before' => 'guest|csrf', function()
{
  // Define the validator rules.
  $rules = array(
    'name' => array('required'),
    'email' => array('required','email','unique:users'),
    'id' => array('required','numeric','unique:users'),
    'password' => array('required','confirmed','min:6'),
    'program' => array('required', 'exists:programs,id'),
    'program_option' => array('required', 'exists:program_options,id')
  );

  // Create a validator based on the rules, to validate registration form input.
  $validator = Validator::make(Input::all(), $rules);

  // Check validation results and notify user if the fail.
  if( $validator->fails() ) {
    Session::flash('action_error', 'There are mistakes in your form. Please correct them and try again.');
    return Redirect::to('register')->withErrors($validator)->withInput();
  }

  $user = new User;
  $user->university_id = Input::get('id');
  $user->name = Input::get('name');
  $user->email = Input::get('email');
  $user->password = Hash::make(Input::get('password'));
  $user->program_id = Input::get('program');
  $user->option_id = Input::get('program_option');
  $user->is_admin = 0;

  $save_success = $user->save();

  // Attempt to authenticate the newly saved user.
  $auth_success = Auth::attempt( array('email' => Input::get('email'), 'password' => Input::get('password')) );

  // If it works, then redirect user to dashboard.
  if( $save_success && $auth_success )
    return Redirect::to('/');

  // ... otherwise, redirect back to form, with input and flash an error message.
  Session::flash('action_error', 'A server-side error occured while creating a new user. Maybe try again later?');

  Log::error('Error occured while creating a new user: "save_success"=' . $save_success . ', "auth_success"=' . $auth_success);

  return Redirect::to('/register')->withInput();

}));

// Route group for password reset purposes.
Route::group(array('prefix' => 'recover'), function()
{

  // Route for `recover` GET
  Route::get('/', array('as' => 'recover', function()
  {
    return View::make('recover');
  }));

  // Route for `recover` POST; process reset request
  Route::post('/', array('before' => 'csrf', function()
  {
    return Password::remind(array('email' => Input::get('email')), function($m) {
      $m->subject('schdlr. Password Reset Confirmation.');
    });

  }));

  // Route for `reset` GET
  Route::get('/reset/{token}', array('as' => 'reset', function($token)
  {
    return View::make('recover_reset')->with('token', $token);
  }));

  // Route for `reset` POST request; handle the reset.
  Route::post('/reset/{token}', function($token)
  {
    return Password::reset( array('email' => Input::get('email')), function($user, $password) {
      $user->password = Hash::make($password);
      $user->save();

      return Redirect::to('/');
    });
  });

});

// Define controller route for AcademicRecord
Route::controller('academicrecord', 'AcademicRecordController');

// Define controller route for Course
Route::controller('course', 'CourseController');

// Define controller route for Profile
Route::controller('profile', 'ProfileController');

// Define routes for administrative interface
Route::group( array('prefix' => 'admin', 'before' => 'auth|admin'), function()
{

  Route::get('/', function()
  {
    return Redirect::action('AdminUserController@index');
  });
  
  Route::resource('user', 'AdminUserController');

});
