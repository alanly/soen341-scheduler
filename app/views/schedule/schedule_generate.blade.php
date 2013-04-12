@extends('schedule.master')


@section('section_title')
Generate a Schedule
@stop
@section('section_content')
<div class="row-fluid">
  {{ Form::open(array(
    'id' => 'generateForm',
    'class' => 'form-horizontal well'
  )) }}
    <fieldset>

<?php

		echo "<table class='schedule-view table table-bordered table-striped'>";
		echo "<tr><td>Time</td><td>Sunday</td><td>Monday</td><td>Tuesday</td><td>Wednesday</td><td>Thursday</td><td>Friday</td><td>Saturday</td></tr>";
		
		$earliest['hour'] = (strlen($earliestTime) == 5) ? substr($earliestTime, 0, 2) : substr($earliestTime, 0, 1);
		$earliest['minute'] = (strlen($earliestTime) == 5) ? substr($earliestTime, 3, 2) : substr($earliestTime, 2, 2);
		$latest['hour'] = (strlen($latestTime) == 5) ? substr($latestTime, 0, 2) : substr($latestTime, 0, 1);
		$latest['minute'] = (strlen($latestTime) == 5) ? substr($latestTime, 3, 2) : substr($latestTime, 2, 2);
		$hour = $earliest['hour'];
		$minute = 0;
		$counter = $earliest['minute'] / 15;
		$totalRows = ((($latest['hour'] * 60) + $latest['minute']) - (($earliest['hour'] * 60) + $earliest['minute'])) / 15;
		for ($i = 0; $i<$totalRows; $i++){
			$minute = $counter * 15;
			$time = "$hour:" . ($minute== 0? "00":$minute);
			echo "<tr id='$time'>";
			echo "<td>$time</td>";
			if (ISSET($sunday[strtotime($time)])) {
				$obj = $sunday[strtotime($time)];
				$to_time = strtotime($obj->start_time);
				$from_time = strtotime($obj->end_time);
				$rows = round(abs($to_time - $from_time) / 60,2)/15;
				echo "<td class='course-block' rowspan='$rows'>$obj->type</td>";
				$sunday['no_print_rows'] = $rows - 1;
			} else if (ISSET($sunday['no_print_rows']) && $sunday['no_print_rows'] > 0) {
				$sunday['no_print_rows']--;
			}
			else {
				echo "<td></td>";
			}
			if (ISSET($monday[strtotime($time)])) {
				$obj = $monday[strtotime($time)];
				$to_time = strtotime($obj->start_time);
				$from_time = strtotime($obj->end_time);
				$rows = round(abs($to_time - $from_time) / 60,2)/15;
				echo "<td class='course-block' rowspan='$rows'>$obj->type</td>";
				$monday['no_print_rows'] = $rows - 1;
			} else if (ISSET($monday['no_print_rows']) && $monday['no_print_rows'] > 0) {
				$monday['no_print_rows']--;
			}
			else {
				echo "<td></td>";
			}
			if (ISSET($tuesday[strtotime($time)])) {
				$obj = $tuesday[strtotime($time)];
				$to_time = strtotime($obj->start_time);
				$from_time = strtotime($obj->end_time);
				$rows = round(abs($to_time - $from_time) / 60,2)/15;
				echo "<td class='course-block' rowspan='$rows'>$obj->type</td>";
				$tuesday['no_print_rows'] = $rows - 1;
			} else if (ISSET($tuesday['no_print_rows']) && $tuesday['no_print_rows'] > 0) {
				$tuesday['no_print_rows']--;
			}
			else {
				echo "<td></td>";
			}
			if (ISSET($wednesday[strtotime($time)])) {
				$obj = $wednesday[strtotime($time)];
				$to_time = strtotime($obj->start_time);
				$from_time = strtotime($obj->end_time);
				$rows = round(abs($to_time - $from_time) / 60,2)/15;
				echo "<td class='course-block' rowspan='$rows'>$obj->type</td>";
				$wednesday['no_print_rows'] = $rows - 1;
			} else if (ISSET($wednesday['no_print_rows']) && $wednesday['no_print_rows'] > 0) {
				$wednesday['no_print_rows']--;
			}
			else {
				echo "<td></td>";
			}
			if (ISSET($thursday[strtotime($time)])) {
				$obj = $thursday[strtotime($time)];
				$to_time = strtotime($obj->start_time);
				$from_time = strtotime($obj->end_time);
				$rows = round(abs($to_time - $from_time) / 60,2)/15;
				echo "<td class='course-block' rowspan='$rows'>$obj->type</td>";
				$thursday['no_print_rows'] = $rows - 1;
			} else if (ISSET($thursday['no_print_rows']) && $thursday['no_print_rows'] > 0) {
				$thursday['no_print_rows']--;
			}
			else {
				echo "<td></td>";
			}
			if (ISSET($friday[strtotime($time)])) {
				$obj = $friday[strtotime($time)];
				$to_time = strtotime($obj->start_time);
				$from_time = strtotime($obj->end_time);
				$rows = round(abs($to_time - $from_time) / 60,2)/15;
				echo "<td class='course-block' rowspan='$rows'>$obj->type</td>";
				$friday['no_print_rows'] = $rows - 1;
			} else if (ISSET($friday['no_print_rows']) && $friday['no_print_rows'] > 0) {
				$friday['no_print_rows']--;
			}
			else {
				echo "<td></td>";
			}
			if (ISSET($saturday[strtotime($time)])) {
				$obj = $saturday[strtotime($time)];
				$to_time = strtotime($obj->start_time);
				$from_time = strtotime($obj->end_time);
				$rows = round(abs($to_time - $from_time) / 60,2)/15;
				echo "<td class='course-block' rowspan='$rows'>$obj->type</td>";
				$saturday['no_print_rows'] = $rows - 1;
			} else if (ISSET($saturday['no_print_rows']) && $saturday['no_print_rows'] > 0) {
				$saturday['no_print_rows']--;
			}
			else {
				echo "<td></td>";
			}

			echo "</tr>";
			$counter++;
			if($counter == 4)
			{
				$counter = 0;
				$hour++;
			}
		}
		echo "</table>";

		?>
</form>
		<form action="/schedule/save" method="POST">
			<input type="submit" class="btn" value="Save Schedule">
			<input type="hidden" name="_token" value="{{ csrf_token() }}">
		</form>
	</fieldset>
</div>
@stop
