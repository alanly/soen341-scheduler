<?php

class Course extends Eloquent {

  protected $table = 'courses';

  protected $guarded = array('id');

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

}
