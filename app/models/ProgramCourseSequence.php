<?php

class ProgramCourseSequence extends Eloquent {

  protected $table = 'program_course_sequences';

  public function program()
  {
    return $this->belongsTo('Program');
  }

}
