<?php

class CourseSection extends Eloquent {

  protected $table = 'course_sections';

  public $timestamps = false;

  public function courseTimeslots()
  {
    return $this->hasMany('CourseTimeslot');
  }

  public function course()
  {
    return $this->belongsTo('Course');
  }

}
