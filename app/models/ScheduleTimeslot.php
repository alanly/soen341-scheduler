<?php

class ScheduleTimeslot extends Eloquent {

  protected $table = 'schedule_timeslots';

  public function schedule()
  {
    return $this->belongsTo('Schedule');
  }

}

