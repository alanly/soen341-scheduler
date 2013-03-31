@extends('course.master')

@section('section_styles')
@stop

@section('section_title')
Search Courses
@stop

@section('section_content')
<div class="row-fluid">
  <div id="search-form" class="span6 offset3">
    {{ Form::open(array('class' => 'form-search')) }}
      <div class="input-append">
        <input type="text" id="query" name="query" class="input-xxlarge search-query" placeholder="i.e. calculus, engr, intro, comp232, etc." value="{{ Input::old('query') }}">
        <button type="submit" class="btn btn-primary"><i class="icon-search"></i></button>
      </div>
      {{ Form::token() }}
    {{ Form::close() }}
  </div>
</div>

@if( Session::has('search_results') )
  <table class="table table-hover">
    <tbody>
      @foreach( Session::get('search_results') as $course )
        <tr>
          <td>{{{ $course->code }}}</td><td>{{{ $course->description }}}</td>
        </tr>
      @endforeach 
    </tbody>
  </table>
@endif
@stop
