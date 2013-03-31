<?php

class CourseController extends BaseController {

  public function getIndex()
  {

    return Redirect::to('course/search');

  }

  public function getSearch()
  {

    return View::make('course.search');

  }

  public function postSearch()
  {

    $search_results = DB::table('courses')
      ->where('code', 'like', '%' . Input::get('query') . '%')
      ->orWhere('description', 'like', '%' . Input::get('query') . '%')
      ->get();

    Session::flash('search_results', $search_results);

    return Redirect::to('course/search')
      ->withInput();
  }

}
