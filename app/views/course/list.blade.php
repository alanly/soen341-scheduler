@extends('course.master')

@section('section_styles')
#course_table th {
  cursor: pointer;
}
@stop

@section('section_title')
List Courses
@stop

@section('section_content')
<div class="row-fluid">
  <table id="course_table" class="table table-hover tablesorter">
    <thead>
      <tr>
        <th>Course Code</th>
        <th>Course Description</th>
      </tr>
    </thead>

    <tbody>
      @foreach( $courses as $course )
        <tr>
          <td><a href="/course/details/{{ $course->id }}">{{{ $course->code }}}</a></td><td>{{{ $course->description }}}</td>
        </tr>
      @endforeach 
    </tbody>
  </table>
</div>
@stop

@section('page_scripts')
  <script src="//cdn.jsdelivr.net/tablesorter/2.0.5b/jquery.tablesorter.min.js"></script>
  <script>
    $(document).ready(function() {
      $('#course_table').tablesorter();
    });
  </script>
@stop
