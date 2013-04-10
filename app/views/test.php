<!DOCTYPE html>
<html>
<head>
<link rel="stylesheet" type="text/css"
	href="//cdn.jsdelivr.net/bootstrap/2.3.1/css/bootstrap.min.css">
<style type="text/css">
.modal-body {
	overflow: auto;
}

.modal {
	width: 700px;
	margin-left: -350px;
	max-height: 600px;
	overflow: auto;
}

.schedule-view {
	margin-bottom: 0;
}

.schedule-view td,.schedule-view th {
	line-height: 10px;
	text-align: center;
	vertical-align: middle;
}

.course-block {
	background-color: #dff0d8 !important;
	line-height: 20px !important;
}

.bold {
	font-weight: bold;
}
</style>
</head>
<body>
	<div class="container">
		<header class="row-fluid">
			<h1 class="muted">Schedules</h1>
			<hr>
		</header>
		<div class="row">
			<div class="span2">
				<ul class="nav nav-list">
					<li class="nav-header">Header</li>
					<li><a href="users">Users</a></li>
					<li><a href="programs">Programs</a></li>
					<li><a href="options">Options</a></li>
					<li class="active"><a href="courses">Courses</a></li>
				</ul>
			</div>
			<div class="span10">
				<div class="row-fluid">
					<table class="table table-hover">
						<thead>
							<th>Code</th>
							<th>Description</th>
							<th>Sections</th>
							<th>TimeSlot</th>
							<th>Remove</th>
						</thead>
						<?php $courses = Course::all();
						foreach($courses as $course){
							?>
						<tr class="success">
							<td><?php echo $course->code; ?></td>
							<td><?php echo $course->description; ?></td>
							<td><select class="input-small">
									<?php $sections = DB::table('course_sections')->where('course_id','=',$course->id)->get();
									foreach($sections as $section){
										?>
									<option value="<?php echo $section->id; ?>">
										<?php echo $section->code;?>
									</option>
									<?php
									}
									?>
							</select></td>
							<td><a class="btn" href="courses/<?php echo $course->id; ?>/edit">View</a>
							</td>
							<form action="courses/<?php echo $course->id; ?>" method="POST">
								<input type="hidden" name="_method" value="DELETE"> <input
									type="hidden" name="action" value="course">
								<td><input type="submit" name="remove" value="remove"
									class="btn"></td>
							</form>
						</tr>
						<?php } ?>
					</table>
				</div>
				<div class="row-fluid">
					<div class="well">
						<h4 class="muted">Add course</h4>
						<table class="table table-hover">
							<thead>
								<th>Code</th>
								<th>Description</th>
								<th>Section Code</th>
							</thead>
							<tr>
								<form action="courses/create" method="GET">
									<td><input type="text" name="code" value="Greendale" /></td>
									<td><input type="text" name="description"
										value="Theoretical Phys-ed" /></td>
									<td><input class="input-small" type="text" name="section"
										value="NN" /></td>
									<td><input type="submit" name="submit" class="btn" value="Add" />
									</td>
								</form>
							</tr>
						</table>

					</div>
				</div>

			</div>

		</div>
		<?php
		$courses = $course::all();
		//algorithm to get the best possible timeslots
			
		$timeslots = CourseTimeslot::all();
		$sunday = array();
		$monday = array();
		$tuesday = array();
		$wednesday = array();
		$thursday = array();
		$friday = array();
		$saturday = array();
		
		$earliestTime = '24:00';
		$latestTime = '0:00';
		
		foreach($timeslots as $time){
			// Find the earliest and lastest times for the schedule
			if (strtotime($time->start_time) < strtotime($earliestTime)) {
				$earliestTime = $time->start_time;
			}
			if (strtotime($time->end_time) > strtotime($latestTime)) {
				$latestTime = $time->end_time;
			}
			
			switch($time->day){
				case 0:
					$sunday[strtotime($time->start_time)] = $time;
					break;
				case 1:
					$monday[strtotime($time->start_time)] = $time;
					break;
				case 2:
					$tuesday[strtotime($time->start_time)] = $time;
					break;
				case 3:
					$wednesday[strtotime($time->start_time)] = $time;
					break;
				case 4:
					$thursday[strtotime($time->start_time)] = $time;
					break;
				case 5:
					$friday[strtotime($time->start_time)] = $time;
					break;
				case 6:
					$saturday[strtotime($time->start_time)] = $time;
					break;
			}

		}

		echo "Displaying Schedule <br>";

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
		echo 'total rows:' .$totalRows;
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
		<br>
		<footer class="row-fluid">
			<hr>
			<p class="muted pull-left">copyright 2013 DOLLA DOLLA BILL Y'ALL
				Productions</p>
			<p class="muted pull-right">
				<a href="#">Profile</a> <a href="#">Logout</a>
			</p>
		</footer>
	</div>
</body>
</html>

