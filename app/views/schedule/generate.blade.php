@extends('schedule.master')


@section('section_title')
Generate a Schedule
@stop


@section('section_content')
<div class="row-fluid">
  {{ Form::open(array(
    'id' => 'generateForm',
    'class' => 'form-horizontal well'
  )) }}
    <fieldset>
      <legend>Generate a Schedule</legend>

      <div class="control-group{{ $errors->has('times') ? ' error' : '' }}">
        <label class="control-label" for="times">Preferred Timeframe</label>

        <div class="controls">
          <label class="checkbox inline">
            <input type="checkbox" id="timesMorn" name="times[]" value="0"{{ Input::old('times') != null ? (in_array('0', (array)Input::old('times', array())) ? ' checked' : '') : ' checked' }}>
            Mornings (00:00 &ndash; 12:00)
          </label>

          <label class="checkbox inline">
            <input type="checkbox" id="timesNoon" name="times[]" value="1"{{ Input::old('times') != null ? (in_array('1', (array)Input::old('times', array())) ? ' checked' : '') : ' checked' }}>
            Afternoons (12:00 &ndash; 17:00)
          </label>

          <label class="checkbox inline">
            <input type="checkbox" id="timesEven" name="times[]" value="2"{{ Input::old('times') != null ? (in_array('2', (array)Input::old('times', array())) ? ' checked' : '') : ' checked' }}>
            Evenings (17:00 &ndash; 23:00)
          </label>
        </div>
      </div>

      <div class="control-group{{ $errors->has('dates') ? ' error' : '' }}">
        <label class="control-label">Preferred Days</label>

        <div class="controls">
          <label class="checkbox inline">
            <input type="checkbox" id="daysSun" name="dates[]"{{ Input::old('dates') != null ? (in_array('0', (array)Input::old('dates', array())) ? ' checked' : '') : ' checked' }} value="0"> Sun
          </label>
          <label class="checkbox inline">
            <input type="checkbox" id="daysMon" name="dates[]"{{ Input::old('dates') != null ? (in_array('1', (array)Input::old('dates', array())) ? ' checked' : '') : ' checked' }} value="1"> Mon
          </label>
          <label class="checkbox inline">
            <input type="checkbox" id="daysTue" name="dates[]"{{ Input::old('dates') != null ? (in_array('2', (array)Input::old('dates', array())) ? ' checked' : '') : ' checked' }} value="2"> Tue
          </label>
          <label class="checkbox inline">
            <input type="checkbox" id="daysWed" name="dates[]"{{ Input::old('dates') != null ? (in_array('3', (array)Input::old('dates', array())) ? ' checked' : '') : ' checked' }} value="3"> Wed
          </label>
          <label class="checkbox inline">
            <input type="checkbox" id="daysThu" name="dates[]"{{ Input::old('dates') != null ? (in_array('4', (array)Input::old('dates', array())) ? ' checked' : '') : ' checked' }} value="4"> Thu
          </label>
          <label class="checkbox inline">
            <input type="checkbox" id="daysFri" name="dates[]"{{ Input::old('dates') != null ? (in_array('5', (array)Input::old('dates', array())) ? ' checked' : '') : ' checked' }} value="5"> Fri
          </label>
          <label class="checkbox inline">
            <input type="checkbox" id="daysSat" name="dates[]"{{ Input::old('dates') != null ? (in_array('6', (array)Input::old('dates', array())) ? ' checked' : '') : ' checked' }} value="6"> Sat
          </label>
          @if( $errors->has('dates') )
            <span class="help-block">
            {{ $errors->first('dates') }}
            </span>
          @endif
        </div>
      </div>

      <div class="control-group{{ $errors->has('courses') ? ' error' : '' }}">
        <label class="control-label">Courses</label>

        <div class="controls">
          <div>
            <select id="courses" name="courses" class="input-xxlarge" required>
              @foreach( $allCourses as $course )
                <option value="{{ $course->id }}">{{{ $course->code }}} &ndash; {{{ $course->description }}}</option>
              @endforeach
            </select>

            <button type="submit" name="data" value="courses" class="btn"><i class="icon-plus"></i></button>

            <table>
              <tbody>
                @if( !(Session::has('schedGenCourses')) || count(Session::get('schedGenCourses')) == 0 )
                  <tr><td><p class="muted">No courses selected yet.</p></td></tr>
                @endif
                @foreach( $courses as $course )
                  <tr><td><a href="/course/details/{{ $course->id }}" target="_blank">{{{ $course->code }}} &ndash; {{{ $course->description }}}</a></td></tr>
                @endforeach
              </tbody>
            </table>
          </div>

          {{ $errors->first('courses') }}
        </div>
      </div>

      <div class="control-group">
        <div class="controls">
          <button type="submit" name="data" value="generate" class="btn btn-primary"><i class="icon-cog icon-spinner"></i> Generate Schedule</button>
        </div>
      </div>
    </fieldset>
    {{ Form::token() }}
  {{ Form::close() }}
</div>
@stop
