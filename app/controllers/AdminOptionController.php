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

    $programs = Program::all();

    return View::make('admin.option.create')->with('programs', $programs);

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
      Session::flash('program_id', Input::get('program_id'));
      return Redirect::action('AdminOptionController@create');
    }

    $rules = array(
      'description' => 'required',
      'program' => 'required|exists:programs,id'
    );

    $validator = Validator::make(Input::all(), $rules);

    if( $validator->fails() ) {
      Session::flash('action_success', false);
      Session::flash('action_message', 'There is an error in your form. Please correct it and try again.');
      return Redirect::action('AdminOptionController@create')->withErrors($validator)->withInput();
    }

    // Make sure the option description doesn't already exist.
    if( ProgramOption::where('description', 'like', Input::get('description'))->count() > 0 ) {
      Session::flash('action_success', false);
      Session::flash('action_message', 'There already exists an option under this program with the same description.');
      return Redirect::action('AdminOptionController@create')->withInput();
    }

    $option = ProgramOption::create(array(
      'description' => Input::get('description'),
      'program_id' => Input::get('program')
    ));

    $action_success = $option != false;

    Session::flash('action_success', $action_success);
    Session::flash('action_message', $action_success ? 'The program option was successfully created.' : 'Unable to create the program option due to an internal error. Try again later?');

    if( $action_success )
      return Redirect::action('AdminOptionController@show', array($option->id));
    else
      return Redirect::action('AdminOptionController@create')->withInput();

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

    $option = ProgramOption::find($id);

    if( is_null($option) ) {
      Session::flash('action_success', false);
      Session::flash('action_message', 'The specified program option does not exist.');
      return Redirect::action('AdminOptionController@index');
    }

    if( $option->description == 'None' ) {
      Session::flash('action_success', false);
      Session::flash('action_message', 'You cannot modify the default program option.');
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

    $option = ProgramOption::find($id);

    if( is_null($option) ) {
      Session::flash('action_success', false);
      Session::flash('action_message', 'The specified program option does not exist.');
      return Redirect::action('AdminOptionController@index');
    }

    if( $option->description == 'None' ) {
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
      return $this->updateOption($option);
    case 'courses': 
      return $this->updateCourses($option);
    default: 
      Session::flash('action_success', false);
      Session::flash('action_message', 'Invalid dataset specified for update operation.');
      return Redirect::action('AdminOptionController@edit', array($id));
    }

  }

  protected function updateOption($option)
  {

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
      return Redirect::action('AdminOptionController@edit', array($option->id))->withErrors($validator)->withInput();
    }

    $option->description = Input::get('description');
    $option->program_id = Input::get('program');

    $action_success = $option->save();

    Session::flash('action_success', $action_success);
    Session::flash('action_message', $action_success ? 'Program option updated successfully.' : 'Unable to update program option due to internal error. Try again later?');

    return Redirect::action('AdminOptionController@edit', array($option->id));

  }

  protected function updateCourses($option)
  {

    $validator = Validator::make(
      Input::all(),
      array(
        'course' => 'required|exists:courses,id'
      )
    );

    if( $validator->fails() ) {
      Session::flash('action_success', false);
      Session::flash('action_message', 'There is an error in the form entry. Please correct the issue and try again.');
      return Redirect::action('AdminOptionController@edit', array($option->id))->withErrors($validator)->withInput();
    }

    // Make sure this course isn't already contained under the option.
    if( $option->programOptionCourses()->where('course_id', Input::get('course'))->count() > 0 ) {
      Session::flash('action_success', false);
      Session::flash('action_message', 'The specified course already exists under this program option.');
      return Redirect::action('AdminOptionController@edit', array($option->id))->withInput();
    }

    $optionCourse = ProgramOptionCourse::create(array(
      'program_option_id' => $option->id,
      'course_id' => Input::get('course')
    ));

    $action_success = $optionCourse != false;

    Session::flash('action_success', $action_success);
    Session::flash('action_message', $action_success ? 'Course added to program option successfully.' : 'Unable to add course to program option due to internal error. Try again later?');

    return Redirect::action('AdminOptionController@edit', array($option->id));

  }

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{

    $option = ProgramOption::find($id);

    if( is_null($option) ) {
      Session::flash('action_success', false);
      Session::flash('action_message', 'The specified program option does not exist.');
      return Redirect::action('AdminOptionController@index');
    }

    if( $option->description == 'None' ) {
      Session::flash('action_success', false);
      Session::flash('action_message', 'You cannot delete the default program option.');
      return Redirect::action('AdminOptionController@index');
    }

    // Determine which destroy request we're processing: ProgramOption or ProgramOptionCourse,
    // based upon the data attribute input field.

    if( ! Input::has('data') ) {
      Session::flash('action_success', false);
      Session::flash('action_message', 'The dataset field must be specified before a delete request can be processed.');
      return Redirect::action('AdminOptionController@show', array($id));
    }

    switch( Input::get('data') ) {
    case 'option':
      return $this->destroyOption($option);
    case 'course':
      return $this->destroyOptionCourse($option);
    default:
      Session::flash('action_success', false);
      Session::flash('action_message', 'Invalid dataset value for destroy operation.');
      return Redirect::action('AdminOptionController@show', array($id));
    }

  }

  public function destroyOption($option)
  {

    // Retrieve all associated data objects for this option
    $id = $option->id;
    $program = $option->program()->first();
    $optionCourses = $option->programOptionCourses(); // Retrieve all the associated ProgramOptionCourse
    $optionUsers = $option->users(); // Retrieve all the associated User

    // Remove all related ProgramOptionCourse
    $optionCourses->delete();

    $areCourseDeleted = ProgramOptionCourse::where('option_id', $option->id)->count() == 0 ? true : false;

    // Remove the ProgramOption
    $option->delete();

    $isOptionDeleted = is_null( ProgramOption::find($id) );
    
    // Update on all associated users; switch their option selection to the first value under the program.
    $optionUsers->update(array(
      'option_id' => $program->programOptions()->first()->id
    ));

    $action_success = $areCourseDeleted && $isOptionDeleted;

    Session::flash('action_success', $action_success);
    Session::flash('action_message', $action_success ? 'The program option was successfully deleted.' : 'Unable to delete the program option due to an internal error. Try again later?');

    return Redirect::action('AdminOptionController@index');
  
  }

  public function destroyOptionCourse($option)
  {

    // Make sure that the course_id was provided in the request.
    if( ! Input::has('course_id') ) {
      Session::flash('action_success', false);
      Session::flash('action_message', 'Unable to process the destroy request because there was no course specified.');
      return Redirect::action('AdminOptionController@show', array($option->id));
    }

    // Retrieve the associated data for this request
    $courseId = Input::get('course_id');
    $optionCourse = $option->programCourseOption()->where('course_id', $courseId)->first();

    // Remove the option course
    $optionCourse->delete();

    $action_success = $option->programCourseOption()->where('course_id', $courseId)->count() == 0;

    Session::flash('action_success', $action_success);
    Session::flash('action_message', $action_success ? 'The course was successfully removed from the program option.' : 'Unable to remove the course from the program option due to an internal error. Try again later?');

    return Redirect::action('AdminOptionController@show', array($option->id));

  }

}
