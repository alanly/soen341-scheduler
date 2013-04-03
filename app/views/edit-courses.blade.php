<!DoCTYPE html>
<html>
<head>
        <link rel="stylesheet" type="text/css" href="//cdn.jsdelivr.net/bootstrap/2.3.1/css/bootstrap.min.css">
        <script tyle="text/javascript" src="//cdn.jsdelivr.net/jquery/1.9.1/jquery-1.9.1.min.js"></script>
        <script type="text/javascript" src="//cdn.jsdelivr.net/bootstrap/2.3.1/js/bootstrap.min.js"></script>
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
                                  <li><a href="/admin/users">Users</a></li>
                                  <li><a href="/admin/programs">Programs</a></li>
                                  <li><a href="/admin/options">Options</a></li>
                                  <li class="active"><a href="/admin/courses">Courses</a></li>
                        </ul>
                </div>
                <div class="span10">
			<div class="row-fluid">
				<?php 
					if(ISSET($error)){?>
						<label class="alert">
						<?php echo $error; ?>
						</label>	
					<?php } ?>
				<label><?php echo "Sections for Course <b>$course->code -- $course->description </b>"; ?></label>
				<table class="table table-hover">
					<thead>
						<th>Section</th>
						<th>Day</th>
						<th>Start Time</th>
						<th>End Time</th>
						<th>Location</th>
						<th>Instructor</th>
						<th>Remove</th>
					</thead>
				<?php foreach($timeslots as $time){ ?>
					<tr>
						<td>{{{ $time->courseSection()->first()->code }}}</td>
						<td><?php echo $time->day;?></td>
						<td><?php echo $time->start_time;?></td>
						<td><?php echo $time->end_time;?></td>
						<td><?php echo $time->location;?></td>
						<td><?php echo $time->instructor;?></td>
						<td>
							<form action="/admin/courses/{{ $course->id }}" method="post">
								<input type="hidden" name="_method" value="DELETE">
								<input type="hidden" name="action" value="timeslot">
								<input type="hidden" name="timeslot_id" value="<?php echo $time->id; ?>">
								<input type="submit" class="btn" value="Remove">
							</form>
						</td>
					</tr>
				<?php }	?>
				</table>
			</div>
			 <div class="row-fluid">
                                <div class="well">
                                        <h4 class="muted">Add time slot</h4>
					<form action="/admin/courses/{{ $course->id }}" method="POST">
					<input type="hidden" name="_method" value="PUT">
                                        <table class="table table-hover">
                                                <thead>
                                        		<th>Section</th>
					                <th>Days</th>
							<th>Start Time</th>
                                                        <th>End Time</th>
							<th>Location</th>
                                                </thead>
                                                <tr>
							<td>
								<select name="section" class="input-small">
								<?php $sections = CourseSection::all();
								foreach($sections as $section){ ?>
									<option value="<?php echo $section->id; ?>"><?php echo $section->code;?></option>
								<?php } ?>
								</select>
							</td>
                                                        <td> 
								<input type="checkbox" name="days[]" value="0"> Sunday<br>
                                                                <input type="checkbox" name="days[]"  value="1"> Monday<br>
                                                                <input type="checkbox" name="days[]" value="2"> Tuesday<br>
                                                                <input type="checkbox" name="days[]" value="3"> Wednesday<br>
                                                                <input type="checkbox" name="days[]" value="4"> Thursday<br>
                                                                <input type="checkbox" name="days[]" value="5"> Friday<br>
                                                                 <input type="checkbox" name="days[]" value="6"> Saturday<br>
  							</td>
                                                                <td><input type="text" class="input-small" name="start" value="12:45"/></td>
                                                                <td><input type="text" class="input-small" name="end" value="2:00"/></td>
								<td><input type="text" class="input-small" name="location" value="H215"/></td>
                                                </tr>
					</table>
					 <table class="table table-hover">
                                                <thead>
                                                        <th>Instructor</th>
                                                        <th></th>
                                                        <th></th>
                                                        <th></th>
                                                        <th></th>
                                                </thead>
						<tr> 
							<td><input type="text" name="instructor" value="S-man"/></td>
							<td><input type="submit" name="submit" class="btn" value="Add"/></td>
						</tr>
                                        </table>
					</form>
                                </div>
                        </div>
			                	
		</div>
         </div>
<footer class="row-fluid">
        <hr>
        <p class="muted pull-left">copyright 2013  DOLLA DOLLA BILL Y'ALL Productions</p>
        <p class="muted pull-right"><a href="#">Profile</a> <a href="#">Logout</a></p>
</footer>
</div>
</body>
</html>


