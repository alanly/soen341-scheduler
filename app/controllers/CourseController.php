<?php

class CourseController extends BaseController {

  public function __construct()
  {

    $this->beforeFilter('csrf', array('on' => 'post'));
    $this->beforeFilter('auth');

  }

  public function getIndex()
  {

    return Redirect::to('course/search');

  }

  public function getSearch()
  {

    if( Input::has('query') ) {
      $search_results = DB::table('courses')
        ->where('code', 'like', '%' . Input::get('query') . '%')
        ->orWhere('description', 'like', '%' . Input::get('query') . '%')
        ->get();

      Session::flash('search_results', $search_results);
    }

    return View::make('course.search');
  }

  public function getList()
  {

    $courses = Course::orderBy('code')->get();

    return View::make('course.list')->with('courses', $courses);

  }

  public function getDetails($id)
  {

    $course = Course::find($id);

    if( is_null($course) )
      App::abort(404, 'Requested course not found.');

    return View::make('course.details')
      ->with('course', $course);

  }

}
