@extends('admin.master')


@section('section_title')
Program Management
@stop


@section('section_nav_list')
  <li class="divider"></li>
  <li class="nav-header">Programs</li>
  <li{{ Request::is('admin/program?') ? ' class="active"' : '' }}><a href="/admin/program">List Programs</a></li>
  <li{{ Request::is('admin/program/create?') ? ' class="active"' : '' }}><a href="/admin/program/create">New Program</a></li>
@stop


@section('section_content')
  @if( Session::has('action_message') )
  <div class="alert alert-block {{ Session::get('action_success') ? 'alert-success' : 'alert-error' }}">
    {{{ Session::get('action_message') }}}
  </div>
  @endif

  @yield('subsection_content')
  
  @if( ! Request::is('admin/program?') )
  <hr>
  <div class="row-fluid">
    <a href="/admin/program"><i class="icon-double-angle-left"></i> Return to Program List</a>
  </div>
  @endif
@stop
