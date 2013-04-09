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
                      <a href="{{ URL::action('AdminCourseSectionController@edit', array($section->id)) }}" title="Edit this section."><i class="icon-edit"></i></a>

                      {{ Form::open( array('method' => 'DELETE', 'url' => URL::action('AdminCourseSectionController@destroy', array($section->id)), 'id' => 'delsec_' . $section->id, 'class' => 'del_frm') ) }}
                        <a onclick="$('#delsec_{{ $section->id }}').submit()" title="Delete this section."><i class="icon-trash"></i></a>
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
        <div class="row-fluid">
          <table class="table table-hover">
            <thead>
              <tr>
                <th>Type</th>
                <th>Code</th>
                <th>Day</th>
                <th>Time</th>
                <th>Location</th>
                <th>Instructor</th>
                <th>Actions</th>
              </tr>
            </thead>

            <tbody>
              @if( $sections->count() == 0 )
              <tr><td colspan="7"><p class="muted text-center">There are no sections in this course.</p></td></tr>
              @endif
              @foreach( $sections as $section )
                <tr class="info">
                  <td colspan="7">Section {{{ $section->code }}}</td>
                </tr>

                @if( $section->courseTimeslots()->count() == 0 )
                <tr>
                  <td colspan="7"><p class="muted text-center">There are no timeslots in this section.</p></td>
                </tr>
                @endif

                @foreach( $section->courseTimeslots()->get() as $timeslot )
                  <tr>
                    <td>{{{ $timeslot->type }}}</td>
                    <td>{{{ $timeslot->code }}}</td>
                    <td>{{{ $timeslot->day }}}</td>
                    <td>{{{ $timeslot->start_time }}} &ndash; {{{ $timeslot->end_time }}}</td>
                    <td>{{{ $timeslot->location }}}</td>
                    <td>{{{ $timeslot->instructor }}}</td>
                    <td>
                      <a href="/admin/coursetimeslot/{{ $timeslot->id }}/edit" title="Edit this timeslot."><i class="icon-edit"></i></a>

                      {{ Form::open( array('url' => '/admin/coursetimeslot/' . $timeslot->id, 'method' => 'DELETE', 'id' => 'delts_' . $timeslot->id, 'class' => 'del_frm') ) }}
                        <a onclick="$('#delts_{{ $timeslot->id }}').submit()" title="Delete this timeslot."><i class="icon-trash"></i></a>
                        {{ Form::token() }}
                      {{ Form::close() }}

                    </td>
                  </tr>
                @endforeach
              @endforeach
            </tbody>
          </table>
        </div>

        <div class="row-fluid">
          {{ Form::open( array('url' => '/admin/coursetimeslot', 'class' => 'form-horizontal well') ) }}
            <fieldset>
              <legend>Create a new timeslot.</legend>

              <div class="control-group">
                <label class="control-label">Current School Session</label>

                <div class="controls">
                  <input type="text" class="input-small" value="{{ $currentSession->code }}" readonly>
                </div>
              </div>

              <div class="control-group{{ $errors->has('section') ? ' error' : '' }}">
                <label class="control-label" for="section">Parent Section</label>

                <div class="controls">
                  <select id="section" name="section" required>
                    @foreach( $sections as $section )
                    <option value="{{ $section->id }}"{{ $section->id == Input::old('section', '') ? ' selected' : '' }}>{{{ $section->code }}}</option>
                    @endforeach
                  </select>
                  {{ $errors->first('section') }}
                </div>
              </div>

              <div class="control-group{{ $errors->has('type') ? ' error' : '' }}">
                <label class="control-label" for="type">Timeslot Type</label>

                <div class="controls">
                  <select id="type" name="type" required>
                    <option value="LECTURE"{{ Input::old('type', '') == 'LECTURE' ? ' selected' : '' }}>Lecture</option>
                    <option value="TUTORIAL"{{ Input::old('type', '') == 'TUTORIAL' ? ' selected' : '' }}>Tutorial</option>
                    <option value="LAB"{{ Input::old('type', '') == 'LAB' ? ' selected' : '' }}>Lab</option>
                  </select>
                  {{ $errors->first('type') }}
                </div>
              </div>

              <div class="control-group{{ $errors->has('code') ? ' error' : '' }}">
                <label class="control-label" for="timeslotCode">Timeslot Code</label>

                <div class="controls">
                  <input type="text" id="timeslotCode" name="code" class="input-small" placeholder="e.g. CC" value="{{ Input::old('code') }}" required>
                  {{ $errors->first('code') }}
                </div>
              </div>

              <div class="control-group{{ $errors->has('dateCheckbox') ? ' error' : '' }}">
                <label class="control-label">Days</label>

                <div class="controls">
                  <label class="checkbox inline">
                    <input type="checkbox" id="daysCheckboxSun" name="dateCheckbox[]"{{ in_array('0', (array)Input::old('dateCheckbox', array())) ? ' checked' : '' }} value="0"> Sun
                  </label>
                  <label class="checkbox inline">
                    <input type="checkbox" id="daysCheckboxMon" name="dateCheckbox[]"{{ in_array('1', (array)Input::old('dateCheckbox', array())) ? ' checked' : '' }} value="1"> Mon
                  </label>
                  <label class="checkbox inline">
                    <input type="checkbox" id="daysCheckboxTue" name="dateCheckbox[]"{{ in_array('2', (array)Input::old('dateCheckbox', array())) ? ' checked' : '' }} value="2"> Tue
                  </label>
                  <label class="checkbox inline">
                    <input type="checkbox" id="daysCheckboxWed" name="dateCheckbox[]"{{ in_array('3', (array)Input::old('dateCheckbox', array())) ? ' checked' : '' }} value="3"> Wed
                  </label>
                  <label class="checkbox inline">
                    <input type="checkbox" id="daysCheckboxThu" name="dateCheckbox[]"{{ in_array('4', (array)Input::old('dateCheckbox', array())) ? ' checked' : '' }} value="4"> Thu
                  </label>
                  <label class="checkbox inline">
                    <input type="checkbox" id="daysCheckboxFri" name="dateCheckbox[]"{{ in_array('5', (array)Input::old('dateCheckbox', array())) ? ' checked' : '' }} value="5"> Fri
                  </label>
                  <label class="checkbox inline">
                    <input type="checkbox" id="daysCheckboxSat" name="dateCheckbox[]"{{ in_array('6', (array)Input::old('dateCheckbox', array())) ? ' checked' : '' }} value="6"> Sat
                  </label>
                  @if( $errors->has('dateCheckbox') )
                    <span class="help-block">
                    {{ $errors->first('dateCheckbox') }}
                    </span>
                  @endif
                </div>
              </div>

              <div class="control-group{{ $errors->has('startTime') ? ' error' : '' }}">
                <label class="control-label" for="startTime">Start Time</label>

                <div class="controls">
                  <input type="time" id="startTime" name="startTime" class="input-small" value="{{ Input::old('startTime') }}" required>
                  {{ $errors->first('startTime') }}
                </div>
              </div>

              <div class="control-group{{ $errors->has('endTime') ? ' error' : '' }}">
                <label class="control-label" for="endTime">End Time</label>

                <div class="controls">
                  <input type="time" id="endTime" name="endTime" class="input-small" value="{{ Input::old('endTime') }}" required>
                  {{ $errors->first('endTime') }}
                </div>
              </div>

              <div class="control-group{{ $errors->has('location') ? ' error' : '' }}">
                <label class="control-label" for="location">Location</label>

                <div class="controls">
                  <input type="text" id="location" name="location" class="input-xlarge" placeholder="Physical location where the timeslot is held." value="{{ Input::old('location') }}" required>
                  {{ $errors->first('location') }}
                </div>
              </div>

              <div class="control-group{{ $errors->has('instructor') ? ' error' : '' }}">
                <label class="control-label" for="instructor">Instructor</label>

                <div class="controls">
                  <input type="text" id="instructor" name="instructor" class="input-xlarge" placeholder="Name of the instructor that is teaching." value="{{ Input::old('instructor') }}" required>
                  {{ $errors->first('instructor') }}
                </div>
              </div>

              <div class="control-group">
                <div class="controls">
                  <button type="submit" class="btn btn-primary"><i class="icon-plus-sign"></i> Create Timeslot</button>
                </div>
              </div>
            </fieldset>
            {{ Form::token() }}
            {{ Form::hidden('course_id', $course->id) }}
          {{ Form::close() }}
        </div>
      </div>

    </div>
  </div>

</div>
@stop

