@extends('schedule.master')


@section('section_title')
List Schedules
@stop


@section('section_content')
<div class="row-fluid">
  <div class="accordion" id="schedule_list">

    @if( $schedules->count() == 0 )
      <p class="lead text-center muted">You currently have no schedules.</p>
    @endif

    @foreach( $schedules as $schedule )
      <div class="accordion-group">
        <div class="accordion-heading">
          <a class="accordion-toggle" data-toggle="collapse" data-parent="#schedule_list" href="#sched_{{ strtotime($schedule->created_at) }}">
            Schedule {{{ $schedule->id }}} &mdash; {{{ $schedule->created_at }}}
          </a>
        </div>

        <div id="sched_{{ strtotime($schedule->created_at) }}" class="accordion-body collapse">
          <div class="accordion-inner">
            <div class="span6">
              <ul>
                @foreach( $schedule->scheduleTimeslots()->distinct()->get() as $timeslot )
                  <li>{{{ $timeslot->getCourse()->code }}} &mdash; {{{ $timeslot->getCourse()->description }}}: {{{ $timeslot->getCourseTimeslot()->type }}} {{{ $timeslot->getCourseTimeslot()->code }}}</li>
                @endforeach
              </ul>
            </div>

            <div class="span6">
              <a href="/schedule/view/{{ $schedule->id }}" class="btn btn-primary">View Schedule</a>

              {{ Form::open(array(
                  'url' => '/schedule/delete/' . $schedule->id,
                  'method' => 'DELETE'
                )) }}
                <button type="submit" class="btn btn-danger">Delete Schedule</button>
                {{ Form::token() }}
              {{ Form::close() }}
            </div>
          </div>
        </div>
      </div>
    @endforeach
    
  </div>
</div>
@stop
