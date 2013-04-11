<?php

class ProgramCourseSequence extends Eloquent {

  protected $table = 'program_course_sequences';
  
  public $timestamps = false;

  public function program()
  {
    return $this->belongsTo('Program');
  }

}
