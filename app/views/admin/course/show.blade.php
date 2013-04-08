@extends('admin.course.master')


@section('section_styles')
.timeslot_del_form {
  display: inline;
}
.timeslot_del_form a {
  cursor: pointer;
}
@stop


@section('section_sidebar')
<br>
<ul class="nav nav-list well">
  <li class="nav-header">Current School Session...</li>
  <li>
    {{ Form::open( array('method' => 'GET', 'class' => 'form-inline', 'id' => 'session_form') ) }}
      <select id="session" name="session" onchange="$('#session_form').submit()">
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
  <div class="span6">
    <dl class="dl-horizontal">
      <dt>Course Code</dt><dd>{{{ $course->code }}}</dd>
      <dt>Course Description</dt><dd>{{{ $course->description }}}</dd>
    </dl>
  </div>

  <div class="span6">
    <a href="/admin/course/{{ $course->id }}/edit" class="btn btn-primary"><i class="icon-edit"></i> Edit Course</a>
    <br><br>
    {{ Form::open( array('method' => 'DELETE') ) }}
      <button type="submit" class="btn btn-danger"><i class="icon-fire"></i> Delete Course</button>
    {{ Form::close() }}
  </div>
</div>

<div class="row-fluid">
  <header class="page-header">
    <h3>Course Timeslots <small>{{{ $currentSession->code }}} Session</small></h3>
  </header>
</div>

<div class="row-fluid">
  <table class="table table-hover">
    <thead>
      <th>Type</th>
      <th>Code</th>
      <th>Day</th>
      <th>Time</th>
      <th>Location</th>
      <th>Instructor</th>
      <th>Actions</th>
    </thead>

    <tbody>
      @foreach( $courseSections as $section )
        <tr class="table-info">
          <td colspan="7">Section {{{ $section->code }}}</td>
        </tr>
        @if( $section->courseTimeslots()->count() == 0 )
        <tr>
          <td colspan="7"><p class="text-center">There are currently no timeslots under this section.</p></td>
        </tr>
        @endif
        @foreach( $section->courseTimeslots() as $timeslot )
          <tr>
            <td>{{{ $timeslot->type }}}</td>
            <td>{{{ $timeslot->code }}}</td>
            <td>{{{ $timeslot->day }}}</td>
            <td>{{{ $timeslot->start_time }}} &ndash; {{{ $timeslot->end_time }}}</td>
            <td>{{{ $timeslot->location }}}</td>
            <td>{{{ $timeslot->instructor }}}</td>
            <td>
              <a href="/admin/coursetimeslot/{{ $timeslot->id }}/edit" title="Edit this timeslot."><i class="icon-edit"></i></a>
              {{ Form::open( array( 'method' => 'DELETE', 'url' => '/admin/coursetimeslot/' . $timeslot->id, 'id' => 'deltim_' . $timeslot->id, 'class' => 'timeslot_del_form' ) ) }}
                <a onclick="$('#deltim_{{ $timeslot->id }}').submit()" title="Delete this timeslot."><i class="icon-trash"></i></a>
                {{ Form::token() }}
              {{ Form::close() }}
            </td>
          </tr>
        @endforeach
      @endforeach
    </tbody>
  </table>

</div>
@stop
