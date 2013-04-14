<?php

class Schedule extends Eloquent {

  protected $table = 'schedules';

  protected $guarded = array('id');

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

  public function schoolSession()
  {
    return $this->belongsTo('SchoolSession', 'session_id');
  }

}
