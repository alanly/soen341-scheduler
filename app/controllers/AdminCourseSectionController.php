<?php

class AdminCourseSectionController extends BaseController {

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{

    // Make sure we have the pre-requisite items
    if( ! (Input::has('course_id') && Session::has('schoolSession')) ) {
      Session::flash('action_success', false);

      $action_message = 'There was an error in your form: ' 
        . (Input::has('course_id') ? '' : '<br>The course for the defined section was not specified.') 
        . (Session::has('schoolSession') ? '' : '<br>The session for he defined section was not specified.');
      
      Session::flash('action_message', $action_message);

      Session::flash('edit_pane', 'sections');

      if( Input::has('course_id') )
        return Redirect::action('AdminCourseController@edit', array( Input::get('course_id') ))->withInput();
      else
        return Redirect::action('AdminCourseController@index');
    }

    $course = Course::find( Input::get('course_id') );

    if( is_null($course) ) {
      Session::flash('action_success', false);
      Session::flash('action_message', 'The associated course does not exist.');
      return Redirect::action('AdminCourseController@index');
    }

    $schoolSession = SchoolSession::find( Session::get('schoolSession') );

    if( is_null($schoolSession) ) {
      Session::flash('action_success', false);
      Session::flash('action_message', 'The associated school session does not exist.');
      return Redirect::action('AdminCourseController@edit', array($course->id))->withInput();
    }

    $validator = Validator::make(
      array('code' => Input::get('code')),
      array('code' => 'required')
    );

    if( $validator->fails() ) {
      Session::flash('action_success', false);
      Session::flash('action_message', 'There is an error in your form. Please correct it and try again.');
      return Redirect::action('AdminCourseController@edit', array( Input::get('course_id') ))->withErrors($validator)->withInput();
    }

    $courseSection = CourseSection::create(array(
      'code' => Input::get('code'),
      'session_id' => $schoolSession->id,
      'course_id' => $course->id
    ));

    $action_success = !( $courseSection === false );

    Session::flash('edit_pane', 'sections');
    Session::flash('action_success', $action_success);
    Session::flash('action_message', $action_success ? 'Course section "' . Input::get('code') . '" added successfully.' : 'Unable to add course section due to an internal error. Try again later?');

    if($action_success)
      return Redirect::action('AdminCourseController@edit', array( Input::get('course_id') ));
    else
      return Redirect::action('AdminCourseController@edit', array( Input::get('course_id') ))->withInput();

	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		//
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		//
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

    $courseSection = CourseSection::find($id);

    if( is_null($courseSection) ) {
      Session::flash('action_success', false);
      Session::flash('action_message', 'The requested course section does not exist.');
      return Redirect::action('AdminCourseController@index');
    }

    // Store the course ID
    $course_id = $courseSection->course_id;

    // Delete the course timeslots
    $courseSection->courseTimeslots()->delete();
    $timeslotsDeleted = !($courseSection->courseTimeslots()->count() > 0);

    // Delete the course section
    $courseSection->delete();
    $sectionDeleted = is_null(CourseSection::find($id));

    $action_success = $timeslotsDeleted && $sectionDeleted;

    Session::flash('edit_pane', 'sections');
    Session::flash('action_success', $action_success);
    Session::flash('action_message', $action_success ? 'The course section and its associated timeslots have been deleted.' : 'Unable to delete the course section and/or its associated timeslots due to an internal error. Try again later?');

    return Redirect::action('AdminCourseController@edit', array($course_id));

	}

}
