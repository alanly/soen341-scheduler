<?php

class AdminProgramController extends BaseController {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
  {

    $programs = Program::all();

    return View::make('admin.program.index')->with('programs', $programs);

	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{

    return View::make('admin.program.create');

	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{

    $validator = Validator::make(
      Input::all(),
      array(
        'description' => 'required'
      )
    );

    if( $validator->fails() ) {
      Session::flash('action_success', false);
      Session::flash('action_message', 'There is an error with your form. Please correct it and try again.');
      return Redirect::action('AdminProgramController@create')->withErrors($validator)->withInput();
    }

    $program = Program::create(array(
      'description' => Input::get('description')
    ));

    $program->programOptions()->save(
      new ProgramOption(array(
        'description' => 'None'
      ))
    );

    return Redirect::action('AdminProgramController@show', array($program->id));

	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{

    $program = Program::find($id);

    if( is_null($program) ) {
      Session::flash('action_success', false);
      Session::flash('action_message', 'The specified program could not be found.');

      return Redirect::action('AdminProgramController@index');
    }

    $programOptions = $program->programOptions()->get();

    return View::make('admin.program.show')->with('program', $program)->with('programOptions', $programOptions);

  }

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{

    // Make sure we're not the trying to edit the default program.
    if( $id == 1 ) {
      Session::flash('action_success', false);
      Session::flash('action_message', 'You cannot modify the default program.');
      return Redirect::action('AdminProgramController@index');
    }

    $program = Program::find($id);

    if( is_null($program) ) {
      Session::flash('action_success', false);
      Session::flash('action_message', 'The specified program could not be fond.');

      return Redirect::action('AdminProgramController@index');
    }

    $programOptions = $program->programOptions()->get();

    return View::make('admin.program.edit')->with('program', $program)->with('programOptions', $programOptions);

	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
  {

    // Make sure we're not updating the default program.
    if( $id == 1 ) {
      Session::flash('action_success', false);
      Session::flash('action_message', 'You cannot modify the default program.');
      return Redirect::action('AdminProgramController@index');
    }

    $program = Program::find($id);

    if( is_null($program) ) {
      Session::flash('action_success', false);
      Session::flash('action_message', 'The specified program could not be found.');

      return Redirect::action('AdminProgramController@index');
    }

    $validator = Validator::make(
      Input::all(),
      array(
        'description' => 'required'
      )
    );

    if( $validator->fails() ) {
      Session::flash('action_success', false);
      Session::flash('action_message', 'There is an error in your form. Please correct it and try again.');

      return Redirect::action('AdminProgramController@edit', array($id))->withErrors($validator)->withInput();
    }

    $program->description = Input::get('description');
    $action_success = $program->save();
    
    Session::flash('action_success', $action_success);
    Session::flash('action_message', $action_success ? 'Program updated successfully.' : 'Unable to update program due to an internal error. Try again later?');

    return Redirect::action('AdminProgramController@show', array($id));

	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{

    // Make sure we aren't deleting the "None" program.
    if( $id == 1 ) {
      Session::flash('action_success', false);
      Session::flash('action_message', 'You cannot delete the default program.');
      return Redirect::action('AdminProgramController@index');
    }

    $program = Program::find($id);

    if( is_null($program) ) {
      Session::flash('action_success', false);
      Session::flash('action_message', 'The specified program could not be found.');

      return Redirect::action('AdminProgramController@index');
    }

    // Delete program option courses
    foreach( $program->programOptions() as $o ) {
      $o->programOptionCourses()->delete();
    }

    $program->programOptions()->delete(); // Delete associated program options.

    $program->delete(); // Delete the program.

    $programUsers = User::where('program_id', $id); // Update users for the specified program to the default "None" program and option.
    $programUsers->update(array(
      'program_id' => 1,
      'option_id' => 1
    ));

    $action_success = is_null(Program::find($id)) && ProgramOption::where('program_id', $id)->count() == 0;

    Session::flash('action_success', $action_success);
    Session::flash('action_message', $action_success ? 'Program deleted successfully.' : 'Unable to delete the program properly due to an internal error. Try again later?');

    return Redirect::action('AdminProgramController@index');

	}

}
