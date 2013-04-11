@extends('admin.master')


@section('section_title')
Program Option Management
@stop


@section('section_nav_list')
  <li class="divider"></li>
  <li class="nav-header">Program Options</li>
  <li{{ Request::is('admin/option?') ? ' class="active"' : '' }}><a href="/admin/option">List Program Options</a></li>
  <li{{ Request::is('admin/option/create?') ? ' class="active"' : '' }}><a href="/admin/option/create">New Program Option</a></li>
@stop


@section('section_content')
  @if( Session::has('action_message') )
  <div class="alert alert-block {{ Session::get('action_success') ? 'alert-success' : 'alert-error' }}">
    {{{ Session::get('action_message') }}}
  </div>
  @endif

  @yield('subsection_content')
  
  @if( ! Request::is('admin/option?') )
  <hr>
  <div class="row-fluid">
    <a href="/admin/option"><i class="icon-double-angle-left"></i> Return to Program Option List</a>
  </div>
  @endif
@stop
