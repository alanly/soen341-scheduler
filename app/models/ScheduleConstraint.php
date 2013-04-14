<?php

class ScheduleConstraint extends Eloquent {

  protected $table = 'schedule_constraints';

  public $timestamps = false;

  public function schedule()
  {
    return $this->belongsTo('Schedule');
  }

}
