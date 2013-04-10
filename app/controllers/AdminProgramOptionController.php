<?php

class AdminProgramOptionController extends BaseController {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		return View::make('admin-options');
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		$description = Input::get("description");	
		$program = Input::get("program");
		$courses = Input::get("course");
		$id = DB::table('program_options')->insertGetId(array('description' => $description, 'program_id' => $program));
        	//checking if courses were selected
                foreach($courses as $course){
                        DB::table('program_option_courses')->insert(array('program_option_id'=> $id, 'course_id'=> $course ));
                }
		return Redirect::to('admin/options');
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
		$option = ProgramOption::find($id);
                return View::make('edit-options')->with('option', $option);

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
		 DB::table('program_options')->delete($id);
		 return Redirect::action('AdminProgramOptionController@index');
	}

}
