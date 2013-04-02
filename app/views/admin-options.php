<!DOCTYPE html>
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
                                  <li><a href="users">Users</a></li>
                                  <li><a href="programs">Programs</a></li>
                                  <li class="active"><a href="#">Options</a></li>
				  <li><a href="courses">Courses</a></li>
                        </ul>
                </div>
                <div class="span10">
                        <div class="row-fluid">
                         <table class="table table-hover">
                                <thead>
                                        <th>Option Description</th>
                                        <th>edit</th>
                                        <th>Remove</th>
                                </thead>
				<?php $options = ProgramOption::all(); 
					foreach($options as $option){
				?>
                                <tr class="success">
                                        <td><?php echo $option->description . " ID: $option->program_id"; ?></td>
                                        <td><a class="btn" href="options/<?php echo $option->id; ?>/edit">Edit</a></td>
					<form method="post" action="options/<?php echo $option->id; ?>">
						<input type="hidden" name="_method" value="DELETE">	                                       
						<td><input type="submit" name="remove" class="btn" value="Remove"></td>
					</form>
                                </tr>
				<?php } ?>
                        </table>
                        </div>
                        <div class="row-fluid">
                                <div class="well">
                                        <h4 class="muted">Add option</h4>
					<form action="options/create" method="GET">
                                          <table class="table table-hover">
		                                <thead>
	        	                                <th>Option Name</th>
	                	                        <th>Program</th>
							<th>Courses</th>
	                                	</thead>
						<tr>
							<td><input type="text" name="description" value="P.E.E"/></td>
							<td><select name ="program">
								<?php $programs = Program::all();
								foreach($programs as $program){
								 ?>
								<option value="<?php echo $program->id; ?>" ><?php echo $program->description;?></option>
								<?php } ?>
							</select></td>
							<td><select name="course[]" multiple size="10">
								<?php $courses = Course::all();
								foreach($courses as $course){ ?>
								<option value="<?php echo $course->id; ?>"><?php echo $course->description;?></option>
								<?php }?>
							</select></td>
						</tr>
					</table>
					<input class="btn" type="submit" name="submit" value="add">
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
