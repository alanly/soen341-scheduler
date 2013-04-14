<?php

class AdminUserController extends BaseController {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
  {

    $users = User::all();

    return View::make('admin.user.index')->with('users', $users);

	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
  {

    $user = User::find($id);

    if( is_null($user) ) {
      Session::flash('action_success', false);
      Session::flash('action_message', 'The specified user could not be found.');

      return Redirect::action('AdminUserController@index');
    }

    return View::make('admin.user.show')->with('user', $user);

	}

	/**
	 * Promote or demote the user to/from administrator role.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{

    $user = User::find($id);

    if( is_null($user) ) {
      Session::flash('action_success', false);
      Session::flash('action_message', 'The specified user could not be found.');

      return Redirect::action('AdminUserController@index');
    }

    // Make sure this isn't the primary administrator account.
    if( $user->id != 1 ) {
      $user->is_admin = ($user->is_admin == 1 ? 0 : 1);
      
      $action_success = $user->save();

      Session::flash('action_success', $action_success);
      Session::flash('action_message', $action_success ? 'User role modified successfully.' : 'Unable to user role due to an internal error. Try again later?');
    } else {
      Session::flash('action_success', false);
      Session::flash('action_message', 'You cannot demote the primary administrator account.');
    }

    return View::make('admin.user.show')->with('user', $user);

	}

	/**
	 * Remove the specified user from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{

    $user = User::find($id);

    if( is_null($user) )
      App::abort(404, 'Specified user not found.');

    // Make sure this isn't the primary administrator account or the current logged in user.
    if( $user->id != 1 && $user->id != Auth::user()->id ) {
      $user->delete();

      $action_success = is_null( User::find($id) );

      Session::flash('action_success', $action_success);
      Session::flash('action_message', $action_success ? 'User deleted successfully.' : 'Unable to delete user for some unknown reason. Try again later?');
    } else {
      Session::flash('action_success', false);
      Session::flash('action_message', $user->id == 1 ? 'You cannot delete the primary administrator account.' : 'You cannot delete yourself.');
    }

    return Redirect::action('AdminUserController@index');

	}

}
