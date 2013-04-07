<?php

class CourseSection extends Eloquent {

  protected $table = 'course_sections';

  public $timestamps = false;

  public function courseTimeslots()
  {
    return $this->hasMany('CourseTimeslot', 'section_id');
  }

  public function course()
  {
    return $this->belongsTo('Course');
  }

  public function schoolSession()
  {
    return $this->belongsTo('SchoolSession', 'session_id');
  }

}
