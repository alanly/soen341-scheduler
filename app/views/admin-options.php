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
                                        <td><?php echo $option->descripton; ?></td>
                                        <td><a class="btn" href="#">Edit</a></td>
                                        <td><a class="btn" href="#">Remove</a></td>
                                </tr>
				<?php } ?>
                        </table>
                        </div>
                        <div class="row-fluid">
                                <div class="well">
                                        <h4 class="muted">Add option</h4>
                                          <table class="table table-hover">
		                                <thead>
	        	                                <th>Option Name</th>
	                	                        <th>Program</th>
							<th>Courses</th>
	                                	</thead>
						<tr>
							<td><input type="text" name="description" value="P.E.E"/></td>
							<td><select>
								<option>FUCK</option>
							</select></td>
							<td><select size="10">
								<option>SOEN 331</option>
							</select></td>
						</tr>
					</table>
					<input class="btn" type="submit" value="add">
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
