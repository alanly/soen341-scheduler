<?php

class AdminOptionController extends BaseController {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{

    $programs = Program::all();
    $optionCount = ProgramOption::all()->count();

    return View::make('admin.option.index')->with('programs', $programs)->with('optionCount', $optionCount);

	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{


	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{

    // Check if we've been redirected from the program view to create a new option.
    if( Input::has('program_id') ) {
      return Redirect::action('AdminOptionController@create')->with('program_id', Input::get('program_id'));
    }

	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
	  
    $option = ProgramOption::find($id);

    if( is_null($option) ) {
      Session::flash('action_success', false);
      Session::flash('action_message', 'The specified program option does not exist.');
      return Redirect::action('AdminOptionController@index');
    }

    return View::make('admin.option.show')->with('option', $option);

	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{

    // Make sure we're not editing the default 'None' program option.
    if( $id == 1 ) {
      Session::flash('action_success', false);
      Session::flash('action_message', 'You cannot modify the default program option.');
      return Redirect::action('AdminOptionController@index');
    }

    $option = ProgramOption::find($id);

    if( is_null($option) ) {
      Session::flash('action_success', false);
      Session::flash('action_message', 'The specified program option does not exist.');
      return Redirect::action('AdminOptionController@index');
    }

    $optionCourses = $option->programOptionCourses()->get();

    $allPrograms = Program::all();
    $allCourses = Course::all();

    return View::make('admin.option.edit')
      ->with('option', $option)
      ->with('optionCourses', $optionCourses)
      ->with('allPrograms', $allPrograms)
      ->with('allCourses', $allCourses);

	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{

    // Make sure we're not editing the default 'None' program option.
    if( $id == 1 ) {
      Session::flash('action_success', false);
      Session::flash('action_message', 'You cannot modify the default program option.');
      return Redirect::action('AdminOptionController@index');
    }

    /*
     * We have to check for a `data` attribute which will let us determine which
     * dataset we're going to update (ProgramOption or ProgramOptionCourse).
     * We will then call on the appropriate methods to perform the operation.
     */

    if( ! Input::has('data') ) {
      Session::flash('action_success', false);
      Session::flash('action_message', 'You must specify which dataset you are attempting to update.');
      return Redirect::action('AdminOptionController@edit', array($id));
    }

    Session::flash('edit_pane', Input::get('data')); // Store which tab pane we're working with.

    switch( Input::get('data') ) {
    case 'option': 
      return $this->updateOption($id);
    case 'courses': 
      return $this->updateCourses($id);
    default: 
      Session::flash('action_success', false);
      Session::flash('action_message', 'Invalid dataset specified for update operation.');
      return Redirect::action('AdminOptionController@edit', array($id));
    }

  }

  protected function updateOption($id)
  {

    $option = ProgramOption::find($id);

    if( is_null($option) ) {
      Session::flash('action_success', false);
      Session::flash('action_message', 'The specified program option does not exist.');
      return Redirect::action('AdminOptionController@index');
    }

    $rules = array(
      'description' => 'required',
      'program' => 'required|exists:programs,id'
    );

    $validator = Validator::make(
      Input::all(),
      $rules
    );

    if( $validator->fails() ) {
      Session::flash('action_success', false);
      Session::flash('action_message', 'There is an error in the form entry. Please correct the issue and try again.');
      return Redirect::action('AdminOptionController@edit', array($id))->withErrors($validator)->withInput();
    }

    $option->description = Input::get('description');
    $option->program_id = Input::get('program');

    $action_success = $option->save();

    Session::flash('action_success', $action_success);
    Session::flash('action_message', $action_success ? 'Program option updated successfully.' : 'Unable to update program option due to internal error. Try again later?');

    return Redirect::action('AdminOptionController@edit', array($id));

  }

  protected function updateCourses($id)
  {

    $option = ProgramOption::find($id);

    if( is_null($option) ) {
      Session::flash('action_success', false);
      Session::flash('action_message', 'The specified program option does not exist.');
      return Redirect::action('AdminOptionController@index');
    }

    $validator = Validator::make(
      Input::all(),
      array(
        'course' => 'required|exists:courses,id'
      )
    );

    if( $validator->fails() ) {
      Session::flash('action_success', false);
      Session::flash('action_message', 'There is an error in the form entry. Please correct the issue and try again.');
      return Redirect::action('AdminOptionController@edit', array($id))->withErrors($validator)->withInput();
    }

    $optionCourse = new ProgramOptionCourse;
    $optionCourse->program_option_id = $option->id;
    $optionCourse->course_id = Input::get('course');

    $action_success = $optionCourse->save();

    Session::flash('action_success', $action_success);
    Session::flash('action_message', $action_success ? 'Course added to program option successfully.' : 'Unable to add course to program option due to internal error. Try again later?');

    return Redirect::action('AdminOptionController@edit', array($id));

  }

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{

    // Make sure we're not deleting the default 'None' program option.
    if( $id == 1 ) {
      Session::flash('action_success', false);
      Session::flash('action_message', 'You cannot delete the default program option.');
      return Redirect::action('AdminOptionController@index');
    }

	}

}
