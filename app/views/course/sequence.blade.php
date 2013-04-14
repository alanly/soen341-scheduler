@extends('course.master')

@section('section_styles')
@stop

@section('section_title')
Course Sequence
@stop

@section('section_content')
<div class="row-fluid">
<p>Your course sequence is dictated by your associated program and option.</p>
</div>

<div class="row-fluid">
  @if( $program->id == 1 )
  <p class="lead">You have not declared a program yet. Please select one in your <a href="/profile">profile</a>.</p>
  @else
  <table id="sequence_table" class="table table-hover tablesorter">
    <thead>
      <tr>
        <th>Course Code</th>
        <th>Course Description</th>
        <th>Progress</th>
      </tr>
    </thead>

    <tbody>
      @foreach( $semesters as $num => $courses )

        <tr>
          <th colspan="3">Semester {{{ $num }}}</th>
        </tr>

        @foreach( $courses as $c )

          <tr{{ $c['completed'] ? ' class="success"' : '' }}>
            <td>{{{ $c['course']->code }}}</td>
            <td>{{{ $c['course']->description }}}</td>
            <td>{{ $c['completed'] ? 'Completed' : 'Incomplete' }}</td>
          </tr>

        @endforeach

      @endforeach
    </tbody>
  </table>
  @endif
</div>
@stop

