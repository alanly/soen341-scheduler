@extends('course.master')

@section('section_styles')
#search-form {
  margin-bottom: 20px;
}
#result_table th {
  cursor: pointer;
}
@stop

@section('section_title')
Search Courses
@stop

@section('section_content')
<div class="row-fluid">
  <div id="search-form" class="span6 offset3">
    <form class="form-search" method="get">
      <div class="input-append">
        <input type="text" id="query" name="query" class="input-xxlarge search-query" placeholder="i.e. calculus, engr, intro, comp232, etc." value="{{ Input::get('query') }}">
        <button type="submit" class="btn btn-primary"><i class="icon-search"></i></button>
      </div>
    </form>
  </div>
</div>

@if( Input::has('query') )
<div class="row-fluid">
  <table id="result_table" class="table table-hover tablesorter">
    <thead>
      <tr>
        <th>Course Code</th>
        <th>Course Description</th>
      </tr>
    </thead>

    <tbody>
      @if( Session::has('search_results') )
        @foreach( Session::get('search_results') as $course )
          <tr>
            <td><a href="/course/details/{{ $course->id }}">{{{ $course->code }}}</a></td><td>{{{ $course->description }}}</td>
          </tr>
        @endforeach
      @else
        <tr>
          <td colspan="2"><p class="muted text-center">No results available for &ldquo;{{{ Input::get('query') }}}&rdquo;.</p></td>
        </tr>
      @endif
    </tbody>
  </table>
</div>
@endif
@stop

@if( Session::has('search_results') )
  @section('page_scripts')
    <script src="//cdn.jsdelivr.net/tablesorter/2.0.5b/jquery.tablesorter.min.js"></script>
    <script>
      $(document).ready(function() {
        $('#result_table').tablesorter();
      });
    </script>
  @stop
@endif
