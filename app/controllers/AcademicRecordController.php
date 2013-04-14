<?php

class AcademicRecordController extends BaseController {

  public function __construct()
  {
    $this->beforeFilter('csrf', array('on' => 'post'));
    $this->beforeFilter('auth');
  }

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function getIndex()
  {

    $records = array();
    $userRecords = Auth::user()->academicRecords;

    foreach( $userRecords as $r )
      $records[ $r->id ] = Course::find( $r->course_id );

    $availableCourses = Course::orderBy('code')->get();

    return View::make('academicrecord.index')
      ->with('records', $records)
      ->with('availableCourses', $availableCourses);

	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function postIndex()
	{
    $rules = array(
      'course' => 'required|exists:courses,id'
    );

    $validator = Validator::make(Input::all(), $rules);

    if( $validator->fails() )
      return Redirect::to('academicrecord')->withErrors($validator);

    $record = Auth::user()->academicRecords()->where('course_id', Input::get('course'))->first();

    if( is_null($record) ) {
      $record = new AcademicRecord;
      $record->user_id = Auth::user()->id;
      $record->course_id = Input::get('course');

      $action_success = $record->save();
      $action_message = $action_success ? 'Course added.' : 'Unable to add specified course due to internal error.';
    } else {
      $action_success = false;
      $action_message = 'The desired course already exists in your academic record.';
    }

    Session::flash('action_success', $action_success);
    Session::flash('action_message', $action_message);

    return Redirect::to('academicrecord');
	}

	/**
	 * Show confirmation before removing the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function getDelete($id)
  {
    // Attempt to retrieve the record
    $record = Auth::user()->academicRecords()->where('id', $id)->first();

    if( is_null($record) ) {
      Session::flash('action_success', false);
      Session::flash('action_message', 'The desired record does not exist.');

      return Redirect::to('academicrecord');
    }

    $course = Course::find( $record->course_id );

    return View::make('academicrecord.delete_confirm')
      ->with('course', $course);
  }

  public function postDelete($id)
  {
    $record = Auth::user()->academicRecords()->where('id', $id)->first();

    if( is_null($record) ) {
      Session::flash('action_success', false);
      Session::flash('action_message', 'The desired record does not exist.');
    } else {
      $record->delete();

      $action_success = is_null( AcademicRecord::find($id) );

      Session::flash('action_success', $action_success);
      Session::flash('action_message', $action_success ? 'Course has been removed from your academic record.' : 'Unable to remove the record due to unknown issue.');
    }

    return Redirect::to('academicrecord');
  }

}
