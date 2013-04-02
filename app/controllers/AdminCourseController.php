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
		$timeslots = CourseTimeslot::all();
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
	        DB::table('courses')->delete($id);
	        DB::table('course_sections')->where('course_id','=',$id)->delete();
		return Redirect::action('AdminCourseController@index');
	}

}
