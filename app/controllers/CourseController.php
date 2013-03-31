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

}
