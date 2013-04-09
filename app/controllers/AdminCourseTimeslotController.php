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
      Session::flash('edit_pane', 'timeslots');
      return Redirect::action('AdminCourseController@edit', array( Input::get('course_id') ))->withErrors($validator)->withInput();
    }

    // Make sure the date values are appropriate
    foreach( Input::get('dateCheckbox') as $date ) {
      if( $date < 0 || $date > 6 ) {
        Session::flash('action_success', false);
        Session::flash('action_message', 'The date selection(s) is invalid.');
        Session::flash('edit_pane', 'timeslots');
        return Redirect::action('AdminCourseController@edit', array( Input::get('course_id') ))->withInput();
      }
    }

    // Make sure the start and end time are appropriate
    if( strtotime( Input::get('startTime') ) >= strtotime( Input::get('endTime') ) ) {
      Session::flash('action_success', false);
      Session::flash('action_message', 'The start time must occur <strong>before</strong> the end time.');
      Session::flash('edit_pane', 'timeslots');
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
		//
	}

}
