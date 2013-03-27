<?php

class CourseConstraint extends Eloquent {

  protected $table = 'course_constraints';

  public function course()
  {
    return $this->belongsTo('Course');
  }

}

