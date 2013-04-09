<?php

class CourseTimeslot extends Eloquent {

  private $weekdays = array('Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday');

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

  public function getFriendlyDay()
  {
    return $this->weekdays[ $this->day ];
  }

}

