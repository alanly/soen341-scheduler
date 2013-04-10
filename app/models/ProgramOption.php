<?php

class ProgramOption extends Eloquent {

  protected $table = 'program_options';

  public $timestamps = false;

  public function programOptionCourses()
  {
    return $this->hasMany('ProgramOptionCourse', 'program_option_id');
  } 

  public function program()
  {
    return $this->belongsTo('Program');
  }

}
