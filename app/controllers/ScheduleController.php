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
private function isOverlap($a, $b) {
         foreach ($a as $t) {
               if ((strtotime($t->start_time) >= strtotime($b->start_time) && strtotime($t->start_time) <= strtotime($b->end_time)) ||
                  (strtotime($b->start_time) >= strtotime($t->start_time) && strtotime($b->start_time) <= strtotime($t->end_time))) {
                        return true;
                 }
          }
          return false;
 }

  public function postCreate()
  {
		$courses = Session::get('schedSelectedCourses');
                $timeslots = array();
                $ids = array();
                foreach($courses as $course_id)
                {
                        $time_ids = DB::table("course_timeslots")->where("course_id",$course_id)->get();
                        foreach($time_ids as $slots){
                                array_push($ids, $slots->id);
                                array_push($timeslots,$slots);
                        }
                }
                Session::put("schedule",$ids);


		$timeConstraints = array(0, 1, 1);
		$dayConstraints = array(1, 1, 1, 1, 1, 1, 1);
		
		$sunday = array();
		$monday = array();
		$tuesday = array();
		$wednesday = array();
		$thursday = array();
		$friday = array();
		$saturday = array();
		
		foreach ($timeslots as $i => &$time) {
			if ($timeConstraints[0] == 0) {
				// no mornings 00:00 -> 12:00
				if (strtotime($time->start_time) < strtotime("12:00")) {
					//unset($timeslots[$i]);
					foreach ($timeslots as $j => &$time2) {
						if ($time2->section_id == $time->section_id)
							unset($timeslots[$j]);
					}
					
				}
			}
			if ($timeConstraints[1] == 0) {
				// no days 12:00 -> 17:00
				if (strtotime($time->start_time) > strtotime("12:00") & strtotime($time->end_time) < strtotime("17:00")) {
					//unset($timeslots[$i]);
					foreach ($timeslots as $j => &$time2) {
						if ($time2->section_id == $time->section_id)
							unset($timeslots[$j]);
					}
				}

			}
			if ($timeConstraints[2] == 0) {
				// no nights 17:00 -> 23:00
				if (strtotime($time->start_time) > strtotime("17:00")) {
					//unset($timeslots[$i]);
					foreach ($timeslots as $j => &$time2) {
						if ($time2->section_id == $time->section_id)
							unset($timeslots[$j]);
					}
				}
			}
		}

		foreach ($timeslots as $i => &$time) {
			for ($a = 0; $a < 7; $a++) {
				if ($dayConstraints[$a] == 0) {
					if ($time->day == $a) {
						//echo $a;
						foreach ($timeslots as $j => &$time2) {
							if ($time2->section_id == $time->section_id)
								unset($timeslots[$j]);
						}
					}
				}
			}
		}
		
		
		$earliestTime = '24:00';
		$latestTime = '0:00';
		
		// check for overlap
		
		foreach($timeslots as $time) {
			// Find the earliest and lastest times for the schedule
			if (strtotime($time->start_time) < strtotime($earliestTime)) {
				$earliestTime = $time->start_time;
			}
			if (strtotime($time->end_time) > strtotime($latestTime)) {
				$latestTime = $time->end_time;
			}
			
			switch($time->day){
				case 0:
					if(!isOverlap($sunday, $time))
						$sunday[strtotime($time->start_time)] = $time;
					break;
				case 1:
					if(!$this->isOverlap($monday, $time))
						$monday[strtotime($time->start_time)] = $time;
					break;
				case 2:
					if(!$this->isOverlap($tuesday, $time))
						$tuesday[strtotime($time->start_time)] = $time;
					break;
				case 3:
					if(!$this->isOverlap($wednesday, $time))
						$wednesday[strtotime($time->start_time)] = $time;
					break;
				case 4:
					if(!$this->isOverlap($thursday, $time))
						$thursday[strtotime($time->start_time)] = $time;
					break;
				case 5:
					if(!$this->isOverlap($friday, $time))
						$friday[strtotime($time->start_time)] = $time;
					break;
				case 6:
					if(!$this->isOverlap($saturday, $time))
						$saturday[strtotime($time->start_time)] = $time;
					break;
			}

		}
	return View::make('schedule.schedule_generate')->with("earliestTime",$earliestTime)->with("latestTime",$latestTime)
		->with("sunday",$sunday)->with("monday",$monday)->with("tuesday",$tuesday)->with("wednesday",$wednesday)->with("thursday",$thursday)
		->with("friday",$friday)->with("saturday",$saturday);
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
  public function postSave(){
	$timeslots = Session::get("schedule");
	$uid = Auth::user()->id;
	  $schedule_id = Schedule::create(array('user_id' => $uid))->id;
	  foreach ($timeslots as $id){
	    ScheduleTimeslot::create((array("schedule_id" => $schedule_id, "course_timeslot_id"=> $id)));
	  }
  return Redirect::action('ScheduleController@getIndex');

  }
}
