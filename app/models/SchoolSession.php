<?php

class SchoolSession extends Eloquent {

  protected $table = "school_sessions";

  public $timestamps = false;

  public function courses()
  {
    return $this->hasMany('Course', 'session_id');
  }

}
