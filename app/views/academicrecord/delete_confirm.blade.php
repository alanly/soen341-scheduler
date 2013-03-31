@extends('layouts.master')

@section('page_title')
Academic Record
@stop

@section('page_content')
<div class="container">
  <div class="page-header">
    <h2>My Academic Record</h2>
  </div>

  <div class="well">
    {{ Form::open(array('class' => 'form-horizontal')) }}
      <fieldset>
        <legend>Confirm deletion.</legend>

        <div class="control-group">
          <div class="controls">
            <span class="help-inline">Are you sure you want to remove <strong>{{{ $course->code }}} &ndash; {{{ $course->description }}}</strong> from your academic record?</span>
          </div>
        </div>

        <div class="control-group">
          <div class="controls">
            <button type="submit" class="btn btn-primary"><i class="icon-remove-sign"></i> Yes, remove it.</button>
            <a class="btn" href="/academicrecord">Cancel</a>
          </div>
        </div>
      </fieldset>

      {{ Form::token() }}
    {{ Form::close() }}
  </div>
</div>
@stop
