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
				  <li class="active"><a href="#">Users</a></li>
				  <li><a href="programs">Programs</a></li>
				  <li><a href="options">Options</a></li>
  				  <li><a href="courses">Courses</a></li>
			</ul>
		</div>
		<?php
		//getting all users
		$users = User::all();
		?>

		<div class="span10">
			 <table class="table table-hover">
                                <thead>
                                        <th>Email</th>
                                        <th>Name</th>
                                        <th>Remove</th>
                                </thead>
			<?php foreach($users as $user){ ?>
                                <tr>
                                        <td><?php echo $user->email; ?></td>
                                        <td><?php echo $user->name; ?></td>
                                	<form action="users/<?php echo $user->id; ?>" method="post"> 
					<input type="hidden" name="_method" value="DELETE">
				        <td><input type="submit" name="submit"  class="btn" value="Remove"></td>
					</form>
                                </tr>
			<?php }//end foreach loop ?>
                        </table>

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

