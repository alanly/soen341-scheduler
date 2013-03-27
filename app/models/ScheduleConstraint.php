<?php

class ScheduleConstraint extends Eloquent {

  protected $table = 'schedule_constraints';

  public function schedule()
  {
    return $this->belongsTo('Schedule');
  }

}
