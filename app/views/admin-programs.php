<?php 
if(ISSET($_POST["submit"])){	
DB::table('programs')->insert(array('description' => $_POST["name"]));
}
?><!DOCTYPE html>
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
                                  <li class="active"><a href="#">Programs</a></li>
                                  <li><a href="options">Options</a></li>
				<li><a href="courses">Courses</a></li>
                        </ul>
                </div>
                <div class="span10">
			<div class="row-fluid">
                         <table class="table table-hover">
                                <thead>
                                        <th>Program Description</th>
                                        <th>edit</th>
                                        <th>Remove</th>
                                </thead>
				<?php $programs = Program::all();
				foreach($programs as $program){
				?>
                                <tr class="success">
                                        <td><?php echo $program->description; ?></td>
                                        <td><a class="btn" href="#">Edit</a></td>
                                        <td><a class="btn" href="#">Remove</a></td>
                                </tr>
			<?php } ?>
                        </table>
			</div>
			<div class="row-fluid">
				<div class="well">
					<h4 class="muted">Add program</h4>
					<table class="table table-hover">
                                                <thead>
                                                        <th>Program Name</th>
                                                </thead>
                                                <tr>
							<form action="" id="add" method="post">                          
				                              <td><input type="text" name="name" value="Theoretical Phys-ed"/></td>
                                	                      <td><input type="submit" class="btn" name="submit" value="Add"/></td>
							</form>
                                                </tr>
                                        </table>
	
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
