@extends('course.master')

@section('section_title')
Course Details
@stop

@section('section_content')
<div class="row-fluid">

  <dl class="dl-horizontal">
    <dt>Course Code</dt>
    <dd>{{{ $course->code }}}</dd>

    <dt>Course Description</dt>
    <dd>{{{ $course->description }}}</dd>
  </dl>

</div>

<div class="row-fluid">

  <header class="page-header">
    <h2>Course Timeslots</h2>
  </header>

  <table class="table table-hover">

    <thead>
      <tr>
        <th>Type</th><th>Code</th><th>Day</th><th>Time</th><th>Location</th><th>Instructor</th>
      </tr>
    </thead>

    <tbody>
      @if( $courseSections->count() == 0 )
        <tr><td colspan="6"><p class="muted text-center">There are currently no sections for this course.</p></td></tr>
      @endif

      @foreach( $courseSections->orderBy('code')->get() as $section )
        <tr class="info"><td colspan="6">Section {{{ $section->code }}}</td></tr>

        @if( $section->courseTimeslots()->count() == 0 )
        <tr><td colspan="6"><p class="muted text-center">There are currently no timeslots for this section.</p></td></tr>
        @endif
        @foreach( $section->courseTimeslots()->orderBy('code')->get() as $timeslot )
        <tr>
          <td>{{{ $timeslot->type }}}</td>
          <td>{{{ $timeslot->code }}}</td>
          <td>{{{ $timeslot->day }}}</td>
          <td>{{{ $timeslot->start_time }}} &mdash; {{{ $timeslot->end_time }}}</td>
          <td>{{{ $timeslot->location }}}</td>
          <td>{{{ $timeslot->instructor }}}</td>
        </tr>
        @endforeach
      @endforeach
    </tbody>

  </table>

</div>
@stop

