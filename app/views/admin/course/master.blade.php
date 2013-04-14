@extends('admin.master')


@section('section_title')
Course Management
@stop


@section('section_nav_list')
  <li class="divider"></li>
  <li class="nav-header">Courses</li>
  <li{{ Request::is('admin/course?') ? ' class="active"' : '' }}><a href="/admin/course">List Courses</a></li>
  <li{{ Request::is('admin/course/create?') ? ' class="active"' : '' }}><a href="/admin/course/create">New Course</a></li>
@stop


@section('section_content')
  @if( Session::has('action_message') )
  <div class="alert alert-block {{ Session::get('action_success') ? 'alert-success' : 'alert-error' }}">
    {{ Session::get('action_message') }}
  </div>
  @endif

  @yield('subsection_content')
  
  @if( ! Request::is('admin/course?') )
  <hr>
  <div class="row-fluid">
    <a href="/admin/course"><i class="icon-double-angle-left"></i> Return to Course List</a>
  </div>
  @endif
@stop
