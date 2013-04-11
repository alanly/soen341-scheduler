<?php

class ProgramOptionCourse extends Eloquent {

  protected $table = 'program_option_courses';

  public $timestamps = false;

  public function programOption()
  {
    return $this->belongsTo('ProgramOption', 'program_option_id');
  }

}

