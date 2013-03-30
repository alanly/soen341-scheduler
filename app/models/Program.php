<?php

class Program extends Eloquent {
  
  protected $table = 'programs';

  public function programOptions()
  {
    return $this->hasMany('ProgramOption');
  }

  public function programCourseSequences()
  {
    return $this->hasMany('ProgramCourseSequence');
  }

}
