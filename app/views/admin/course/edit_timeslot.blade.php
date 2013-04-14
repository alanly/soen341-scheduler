@extends('admin.course.master')


@section('subsection_content')
<div class="row-fluid">
  {{ Form::open( array('url' => '/admin/coursetimeslot/' . $timeslot->id, 'method' => 'PUT', 'class' => 'form-horizontal well') ) }}
    <fieldset>
      <legend>Editing timeslot &ldquo;<em>{{{ $timeslot->code }}}</em>&rdquo; for {{{ $course->description }}} &ndash; Section {{{ $section->code }}}...</legend>

      <div class="control-group{{ $errors->has('section') ? ' error' : '' }}">
        <label class="control-label" for="section">Parent Section</label>

        <div class="controls">
          <select id="section" name="section" required>
            @foreach( $allSections as $s )
              <option value="{{ $s->id }}"{{ $s->id == Input::old('section', $section->id) ? ' selected' : '' }}>{{{ $s->code }}}</option>
            @endforeach
          </select>
          {{ $errors->first('section') }}
        </div>
      </div>

      <div class="control-group{{ $errors->has('type') ? ' error' : '' }}">
        <label class="control-label" for="type">Timeslot Type</label>

        <div class="controls">
          <select id="type" name="type" required>
            <option value="LECTURE"{{ Input::old('type', $timeslot->type) == 'LECTURE' ? ' selected' : '' }}>Lecture</option>
            <option value="TUTORIAL"{{ Input::old('type', $timeslot->type) == 'TUTORIAL' ? ' selected' : '' }}>Tutorial</option>
            <option value="LAB"{{ Input::old('type', $timeslot->type) == 'LAB' ? ' selected' : '' }}>Lab</option>
          </select>
          {{ $errors->first('type') }}
        </div>
      </div>

      <div class="control-group{{ $errors->has('code') ? ' error' : '' }}">
        <label class="control-label" for="code">Timeslot Code</label>

        <div class="controls">
          <input type="text" id="code" name="code" class="input-small" placeholder="e.g. CC" value="{{ Input::old('code', $timeslot->code) }}" required>
          {{ $errors->first('code') }}
        </div>
      </div>

      <div class="control-group{{ $errors->has('date') ? ' error' : '' }}">
        <label class="control-label" for="date">Day</label>

        <div class="controls">
          <select id="date" name="date" required>
            <option value="0"{{ $timeslot->day == 0 ? ' selected' : '' }}>Sunday</option>
            <option value="1"{{ $timeslot->day == 1 ? ' selected' : '' }}>Monday</option>
            <option value="2"{{ $timeslot->day == 2 ? ' selected' : '' }}>Tuesday</option>
            <option value="3"{{ $timeslot->day == 3 ? ' selected' : '' }}>Wednesday</option>
            <option value="4"{{ $timeslot->day == 4 ? ' selected' : '' }}>Thursday</option>
            <option value="5"{{ $timeslot->day == 5 ? ' selected' : '' }}>Friday</option>
            <option value="6"{{ $timeslot->day == 6 ? ' selected' : '' }}>Saturaday</option>
          </select>
          {{ $errors->first('date') }}
        </div>
      </div>

      <div class="control-group{{ $errors->has('startTime') ? 'error' : '' }}">
        <label class="control-label" for="startTime">Start Time</label>

        <div class="controls">
          <input type="time" id="startTime" name="startTime" class="input-small" value="{{ Input::old('startTime', $timeslot->start_time) }}" required>
          {{ $errors->first('startTime') }}
        </div>
      </div>

      <div class="control-group{{ $errors->has('endTime') ? ' error' : '' }}">
        <label class="control-label" for="endTime">End Time</label>

        <div class="controls">
          <input type="time" id="endTime" name="endTime" class="input-small" value="{{ Input::old('endTime', $timeslot->end_time) }}" required>
          {{ $errors->first('endTime') }}
        </div>
      </div>

      <div class="control-group{{ $errors->has('location') ? ' error' : '' }}">
        <label class="control-label" for="location">Location</label>

        <div class="controls">
          <input type="text" id="location" name="location" class="input-xlarge" value="{{ Input::old('location', $timeslot->location) }}" placeholder="Physical location where timeslot is held." required>
          {{ $errors->first('location') }}
        </div>
      </div>

      <div class="control-group{{ $errors->has('instructor') ? ' error' : '' }}">
        <label class="control-label" for="instructor">Instructor</label>

        <div class="controls">
          <input type="text" id="instructor" name="instructor" class="input-xlarge" value="{{ Input::old('instructor', $timeslot->instructor) }}" placeholder="Name of the instructor that is teaching." required>
          {{ $errors->first('instructor') }}
        </div>
      </div>

      <div class="control-group">
        <div class="controls">
          <button type="submit" class="btn btn-primary"><i class="icon-save"></i> Save Changes</button>
          <button type="reset" class="btn"><i class="icon-reply"></i> Undo Changes</button>
        </div>
      </div>
    </fieldset>
    {{ Form::token() }}
  {{ Form::close() }}
</div>
@stop
