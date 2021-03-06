@extends('academicrecord.master')

@section('section_title')
My Academic Record
@stop

@section('section_content')

<div class="row-fluid">
  @if( Session::has('action_message') )
  <div class="alert alert-block alert-{{ Session::get('action_success') ? 'success' : 'error' }}">
    <p>{{ Session::get('action_message') }}</p>
  </div>
  @endif
</div>

<div class="row-fluid">
  <p>Your academic record details all the courses that you've completed. The entries below are factored into the generation of proceeding schedules.</p>
</div>

<div class="row-fluid">
  <table class="table table-hover">
    <thead>
      <tr>
        <th>Completed Courses</th>
        <th>Remove</th>
      </tr>
    </thead>

    <tbody>
      @if( count($records) == 0 )
      <tr>
        <td colspan="2">You currently do not have any entries in your academic record.</td>
      </tr>
      @else
        @foreach( $records as $id => $course )
        <tr>
          <td><a href="/course/details/{{ $course->id }}">{{{ $course->code }}} &ndash; {{{ $course->description }}}</a></td>
          <td><a href="/academicrecord/delete/{{ $id }}"><i class="icon-trash"></i></a></td>
        </tr>
        @endforeach
      @endif
    </tbody>
  </table>
</div>

<div class="row-fluid">
  <div class="well">
    {{ Form::open(array('class' => 'form-horizontal')) }}
      <fieldset>
        <legend>Add a new record.</legend>

        <div class="control-group{{ $errors->has('course') ? ' error' : '' }}">
          <label class="control-label" for="course">Course</label>

          <div class="controls">
            <select id="course" name="course" class="input-xxlarge">
             <option>&mdash; Pick a course you've completed... &mdash;</option>
              @foreach( $availableCourses as $course )
              <option value="{{ $course->id }}">{{{ $course->code }}} &ndash; {{{ $course->description }}}</option>
              @endforeach
            </select>
            @if( $errors->has('course') )
            <span class="help-block">{{ $errors->first('course') }}</span>
            @endif
          </div>
        </div>

        <div class="control-group">
          <div class="controls">
            <button type="submit" class="btn btn-primary"><i class="icon-plus-sign"></i> Add</button>
          </div>
        </div>
      </fieldset>

      {{ Form::token() }}
    {{ Form::close() }}
  </div>
</div>

@stop
