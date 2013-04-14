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

    $schedules = Auth::user()->schedules()->with('scheduleTimeslots')->orderBy('id', 'desc')->get();

    return View::make('schedule.index')
      ->with('schedules', $schedules);

  }

  public function deleteDelete($id)
  {

    $schedule = Auth::user()->schedules()->with('scheduleTimeslots')->find($id);

    if( is_null($schedule) ) {
      Session::flash('action_success', false);
      Session::flash('action_message', 'The specified schedule does not exist.');
      return Redirect::action('ScheduleController@getIndex');
    }

    $action_success = false;

    $scheduleTimeslots = $schedule->scheduleTimeslots();

    // Remove timeslots
    $scheduleTimeslots->delete();

    if( ScheduleTimeslot::where('schedule_id', $id)->count() == 0 )
      $action_success = true;

    // Remove schedule
    if( $action_success ) {
      $schedule->delete();

      $action_success = is_null(Schedule::find($id));
    }

    Session::flash('action_success', $action_success);
    Session::flash('action_message', $action_success ? 'Schedule deleted successfully.' : 'Unable to delete schedule due to internal error. Try again later?');
    return Redirect::action('ScheduleController@getIndex');

  }

  public function getView($id)
  {

    $schedule = Auth::user()->schedules()->find($id);

    if( is_null($schedule) ) {
      Session::flash('action_success', false);
      Session::flash('action_message', 'The specified schedule does not exist.');
      return Redirect::action('ScheduleController@getIndex');
    }

    $timeslot_ids = DB::table("schedule_timeslots")->where("schedule_id", $id)->get();
  $days = array(
      0 => array(),
      1 => array(),
      2 => array(),
      3 => array(),
      4 => array(),
      5 => array(),
      6 => array()
    );
    $earliest = "24:00";
    $latest = "0:00";
    // Generate the calendar
    foreach( $timeslot_ids as $time_id ) {
	$slot = CourseTimeslot::find($time_id->course_timeslot_id);
      // Determine the epoch time equivalents.
      $slotStart = strtotime($slot->start_time);
      $slotEnd = strtotime($slot->end_time);

      // Determine the earliest and latest time in the calendar.
      if( $slotStart < strtotime($earliest) )
        $earliest = $slot->start_time;

      if( $slotEnd > strtotime($latest) )
        $latest = $slot->end_time;

      // Add to appropriate `day` if the timeslot doesn't overlap/conflict with anything existing.
      if( ! $this->doesTimeslotOverlap( $days[$slot->day], $slot ) )
        $days[$slot->day][$slot->start_time] = $slot;

    }
   

    return View::make('schedule.display')
      ->with('schedule', $schedule)
      ->with('days', $days)
      ->with('earliest', $earliest)
      ->with('latest', $latest);

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

    $rules = array(
      'times' => 'required',
      'dates' => 'required'
    );

    $validator = Validator::make( Input::all(), $rules );

    if( $validator->fails() ) {
      Session::flash('action_success', false);
      Session::flash('action_message', 'There is an issue with your form. You must select at least one time and date preference.');
      return Redirect::action('ScheduleController@getCreate')->withErrors($validator)->withInput();
    }

    /*
     * Retrieve course that have been selected (should be in the session in the form of course ids).
     */

    $courseSelectedById = Session::get('schedSelectedCourses', array());

    if( count($courseSelectedById) == 0 ) {
      Session::flash('action_success', false);
      Session::flash('action_message', 'You have not selected any courses yet.');
      return Redirect::action('ScheduleController@getCreate')->withInput();
    }

    /* 
     * Retrieve schedule time and date preferences from input.
     */

    $timePreferences = Input::get('times', array());
    $datePreferences = Input::get('dates', array());

    return $this->generateSchedule($courseSelectedById, $timePreferences, $datePreferences);

  }

  private function generateSchedule($courseID, $times, $dates)
  {

    // Compile all the timeslots of the courses.
    $timeslots = array();

    foreach( $courseID as $id ) {
      $sections = CourseSection::with('courseTimeslots')->where('course_id', $id)->where('session_id', Session::get('schoolSession'))->get();

      foreach( $sections as $section )
        foreach( $section->courseTimeslots as $slot )
          $timeslots[] = $slot;
    }

    // Compile all the time constraints into a boolean array
    $timeConstraints = array();

    for($i = 0; $i < 3; $i++) // Three possible choices (Morning, Afternoon, Evening)
      $timeConstraints[$i] = in_array($i, $times);

    // Compile all the date constraints into a boolean array
    $dateConstraints = array();

    for($i = 0; $i < 7; $i++) // Seven possible choices (for all seven days of the week)
      $dateConstraints[$i] = in_array($i, $dates);

    return $this->createCalendar($timeslots, $timeConstraints, $dateConstraints);

  }

  private function createCalendar($timeslots, $timeConstraints, $dateConstraints)
  {

    $days = array(
      0 => array(),
      1 => array(),
      2 => array(),
      3 => array(),
      4 => array(),
      5 => array(),
      6 => array()
    );

    // Create hard copy of array
    $filteredTimeslots = array();

    foreach( $timeslots as $k => $v )
      $filteredTimeslots[$k] = clone $v;

    // Check the Time Constraints

    foreach( $timeslots as $i => &$t ) {
      // Mornings Constraint
      if( $timeConstraints[0] == 0 )
        if( strtotime($t->end_time) <= strtotime('12:00') ) {
          $filteredTimeslots = $this->unsetTimeslotsBySection($filteredTimeslots, $t->section_id);
          continue;
        }

      // Afternoon Constraint
      if( $timeConstraints[1] == 0 )
        if( strtotime($t->start_time) >= strtotime('12:00') && strtotime($t->end_time) <= strtotime('17:00') ) {
          $filteredTimeslots = $this->unsetTimeslotsBySection($filteredTimeslots, $t->section_id);
          continue;
        }

      // Evening Constraint
      if( $timeConstraints[2] == 0 )
        if( strtotime($t->start_time) >= strtotime('17:00') )
          $filteredTimeslots = $this->unsetTimeslotsBySection($filteredTimeslots, $t->section_id);
    }

    // Check the Date Constraints
    
    foreach( $timeslots as $t )
      for($d = 0; $d < 7; $d++)
        if( $dateConstraints[$d] == 0 && $t->day == $d )
          $filteredTimeslots = $this->unsetTimeslotsBySection($filteredTimeslots, $t->section_id);

    $earliest = '24:00';
    $latest = '0:00';

    // Generate the calendar
    foreach( $filteredTimeslots as $slot ) {

      // Determine the epoch time equivalents.
      $slotStart = strtotime($slot->start_time);
      $slotEnd = strtotime($slot->end_time);

      // Determine the earliest and latest time in the calendar.
      if( $slotStart < strtotime($earliest) )
        $earliest = $slot->start_time;

      if( $slotEnd > strtotime($latest) )
        $latest = $slot->end_time;

      // Add to appropriate `day` if the timeslot doesn't overlap/conflict with anything existing.
      if( ! $this->doesTimeslotOverlap( $days[$slot->day], $slot ) )
        $days[$slot->day][$slot->start_time] = $slot;

    }

    $sessionTimeslots = array();

    foreach( $filteredTimeslots as $t )
      $sessionTimeslots[] = $t->id;

    Session::put('schedTimeslots', $sessionTimeslots);

    $schoolSession = SchoolSession::find( Session::get('schoolSession') );

    return View::make('schedule.preview')
      ->with('days', $days)
      ->with('earliest', $earliest)
      ->with('latest', $latest)
      ->with('currentSchoolSession', $schoolSession);

  }

  private function unsetTimeslotsBySection($timeslots, $sectionId)
  {

    foreach( $timeslots as $i => $slot )
      if( $slot->section_id == $sectionId )
        unset($timeslots[$i]);

    return $timeslots;

  }

  private function doesTimeslotOverlap($dayTimeslots, $timeslot)
  {

    foreach( $dayTimeslots as $entry ) {
      $entryStart = strtotime( $entry->start_time );
      $entryEnd = strtotime( $entry->end_time );
      $timeslotStart = strtotime( $timeslot->start_time );
      $timeslotEnd = strtotime( $timeslot->end_time );

      if( ($timeslotStart >= $entryStart && $timeslotStart <= $entryEnd) || ($entryStart >= $timeslotStart && $entryStart <= $timeslotEnd) )
        return true;
    }

    return false;

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
      unset( $schedSelectedCourses[$pos] );
      Session::put('schedSelectedCourses', $schedSelectedCourses);
    }

    return Redirect::action('ScheduleController@getCreate');

  }

  public function postSave()
  {

    $timeslots = Session::get('schedTimeslots');

    if( count($timeslots) == 0 ) {
      Session::flash('action_success', false);
      Session::flash('action_message', 'The schedule timeslots are missing.');
      return Redirect::back();
    }

    // Create the new Schedule
    $schedule = Schedule::create(array(
      'user_id' => Auth::user()->id
    ));

    // Create associated schedule timeslots
    foreach( $timeslots as $slot )
      $schedule->scheduleTimeslots()->save(new ScheduleTimeslot(
        array(
          'course_timeslot_id' => $slot
        )
      ));

    // Verify timeslots have been created
    $action_success = $schedule->scheduleTimeslots()->count() == count($timeslots);

    Session::flash('action_success', $action_success);
    Session::flash('action_message', $action_success ? 'Schedule successfully saved.' : 'Unable to save schedule due to an internal error. Try again later?');

    return Redirect::action('ScheduleController@getIndex');

  }

}
