@extends('academicrecord.master')

@section('section_title')
My Academic Record
@stop

@section('section_content')

<div class="row-fluid">
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