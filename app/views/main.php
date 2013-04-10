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
		<div class="span6">	
			<div id="schedules">
				<ul>
					<li><a href="#">Sched 1</a><a class="pull-right"href="#">X</a></li>
                                        <li><a href="#">Sched 1</a><a class="pull-right"href="#">X</a></li>				
                                        <li><a href="#">Sched 1</a><a class="pull-right"href="#">X</a></li>

				</ul>
			</div>
		</div>
		<div class="span6">
			<div id="options">
				<button>Create Sched</button><br>
				<button>View Acedemic Record</button><br>
			</div>
		</div>
	</div>
<p><?php
$to_time = strtotime("13:45");
$from_time = strtotime("10:00");
$minutes = round(abs($to_time - $from_time) / 60,2);
echo "rows = " . $minutes /15;
?>
 </p>
<footer class="row-fluid">
	<hr>
	<p class="muted pull-left">copyright 2013  DOLLA DOLLA BILL Y'ALL Productions</p>
	<p class="muted pull-right"><a href="#">Profile</a> <a href="#">Logout</a></p>
</footer>
</div>
</body>
</html>
