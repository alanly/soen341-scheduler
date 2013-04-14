@extends('admin.master')


@section('section_title')
School Session Management
@stop


@section('section_nav_list')
  <li class="divider"></li>
  <li class="nav-header">School Sessions</li>
  <li{{ Request::is('admin/session?') ? ' class="active"' : '' }}><a href="/admin/session">List School Sessions</a></li>
@stop


@section('section_content')
  @if( Session::has('action_message') )
  <div class="alert alert-block {{ Session::get('action_success') ? 'alert-success' : 'alert-error' }}">
    {{ Session::get('action_message') }}
  </div>
  @endif

  @yield('subsection_content')
  
  @if( ! Request::is('admin/session?') )
  <hr>
  <div class="row-fluid">
    <a href="/admin/session"><i class="icon-double-angle-left"></i> Return to School Session List</a>
  </div>
  @endif
@stop
