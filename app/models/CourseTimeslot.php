<?php

class CourseTimeslot extends Eloquent {

  protected $table = 'course_timeslots';

  protected $guarded = array('id');

  public $timestamps = false;

  public function course()
  {
    return $this->belongsTo('Course');
  }

  public function courseSection()
  {
    return $this->belongsTo('CourseSection', 'section_id');
  }

}

