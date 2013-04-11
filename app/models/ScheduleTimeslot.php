<?php

class ScheduleTimeslot extends Eloquent {

  protected $table = 'schedule_timeslots';
  protected $guarded = array('id');

  public $timestamps = false;

  public function schedule()
  {
    return $this->belongsTo('Schedule');
  }

  public function getCourseTimeslot()
  {
    return CourseTimeslot::find( $this->course_timeslot_id );
  }

  public function getCourse()
  {
    return $this->getCourseTimeslot()->course()->first();
  }

}

