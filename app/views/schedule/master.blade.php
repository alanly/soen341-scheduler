@extends('layouts.master')

@section('page_styles')
  @yield('section_styles')
@stop

@section('page_title')
Schedules
@stop

@section('page_content')
<div class="row-fluid">
  <div class="span2">
    <ul class="nav nav-list well">
      <li class="nav-header">Schedules</li>
      <li{{ Request::is('schedule?') ? ' class="active"' : '' }}><a href="/schedule">List Schedules</a></li>
      <li{{ Request::is('schedule/create*') ? ' class="active"' : '' }}><a href="/schedule/create">Generate a Schedule</a></li>
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
