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
      ->with('selectedCourses' $selectedCourses);

  }

  public function postCourse()
  {

    if( ! Input::has('course') ) {

    }

  }

}
