<?php

class Course extends Eloquent {

  protected $table = 'courses';

  public $timestamps = false;

  public function courseConstraints()
  {
    return $this->hasMany('CourseConstraint');
  }

  public function courseSections()
  {
    return $this->hasMany('CourseSection');
  }

  public function courseTimeslots()
  {
    return $this->hasMany('CourseTimeslot');
  }

  public function schoolSession()
  {
    return $this->belongsTo('SchoolSession', 'session_id');
  }

}
