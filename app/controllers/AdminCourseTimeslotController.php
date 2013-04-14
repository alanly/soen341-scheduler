<?php

class AdminCourseTimeslotController extends BaseController {

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
  {

    if( ! Input::has('course_id') ) {
      Session::flash('action_success', false);
      Session::flash('action_message', 'The associated course was not specified in the request.');
      return Redirect::action('AdminCourseController@index');
    }

    Session::flash('edit_pane', 'timeslots');

    $rules = array(
      'section' => 'required|exists:course_sections,id',
      'type' => 'required|in:LECTURE,TUTORIAL,LAB',
      'code' => 'required',
      'dateCheckbox' => 'required',
      'startTime' => 'required|date_format:"H:i"',
      'endTime' => 'required|date_format:"H:i"',
      'location' => 'required',
      'instructor' => 'required'
    );

    $validator = Validator::make(Input::all(), $rules);

    if( $validator->fails() ) {
      Session::flash('action_success', false);
      Session::flash('action_message', 'There was an error in your create form. Please fix it and try again.');
      return Redirect::action('AdminCourseController@edit', array( Input::get('course_id') ))->withErrors($validator)->withInput();
    }

    // Make sure the date values are appropriate
    foreach( Input::get('dateCheckbox') as $date ) {
      if( $date < 0 || $date > 6 ) {
        Session::flash('action_success', false);
        Session::flash('action_message', 'The date selection(s) is invalid.');
        return Redirect::action('AdminCourseController@edit', array( Input::get('course_id') ))->withInput();
      }
    }

    // Make sure the start and end time are appropriate
    if( strtotime( Input::get('startTime') ) >= strtotime( Input::get('endTime') ) ) {
      Session::flash('action_success', false);
      Session::flash('action_message', 'The start time must occur <strong>before</strong> the end time.');
      return Redirect::action('AdminCourseController@edit', array( Input::get('course_id') ))->withInput();
    }

    foreach( Input::get('dateCheckbox') as $date ) {
      $timeslot = CourseTimeslot::create(array(
        'section_id' => Input::get('section'),
        'course_id' => Input::get('course_id'),
        'type' => Input::get('type'),
        'code' => Input::get('code'),
        'day' => $date,
        'start_time' => Input::get('startTime'),
        'end_time' => Input::get('endTime'),
        'location' => Input::get('location'),
        'instructor' => Input::get('instructor')
      ));

      if( $timeslot === false ) {
        Session::flash('action_success', false);
        Session::flash('action_message', 'An internal error was encountered while creating the timeslot. Try again later?');
        return Redirect::action('AdminCourseController@edit', array( Input::get('course_id') ))->withInput();
      }
    }

    Session::flash('action_success', true);
    Session::flash('action_message', 'The timeslot was successfully created.');
    return Redirect::action('AdminCourseController@edit', array( Input::get('course_id') ));

	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{

    $timeslot = CourseTimeslot::with('course', 'courseSection')->find($id);

    if( is_null($timeslot) ) {
      Session::flash('action_success', false);
      Session::flash('action_message', 'The specified course timeslot does not exist.');
      return Redirect::action('AdminCourseController@index');
    }

    $course = $timeslot->course()->with('courseSections')->first();
    $section = $timeslot->courseSection()->first();

    // Make sure this timeslot and the current session matches
    if( $section->session_id != Session::get('schoolSession') ) {
      Session::flash('action_success', false);
      Session::flash('action_message', 'The specified course timeslot does not exist in the currently selected school session.');
      return Redirect::action('AdminCourseController@index');
    }

    $allSections = $course->courseSections()->where('session_id', Session::get('schoolSession'))->get();

    return View::make('admin.course.edit_timeslot')
      ->with('timeslot', $timeslot)
      ->with('course', $course)
      ->with('section', $section)
      ->with('allSections', $allSections);

	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{

    $timeslot = CourseTimeslot::with('course', 'courseSection')->find($id);

    if( is_null($timeslot) ) {
      Session::flash('action_success', false);
      Session::flash('action_message', 'The specified course timeslot does not exist.');
      return Redirect::action('AdminCourseController@index');
    }

    $section = $timeslot->courseSection()->first();

    if( $section->session_id != Session::get('schoolSession') ) {
      Session::flash('action_success', false);
      Session::flash('action_message', 'The specified course timeslot does not exist in the currently selected school session.');
      return Redirect::action('AdminCourseController@index');
    }

    $rules = array(
      'section' => 'required|exists:course_sections,id',
      'type' => 'required|in:LECTURE,TUTORIAL,LAB',
      'code' => 'required',
      'date' => 'required|between:0,6',
      'startTime' => 'required|date_format:"H:i"',
      'endTime' => 'required|date_format:"H:i"',
      'location' => 'required',
      'instructor' => 'required'
    );

    $validator = Validator::make( Input::all(), $rules );

    if( $validator->fails() ) {
      Session::flash('action_success', false);
      Session::flash('action_message', 'There is an error in your form. Please correct it and try again.');
      return Redirect::action('AdminCourseTimeslotController@edit', array( $timeslot->id ))->withErrors($validator)->withInput();
    }

    $timeslot->section_id = Input::get('section');
    $timeslot->type = Input::get('type');
    $timeslot->code = Input::get('code');
    $timeslot->day = Input::get('date');
    $timeslot->start_time = Input::get('startTime');
    $timeslot->end_time = Input::get('endTime');
    $timeslot->location = Input::get('location');
    $timeslot->instructor = Input::get('instructor');

    $action_success = $timeslot->save();

    Session::flash('action_success', $action_success);
    Session::flash('action_message', $action_success ? 'The course timeslot was successfully updated.' : 'Unable to update course timeslot due to an internal error. Try again later?');
    Session::flash('edit_pane', 'timeslots');

    if( $action_success )
      return Redirect::action('AdminCourseController@edit', array( $timeslot->course()->first()->id ));
    else
      return Redirect::action('AdminCourseTimeslotController@edit', array( $timeslot->id ))->withInput();

	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{

    $timeslot = CourseTimeslot::with('course','courseSection')->find($id);

    if( is_null($timeslot) ) {
      Session::flash('action_success', false);
      Session::flash('action_message', 'The requested course timeslot does not exist.');
      return Redirect::action('AdminCourseController@index');
    }

    $course = $timeslot->course()->first();
    $section = $timeslot->courseSection()->first();

    if( $section->session_id != Session::get('schoolSession') ) {
      Session::flash('action_success', false);
      Session::flash('action_message', 'The requested course timeslot does not exist under the currently selected school session.');
      return Redirect::action('AdminCourseController@index');
    }

    $timeslot->delete();

    $action_success = is_null(CourseTimeslot::find($id));

    Session::flash('action_success', $action_success);
    Session::flash('action_message', $action_success ? 'The course timeslot was removed successfully.' : 'Unable to remove the course timeslot due to an internal error. Try again later?');

    Session::flash('edit_pane', 'timeslots');

    return Redirect::action('AdminCourseController@edit', array($course->id));

	}

}
