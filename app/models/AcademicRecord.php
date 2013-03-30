<?php

class AcademicRecord extends Eloquent {

  protected $tables = 'academic_records';

  public $timestamps = false;

  public function user()
  {
    return $this->belongsTo('User');
  }

}
