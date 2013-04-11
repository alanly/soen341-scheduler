<?php

class AdminCourseController extends BaseController {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
  {

    $courses = Course::with('courseSections')->paginate( Session::get('pageLength', 10) );

    return View::make('admin.course.index')->with('courses', $courses);

	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{

    return View::make('admin.course.create');

	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{

    $rules = array(
      'code' => 'required|min:7',
      'description' => 'required'
    );

    $validator = Validator::make( Input::all(), $rules );

    if( $validator->fails() ) {
      Session::flash('action_success', false);
      Session::flash('action_message', 'There is an issue with your form. Please correct it and try again.');
      return Redirect::action('AdminCourseController@create')->withErrors($validator)->withInput();
    }

    if( Course::where('code', 'like', Input::get('code'))->count() > 0 ) { // Check for existing course with similar code
      Session::flash('action_success', false);
      Session::flash('action_message', 'There is an existing course with the same course code in the database.');
      return Redirect::action('AdminCourseController@create')->withInput();
    }

    $course = Course::create(array(
      'code' => Input::get('code'),
      'description' => Input::get('description')
    ));

    $action_success = $course != false;;

    Session::flash('action_success', $action_success);
    Session::flash('action_message', $action_success ? 'Course "' . Input::get('code') . '" was created successfully.' : 'Unable to create course due to an internal error. Try again later?');

    if($action_success)
      return Redirect::action('AdminCourseController@edit', array($course->id));
    else
      return Redirect::action('AdminCourseController@create')->withInput();

	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
	  
    $course = Course::find($id);

    if( is_null($course) ) {
      Session::flash('action_success', false);
      Session::flash('action_message', 'The course specified does not exist.');
      return Redirect::action('AdminCourseController@index');
    }

    $allSessions = SchoolSession::all();
    $currentSession = SchoolSession::find( Session::get('schoolSession') );
    $courseSections = $course->courseSections()->with('courseTimeslots')->where('session_id', $currentSession->id)->get();

    return View::make('admin.course.show')
      ->with('course', $course)
      ->with('allSessions', $allSessions)
      ->with('currentSession', $currentSession)
      ->with('courseSections', $courseSections);

	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{

    $course = Course::with('courseSections.courseTimeslots')->where('id', $id)->first();

    if( is_null($course) ) {
      Session::flash('action_success', false);
      Session::flash('action_message', 'The course specified does not exist.');
      return Redirect::action('AdminCourseController@index');
    }

    $sections = $course->courseSections()->where('session_id', Session::get('schoolSession'))->get();

    $allSessions = SchoolSession::all();
    $currentSession = SchoolSession::find( Session::get('schoolSession') );

    if( ! Session::has('edit_pane') )
      Session::flash('edit_pane', Input::has('edit_pane') ? Input::get('tab_pane') : 'course');

    return View::make('admin.course.edit')
      ->with('course', $course)
      ->with('sections', $sections)
      ->with('allSessions', $allSessions)
      ->with('currentSession', $currentSession);

	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		//
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		//
	}

}
