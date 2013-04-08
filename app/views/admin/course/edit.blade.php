@extends('admin.course.master')


@section('section_styles')
.del_frm {
  display: inline;
}
.del_frm a {
  cursor: pointer;
}
@stop


@section('section_sidebar')
<br>
<ul class="nav nav-list well">
  <li class="nav-header">Current School Session...</li>
  <li>
    {{ Form::open( array('method' => 'GET', 'class' => 'form-inline', 'id' => 'session_form') ) }}
      <select id="session" name="session" onchange="$('#session_form').submit()" class="span12">
        @foreach( $allSessions as $session )
        <option value="{{ $session->id }}"{{ $session->id == $currentSession->id ? ' selected' : '' }}>{{{ $session->code }}}</option>
        @endforeach
      </select>
    {{ Form::close() }}
  </li>
</ul>
@stop


@section('subsection_content')
<div class="row-fluid">

  <div class="tabbable">
    <ul class="nav nav-tabs">
      <li{{ Session::get('edit_pane') == 'course' ? ' class="active"' : '' }}><a href="#course" data-toggle="tab">Edit Course Attributes</a></li>
      <li{{ Session::get('edit_pane') == 'constraints' ? ' class="active"' : '' }}><a href="#constraints" data-toggle="tab">Edit Course Constraints</a></li>
      <li{{ Session::get('edit_pane') == 'sections' ? ' class="active"' : '' }}><a href="#sections" data-toggle="tab">Edit Course Sections</a></li>
      <li{{ Session::get('edit_pane') == 'timeslots' ? ' class="active"' : '' }}><a href="#timeslots" data-toggle="tab">Edit Course Timeslots</a></li>
    </ul>

    <div class="tab-content">

      <div class="tab-pane{{ Session::get('edit_pane') == 'course' ? ' active' : '' }}" id="course">
        <div class="row-fluid">
          {{ Form::open( array('url' => URL::action('AdminCourseController@update', array($course->id)), 'method' => 'PUT', 'class' => 'form-horizontal well') ) }}
            <fieldset>

              <legend>Editing &ldquo;<em>{{{ $course->code }}} &mdash; {{{ $course->description }}}</em>&rdquo;</legend>

              <div class="control-group{{ $errors->has('course_code') ? ' error' : '' }}">
                <label class="control-label" for="course_code">Code</label>

                <div class="controls">
                  <input type="text" id="course_code" name="course_code" class="input-large" placeholder="Unique identifier for course. e.g. SOEN341" value="{{ Input::old('course_code', $course->code) }}" required>
                  {{ $errors->first('course_code') }}
                </div>
              </div>

              <div class="control-group{{ $errors->has('course_description') ? ' error' : '' }}">
                <label class="control-label" for="course_description">Description</label>

                <div class="controls">
                  <input type="text" id="course_description" name="course_description" class="input-xlarge" placeholder="Short and descriptive title for course. e.g. Software Process" value="{{ Input::old('course_description', $course->description) }}" required>
                  {{ $errors->first('course_code') }}
                </div>
              </div>

              <div class="control-group">
                <div class="controls">
                  <button type="submit" class="btn btn-primary"><i class="icon-save"></i> Save changes to course</button>
                </div>
              </div>

            </fieldset>
            {{ Form::token() }}
            {{ Form::hidden('edit_pane', 'course') }}
          {{ Form::close() }}
        </div>
      </div>

      <div class="tab-pane{{ Session::get('edit_pane') == 'constraints' ? ' active' : '' }}" id="constraints">
      </div>

      <div class="tab-pane{{ Session::get('edit_pane') == 'sections' ? ' active' : '' }}" id="sections">
        <div class="row-fluid">
          <div class="span6">
            <table class="table table-hover">
              <thead>
                <tr>
                  <th>Code</th><th>Timeslot Count</th><th>Actions</th>
                </tr>
              </thead>

              <tbody>
                @if( $sections->count() == 0 )
                  <tr class="table-info"><td colspan="3"><p class="muted text-center">There are currently no sections in this course.</p></td></tr>
                @endif
                @foreach( $sections as $section )
                  <tr>
                    <td>{{{ $section->code }}}</td>
                    <td>{{{ $section->courseTimeslots()->count() }}}</td>
                    <td>
                      <a href="{{ URL::action('AdminCourseSectionController@edit', array($section->id)) }}"><i class="icon-edit"></i></a>

                      {{ Form::open( array('method' => 'DELETE', 'url' => URL::action('AdminCourseSectionController@destroy', array($section->id)), 'id' => 'delsec_' . $section->id, 'class' => 'del_frm') ) }}
                        <a onclick="$('#delsec_{{ $section->id }}').submit()"><i class="icon-trash"></i></a>
                        {{ Form::token() }}
                      {{ Form::close() }}
                    </td>
                  </tr>
                @endforeach
              </tbody>
            </table>
          </div>

          <div class="span6">
            {{ Form::open( array('url' => URL::action('AdminCourseSectionController@store'), 'class' => 'form-horizontal well') ) }}
              <fieldset>
                <legend>Create a new course section.</legend>

                <div class="control-group{{ $errors->has('code') ? ' error' : '' }}">
                  <label class="control-label" for="code">Section Code</label>

                  <div class="controls">
                    <input type="text" id="code" name="code" class="input-small" placeholder="e.g. CC" value="{{ Input::old('code') }}" title="A short identifier for this course section." required>
                    {{ $errors->first('code') }}
                  </div>
                </div>

                <div class="control-group">
                  <label class="control-label" for="currentSession">School Session</label>

                  <div class="controls">
                    <input type="text" id="currentSession" class="input-small" value="{{ $currentSession->code }}" readonly>
                  </div>
                </div>

                <div class="control-group">
                  <div class="controls">
                    <button type="submit" class="btn btn-primary"><i class="icon-plus-sign"></i> Create this course section.</button>
                  </div>
                </div>
              </fieldset>
              {{ Form::hidden('course_id', $course->id) }}
              {{ Form::token() }}
            {{ Form::close() }}
          </div>
        </div>
      </div>

      <div class="tab-pane{{ Session::get('edit_pane') == 'timeslots' ? ' active' : '' }}" id="timeslots">
      </div>

    </div>
  </div>

</div>
@stop

