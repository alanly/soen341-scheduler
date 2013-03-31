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
        <p class="lead">You have not generated any schedules yet. <a href="/schedule/generate">Would you like to?</a></p>
      @endif
    </article>
  </div>
</div>
@stop
