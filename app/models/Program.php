<?php

class Program extends Eloquent {
  
  protected $table = 'programs';

  protected $guarded = array('id');

  public $timestamps = false;

  public function programOptions()
  {
    return $this->hasMany('ProgramOption');
  }

  public function programCourseSequences()
  {
    return $this->hasMany('ProgramCourseSequence');
  }

}

