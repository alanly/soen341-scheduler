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

    $courseList = Session::get('schedGenCourses', array());

    $courses = array();

    foreach($courseList as $id)
      $courses[] = Course::find($id);

    return View::make('schedule.generate')->with('allCourses', $allCourses)->with('courses', $courses);

  }

  public function postCreate()
  {

    if( ! Input::has('data') ) {
      Session::flash('action_success', false);
      Session::flash('action_message', 'The dataset attribute was not specified. Unable to continue with the request.');
      return Redirect::action('ScheduleController@getCreate')->withInput();
    }

    switch( Input::get('data') ) {
    case 'courses':
      return $this->createCoursesHandler();
    case 'generate':
      return $this->createGenerateHandler();
    default:
      Session::flash('action_success', false);
      Session::flash('action_message', 'An invalid dataset attribute was specified. Unable to continue with the reqeust.');
      return Redirect::action('ScheduleController@getCreate')->withInput();
    }

  }

  private function createCoursesHandler()
  {

    $course = Course::find( Input::get('courses') );

    if( is_null($course) ) {
      Session::flash('action_success', false);
      Session::flash('action_message', 'The course specified does not exist.');
      return Redirect::action('ScheduleController@getCreate')->withInput();
    }

    $courseList = Session::has('schedGenCourses') ? Session::get('schedGenCourses') : array();

    if( ! in_array( $course->id, $courseList ) )
      $courseList[] = $course->id;

    Session::put('schedGenCourses', $courseList);

    return Redirect::action('ScheduleController@getCreate')->withInput();

  }

  private function createGenerateHandler()
  {

    Session::forget('schedGenCourses');
    Session::flash('action_success', true);
    Session::flash('action_message', 'Schedules generated.');

  }

}
