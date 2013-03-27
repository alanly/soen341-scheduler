<?php

class AcademicRecord extends Eloquent {

  protected $tables = 'academic_records';

  public function user()
  {
    return $this->belongsTo('User');
  }

}
