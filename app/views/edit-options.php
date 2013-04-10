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
			<table class="table table-hover">
				<thead>
					<th>Option Name</th>
					<th>Program Name</th>
					<th>Courses</th>
				</thead>
				<tr>
					<td><?php echo $option->description; ?></td>
					<td><?php echo $option->description; ?></td>
					<td><?php echo $option->description; ?></td>
				<tr>
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

