@extends('schedule.master')


@section('section_title')
Generate a Schedule
@stop


@section('section_content')
<div class="row-fluid">
  <div class="span6">
    <p class="lead">Previewing Schedule for {{{ $currentSchoolSession->code }}}.</p>
  </div>
  <div class="span6">
    {{ Form::open(array('url' => '/schedule/save', 'class' => 'pull-right')) }}
      <button type="submit" class="btn btn-primary"><i class="icon-save"></i> Save This Schedule</button>
      {{ Form::token() }}
    {{ Form::close() }}
  </div>
</div>

<div class="row-fluid">
  <table class="table table-bordered">
    <thead>
      <tr>
        <th>Time</th><th>Sunday</th><th>Monday</th><th>Tuesday</th><th>Wednesday</th><th>Thursday</th><th>Friday</th><th>Saturday</th>
      </tr>
    </thead>

    <?php

      $earliest = array(
        'hour' => substr($earliestTime, 0, (strlen($earliestTime) == 5 ? 2 : 1)),
        'minute' => substr($earliestTime, (strlen($earliestTime) == 5 ? 3 : 2), 2)
      );

      $latest = array(
        'hour' => substr($latestTime, 0, (strlen($latestTime) == 5 ? 2 : 1)),
        'minute' => substr($latestTime, (strlen($latestTime) == 5 ? 3 : 2), 2)
      );

      $hour = $earliest['hour'];
      $minute = 0;
      $counter = $earliest['minute'] / 15;
      $totalRows = ((($latest['hour'] * 60) + $latest['minute']) - (($earliest['hour'] * 60) + $earliest['minute'])) / 15;

    ?>

    <tbody>

      @for( $i = 0; $i < $totalRows; $i++ )

        <?php 
          $minute = $counter * 15;
          $time = $hour . ':' . sprintf('%02d', $minute);
         ?>

        <tr>
          <th>{{{ $time }}}</th>
          
          @foreach( $days as $day )
            @if( isset($day[$time]) )
              
            @endif
          @endforeach
        </tr>

      @endfor
      
    </tbody>
  </table>
</div>
@stop
