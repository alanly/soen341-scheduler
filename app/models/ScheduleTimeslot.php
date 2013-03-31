<?php

class ScheduleTimeslot extends Eloquent {

  protected $table = 'schedule_timeslots';

  public $timestamps = false;

  public function schedule()
  {
    return $this->belongsTo('Schedule');
  }

}

