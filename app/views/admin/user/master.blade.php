@extends('admin.master')


@section('section_title')
User Management
@stop


@section('section_nav_list')
  <li class="divider"></li>
  <li class="nav-header">Users</li>
  <li{{ Request::is('admin/user?') ? ' class="active"' : '' }}><a href="/admin/user">List Users</a></li>
@stop


@section('section_content')
  @if( Session::has('action_message') )
  <div class="alert alert-block {{ Session::get('action_success') ? 'alert-success' : 'alert-error' }}">
    {{{ Session::get('action_message') }}}
  </div>
  @endif

  @yield('subsection_content')
  
  @if( ! Request::is('admin/user?') )
  <hr>
  <div class="row-fluid">
    <a href="/admin/user"><i class="icon-double-angle-left"></i> Return to User List</a>
  </div>
  @endif
@stop
