<?php

class Schedule extends Eloquent {

  protected $table = 'schedules';

  public $timestamps = true;

  public function scheduleConstraints()
  {
    return $this->hasMany('ScheduleConstraint');
  }

  public function scheduleTimeslots()
  {
    return $this->hasMany('ScheduleTimeslot');
  }

  public function user()
  {
    return $this->belongsTo('User');
  }

}
