<?php

class CourseTimeslot extends Eloquent {

  protected $table = 'course_timeslots';

  public $timestamps = false;

  public function course()
  {
    return $this->belongsTo('Course');
  }

  public function courseSection()
  {
    return $this->belongsTo('CourseSection', 'course_section_id');
  }

}

