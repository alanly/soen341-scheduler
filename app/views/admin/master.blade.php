@extends('layouts.master')

@section('page_title')
Admin: @yield('section_title')
@stop

@section('page_styles')
@yield('section_styles')
@stop

@section('page_content')
<div class="row-fluid">
  <div class="span2">
    <ul class="nav nav-list well">
      <li class="nav-header">Manage...</li>
      <li{{ Request::is('admin/user*') ? ' class="active"' : '' }}><a href="/admin/user">Users</a></li>
      <li{{ Request::is('admin/session*') ? ' class="active"': '' }}><a href="/admin/session">School Sessions</a></li>
      <li{{ Request::is('admin/program*') ? ' class="active"' : '' }}><a href="/admin/program">Programs</a></li>
      <li{{ Request::is('admin/option*') ? ' class="active"' : '' }}><a href="/admin/option">Program Options</a></li>
      <li{{ Request::is('admin/course*') ? ' class="active"' : '' }}><a href="/admin/course">Courses</a></li>
      @yield('section_nav_list')
    </ul>
    @yield('section_sidebar')
  </div>

  <div class="span10">
    <div class="row-fluid">
      <header class="page-header">
        <h2>@yield('section_title')</h2>
      </header>
    </div>

    @yield('section_content')
  </div>
</div>
@stop

@section('page_scripts')
@yield('section_scripts')
@stop
