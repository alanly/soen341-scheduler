<!DOCTYPE html>
<html>
<head>
        <link rel="stylesheet" type="text/css" href="//cdn.jsdelivr.net/bootstrap/2.3.1/css/bootstrap.min.css">
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
							<option value="<?php echo $section->id; ?>"><?php echo $section->code;?></option>
						<?php
						}
						?>
					</select></td>
					<td><a class="btn" href="courses/<?php echo $course->id; ?>/edit">View</a></td>
					<form action="courses/<?php echo $course->id; ?>" method="POST">
						<input type="hidden" name="_method" value="DELETE">
						<input type="hidden" name="action" value="course">
	                                        <td><input type="submit" name="remove" value="remove" class="btn"></td>
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
								<td><input type="text" name="code" value="Greendale"/></td> 
	                                                        <td><input type="text" name="description" value="Theoretical Phys-ed"/></td>
								<td><input class="input-small" type="text" name="section" value="NN"/></td>
        	                                                <td><input type="submit" name="submit" class="btn" value="Add"/></td>
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
	foreach($timeslots as $time){
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

echo "<table border=1>";
echo "<tr><td>Time</td><td>Sunday</td><td>Monday</td><td>Tuesday</td><td>Wednesday</td><td>Thursday</td><td>Friday</td><td>Saturday</td></tr>";
$hour = 0;
$minute = 0;
$counter = 0;
for($i = 0; $i<96; $i++){
	$minute = $counter * 15;
	$time = "$hour:" . ($minute== 0? "00":$minute);
	echo "<tr id='$time'>";
	echo "<td>$time</td>";
	if(ISSET($sunday[strtotime($time)])){
		$obj = $sunday[strtotime($time)];
		$to_time = strtotime($obj->start_time);
		$from_time = strtotime($obj->end_time);
		$rows = round(abs($to_time - $from_time) / 60,2)/15;		
		echo "<td rowspan='$rows' bgcolor='#FFFFFF'>$obj->type</td>";
	}else{
		echo "<td></td>";
	}
	 if(ISSET($monday[strtotime($time)])){
                $obj = $monday[strtotime($time)];
                $to_time = strtotime($obj->start_time);
                $from_time = strtotime($obj->end_time);
                $rows = round(abs($to_time - $from_time) / 60,2)/15;
        	echo "<td rowspan='$rows' bgcolor='#FFFFFF'>$obj->type</td>";
	}else{
                echo "<td></td>";
        }
	 if(ISSET($tuesday[strtotime($time)])){
                $obj = $tuesday[strtotime($time)];
                $to_time = strtotime($obj->start_time);
                $from_time = strtotime($obj->end_time);
                $rows = round(abs($to_time - $from_time) / 60,2)/15;
        	echo "<td rowspan='$rows' bgcolor='#FFFFFF'>$obj->type</td>";

	}else{
                echo "<td></td>";
        }
	 if(ISSET($wednesday[strtotime($time)])){
                $obj = $wednesday[strtotime($time)];
                $to_time = strtotime($obj->start_time);
                $from_time = strtotime($obj->end_time);
                $rows = round(abs($to_time - $from_time) / 60,2)/15;
		echo "<td rowspan='$rows' bgcolor='#FFFFFF'>$obj->type</td>";
        }else{
                echo "<td></td>";
        }
	 if(ISSET($thursday[strtotime($time)])){
                $obj = $thursday[strtotime($time)];
                $to_time = strtotime($obj->start_time);
                $from_time = strtotime($obj->end_time);
                $rows = round(abs($to_time - $from_time) / 60,2)/15;
        	echo "<td rowspan='$rows' bgcolor='#FFFFFF'>$obj->type</td>";
	}else{
                echo "<td></td>";
        }
	 if(ISSET($friday[strtotime($time)])){
                $obj = $friday[strtotime($time)];
                $to_time = strtotime($obj->start_time);
                $from_time = strtotime($obj->end_time);
                $rows = round(abs($to_time - $from_time) / 60,2)/15;
                echo "<td rowspan='$rows' bgcolor='#FFFFFF'>$obj->type</td>";
        }else{
                echo "<td></td>";
        }
	 if(ISSET($saturday[strtotime($time)])){
                $obj = $saturday[strtotime($time)];
                $to_time = strtotime($obj->start_time);
                $from_time = strtotime($obj->end_time);
                $rows = round(abs($to_time - $from_time) / 60,2)/15;
                echo "<td rowspan='$rows' bgcolor='#FFFFFF'>$obj->type</td>";
        }else{
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
        <p class="muted pull-left">copyright 2013  DOLLA DOLLA BILL Y'ALL Productions</p>
        <p class="muted pull-right"><a href="#">Profile</a> <a href="#">Logout</a></p>
</footer>
</div>
</body>
</html>
