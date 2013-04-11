<?php

class ScheduleController extends BaseController {

  public function __construct()
  {

    $this->beforeFilter('csrf', array('on' => 'post'));
    $this->beforeFilter('auth');
    $this->beforeFilter('setSchoolSession');

    Session::flash('allSchoolSessions', SchoolSession::all());

  }

  public function getIndex()
  {

    $schedules = Auth::user()->schedules()->with('scheduleTimeslots')->get();

    return View::make('schedule.index')
      ->with('schedules', $schedules);

  }

  public function getCreate()
  {

    $allCourses = Course::all();
    $schedSelectedCourses = Session::get('schedSelectedCourses', array());
    $selectedCourses = array();

    foreach( $schedSelectedCourses as $course_id )
      $selectedCourses[] = Course::find($course_id);

    return View::make('schedule.generate')
      ->with('allCourses', $allCourses)
      ->with('selectedCourses', $selectedCourses);

  }

  public function postCreate()
  {

    Session::forget('schedSelectedCourses');
    return "hello";
  }

  public function postCourse()
  {

    $course = Course::find( Input::get('course') );

    if( is_null($course) ) {
      Session::flash('action_success', false);
      Session::flash('action_message', 'The specified course does not exist.');
      return Redirect::action('ScheduleController@getCreate')->withInput();
    }

    $schedSelectedCourses = Session::get('schedSelectedCourses', array());

    if( ! in_array( $course->id, $schedSelectedCourses ) )
      $schedSelectedCourses[] = $course->id;

    Session::put('schedSelectedCourses', $schedSelectedCourses);

    return Redirect::action('ScheduleController@getCreate');

  }

  public function deleteCourse()
  {

    if( ! Input::has('course_id') ) {
      Session::flash('action_success', false);
      Session::flash('action_message', 'There was no course specified for removal.');
      return Redirect::action('ScheduleController@getCreate')->withInput();
    }

    $schedSelectedCourses = Session::get('schedSelectedCourses', array());

    if( in_array(Input::get('course_id'), $schedSelectedCourses) ) {
      $pos = array_search( Input::get('course_id'), $schedSelectedCourses );
      array_splice( $schedSelectedCourses, $pos, 1 );
      Session::put('schedSelectedCourses', $schedSelectedCourses);
    }

    return Redirect::action('ScheduleController@getCreate');

  }

}
