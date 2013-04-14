<?php

class SchoolSession extends Eloquent {

  protected $table = "school_sessions";

  protected $guarded = array('id');

  public $timestamps = false;

  public function courseSections()
  {
    return $this->hasMany('CourseSection', 'session_id');
  }

  public function schedules()
  {
    return $this->hasMany('Schedule', 'session_id');
  }

}
