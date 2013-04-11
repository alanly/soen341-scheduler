<?php

class ProgramOption extends Eloquent {

  protected $table = 'program_options';

  protected $guarded = array('id');

  public $timestamps = false;

  public function programOptionCourses()
  {
    return $this->hasMany('ProgramOptionCourse', 'program_option_id');
  } 

  public function users()
  {
    return $this->hasMany('User', 'option_id');
  }

  public function program()
  {
    return $this->belongsTo('Program');
  }

}
