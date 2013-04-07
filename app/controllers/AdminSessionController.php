<?php

class AdminSessionController extends BaseController {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
    
    $sessions = SchoolSession::with('schedules')->get();

    return View::make('admin.session.index')->with('sessions', $sessions);

	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{

    $rules = array(
      'year' => 'required|numeric|date_format:Y',
      'season' => 'required|in:1,2,4'
    );

    $validator = Validator::make( Input::all(), $rules );

    if( $validator->fails() ) {
      Session::flash('action_success', false);
      Session::flash('action_message', 'There is an error in your form. Please correct it and try again.');

      return Redirect::action('AdminSessionController@index')->withErrors($validator)->withInput();
    }

    $sessionCode = Input::get('year') . '-' . Input::get('season');

    if( SchoolSession::where('code', 'like', '%' . $sessionCode . '%')->count() > 0 ) {
      Session::flash('action_success', false);
      Session::flash('action_message', 'The specified session already exists in the database.');

      return Redirect::action('AdminSessionController@index')->withInput();
    }

    $session = SchoolSession::create( array('code' => $sessionCode) );

    $action_success = $session === false ? false : true;

    Session::flash('action_success', $action_success);
    Session::flash('action_message', $action_success ? 'Session "' . $sessionCode . '" has been successfully created.' : 'Unable to create the specified session due to an internal error. Try again later?');

    return Redirect::action('AdminSessionController@index');

	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{

    $session = SchoolSession::find($id);

    if( is_null($session) ) {
      Session::flash('action_success', false);
      Session::flash('action_message', 'The specified section does not exist.');

      return Redirect::action('AdminSessionController@index');
    }

    $sessionCode = $session->code;

    $session->delete();

    $action_success = !( SchoolSession::where('code', 'like', '%' . $sessionCode . '%')->count() > 0 );

    Session::flash('action_success', $action_success);
    Session::flash('action_message', $action_success ? 'Session "' . $sessionCode . '" has been successfully removed.' : 'Unable to remove the session due to an internal error. Try again later?');

    return Redirect::action('AdminSessionController@index');

	}

}
