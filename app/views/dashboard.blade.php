@extends('layouts.master');

@section('page_title')
Dashboard
@stop

@section('page_content')
<div class="container">
  <div class="row-fluid">
    <article class="hero-unit">
      <h1>Welcome back, {{ Auth::user()->name }}!</h1>
      <br>
      @if( count( Auth::user()->schedules ) == 0 )
        <p class="lead">You have not created any schedules yet. <a href="/schedule/create">Would you like to?</a></p>
      @else
        <p class="lead">You currently have {{{ Auth::user()->schedules()->count() }}} saved schedules.</p>
        <p>Would you like to <a href="/schedule/view/{{ Auth::user()->schedules()->orderBy('id', 'desc')->first()->id }}">view the latest schedule</a> or <a href="/schedule/create">create a new one</a>?</p>
      @endif
    </article>
  </div>
</div>
@stop
