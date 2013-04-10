<?php

class AdminCourseController extends BaseController {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
  {
		return View::make('admin-courses');
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		$description = Input::get("description");
		$code = Input::get("code");
		$section = Input::get("section");
	        $id = DB::table('courses')->insertGetId(array('description' => $description, 'code' => $code));
	        $sectionId = DB::table('course_sections')->insertGetId(array('course_id'=>$id,'code'=>$section));
		return Redirect::to('admin/courses');
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		//
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

		$course = Course::find($id);  
		$timeslots = $course->courseTimeslots()->get();
		return View::make('edit-courses')->with('course', $course)->with('timeslots',$timeslots);
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
 	{
	    $section_id = Input::get('section');
	    $type = 'NO_TYPE';
	    $location = Input::get('location');
	    $instructor = Input::get('instructor');
	    $start_time = Input::get('start');
	    $end_time = Input::get('end');
	    $start = strtotime($start_time);
	    $end = strtotime($end_time);
	    $error = false;
	    if($start > $end){
		$error = true;
		$error_msg = "Cannot have the start time after the end time";
	    }
	    $course = Course::find($id);
	    $timeslots = $course->courseTimeslots()->get();
		 //checking if conflicts with already inserted timeslots
            foreach($timeslots as $timeslot){
		foreach(Input::get('days') as $day){
                if((($start >= strtotime($timeslot->start_time) && $start <= strtotime($timeslot->end_time)) ||
                    ($end >= strtotime($timeslot->start_time) && $end <= strtotime($timeslot->end_time))) && ($section_id == $timeslot->section_id) &&
			($day == $timeslot->day)){
                           $error = true;
			   $error_msg = "There is a conflict with the times you have chosen.";
                           break;
                        }
                }
	     }
	     if($error){
              	 return View::make('edit-courses')->with('course', $course)->with('timeslots',$timeslots)->with('error',$error_msg);
		}
		
	    foreach( Input::get('days') as $day ) {
	      CourseTimeslot::create(
	        array(
	          'course_id' => $id,
	          'section_id' => $section_id,
	          'type' => $type,
	          'location' => $location,
	          'instructor' => $instructor,
	          'day' => $day,
	          'start_time' => $start_time,
	          'end_time' => $end_time
	        )
	      );
	}
	
		return Redirect::to("admin/courses/$id/edit");
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		$action = Input::get('action');
		if($action == 'timeslot'){
			$timeslot_id = Input::get('timeslot_id');
			DB::table('course_timeslots')->where('id','=',$timeslot_id)->delete();				
			return Redirect::to("admin/courses/$id/edit");
		}else if($action == 'course'){
			 DB::table('courses')->delete($id);
	                $section_ids = DB::table('course_sections')->where('course_id','=',$id)->lists('id');
                	DB::table('course_sections')->where('course_id','=',$id)->delete();
	                foreach($section_ids as $section_id){
        	                DB::table('course_timeslots')->where('section_id','=',$section_id)->delete();
               		}
			return Redirect::action('AdminCourseController@index');
		}
		
	}

}
