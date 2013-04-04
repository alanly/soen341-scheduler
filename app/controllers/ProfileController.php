<?php

class ProfileController extends BaseController {

  public function __construct()
  {

    $this->beforeFilter('auth');
    $this->beforeFilter('csrf', array('on' => 'post'));

  }

  public function getIndex()
  {

    $user = Auth::user();
    $programs = Program::all();
    $programOptions = array();

    foreach( $programs as $p )
      $programOptions[$p->id] = $p->programOptions;

    return View::make('profile.index')
      ->with('user', $user)
      ->with('programs', $programs)
      ->with('programOptions', $programOptions);

  }

  public function postIndex()
  {

    $rules = array(
      'name' => 'required',
      'email' => 'required|email',
      'id' => 'required|min:7',
      'new_password' => 'min:6|confirmed',
      'program' => 'required|exists:programs,id',
      'program_option' => 'required|exists:program_options,id'
    );

    $validator = Validator::make( Input::all(), $rules );

    if( $validator->fails() ) {
      Session::flash('action_success', false);
      Session::flash('action_message', 'Please correct the errors below before continuing.');

      return Redirect::action('ProfileController@getIndex')
        ->withErrors($validator)
        ->withInput();
    }

    // Check current password
    $oldCreds = array(
      'email' => Auth::user()->email,
      'password' => Input::get('current_password')
    );

    if( ! Auth::validate($oldCreds) ) {
      Session::flash('action_success', false);
      Session::flash('action_message', 'Please ensure that your current password field is correct.');

      return Redirect::action('ProfileController@getIndex')
        ->withInput();
    }

    $user = Auth::user();

    $user->name = Input::get('name');
    $user->email = Input::get('email');
    $user->university_id = Input::get('id');
    $user->program_id = Input::get('program');
    $user->option_id = Input::get('program_option');

    if( Input::has('new_password') )
      $user->password = Hash::make( Input::get('new_password') );

    $action_success = $user->save();

    Session::flash('action_success', $action_success);
    Session::flash('action_message', $action_success ? 'Your profile has been updated.' : 'An unknown error occured while attempting to update your profile. Try again later?');

    return Redirect::action('ProfileController@getIndex');

  }

}
