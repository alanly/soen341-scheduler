@extends('schedule.master')


@section('section_styles')
.course-block {
  background-color: #f9f9f9;
  font-weight: 600;
}
@stop


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
  <table class="table table-bordered table-hover table-condensed">

    <thead>
      <tr>
        <th>Time</th><th>Sunday</th><th>Monday</th><th>Tuesday</th><th>Wednesday</th><th>Thursday</th><th>Friday</th><th>Saturday</th>
      </tr>
    </thead>

    <tbody>
      <?php
        $beginTime['hour'] = (strlen($earliest) == 5) ? substr($earliest, 0, 2) : substr($earliest, 0, 1);
        $beginTime['minute'] = (strlen($earliest) == 5) ? substr($earliest, 3, 2) : substr($earliest, 2, 2);
        $endTime['hour'] = (strlen($latest) == 5) ? substr($latest, 0, 2) : substr($latest, 0, 1);
        $endTime['minute'] = (strlen($latest) == 5) ? substr($latest, 3, 2) : substr($latest, 2, 2);
        $hour = $beginTime['hour'];
        $minute = 0;
        $counter = $beginTime['minute'] / 15;
        $totalRows = round(((($endTime['hour'] * 60) + $endTime['minute']) - (($beginTime['hour'] * 60) + $beginTime['minute'])) / 15);

        $colSkipForRows = array();

        for ($i = 0; $i < $totalRows; $i++) {
          $minute = $counter * 15;
          $time = $hour . ':' . ($minute== 0? "00" : $minute);

          echo "<tr>";
          echo "<th>$time</th>";

          for( $d = 0; $d < 7; $d++ )
          {

            $day = $days[$d];

            if( isset($day[$time]) ) {
              $slot = $day[$time];
              $to_time = strtotime($slot->start_time);
              $from_time = strtotime($slot->end_time);
	      $rows = round(round(abs($to_time - $from_time) / 60)/15);

              for( $r = 0; $r < $rows; $r++)
                if( isset($colSkipForRows[$d][$i + $r]) )
                  $colSkipForRows[$d][$i + $r]++;
                else
                  $colSkipForRows[$d][$i + $r] = 1;

              echo '<td class="course-block" rowspan="' . $rows . '"><a href="/course/details/' . $slot->course_id . '" target="_blank">' . $slot->course()->first()->code . '</a><br>' . $slot->course()->first()->description . '<br>' . $slot->type . ' ' . $slot->code . '</td>';

              $day['no_print_rows'] = $rows - 1;
//            } else if( isset($day['no_print_rows']) && $day['no_print_rows'] > 0  ) {
  //            $day['no_print_rows']--;
            } else {
              if( isset($colSkipForRows[$d][$i]) && $colSkipForRows[$d][$i] != 0 )
                $colSkipForRows[$d][$i]--;
              else
                echo "<td></td>";
            }

          }

          echo "</tr>";

          $counter++;

          if($counter == 4) {
            $counter = 0;
            $hour++;
          }
        }
      ?>
    </tbody>
  </table>
</div>
@stop
