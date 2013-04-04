@extends('layouts.master')

@section('page_styles')
  @yield('section_styles')
@stop

@section('page_title')
Courses
@stop

@section('page_content')
<div class="row-fluid">
  <div class="span2">
    <ul class="nav nav-list well">
      <li class="nav-header">Courses</li>
      <li{{ Request::is('course/search*') ? ' class="active"' : '' }}><a href="/course/search">Search Courses</a></li>
      <li{{ Request::is('course/list*') ? ' class="active"' : '' }}><a href="/course/list">List Courses</a></li>
    </ul>
  </div>

  <div class="span10">
    <header class="page-header">
      <h2>@yield('section_title')</h2>
    </header>

    @yield('section_content')
  </div>
</div>
@stop
