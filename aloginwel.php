<?php
require_once('process/dbh.php');
$sql = "SELECT id, firstName, lastName, points FROM employee, `rank` WHERE `rank`.eid = employee.id order by `rank`.points desc";
$result = mysqli_query($conn, $sql);
?>

<html>

<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta http-equiv="Content-Security-Policy" content="
		default-src 'self' https://fonts.googleapis.com; 
		font-src 'self' https://fonts.gstatic.com;">
	<title>Admin Panel | XYZ Corporation</title>
	<link rel="stylesheet" type="text/css" href="styleemplogin.css">
</head>

<body>

	<header>
		<nav>
			<h1>XYZ Corp.</h1>
			<ul id="navli">
				<li><a class="homered" href="aloginwel.php">HOME</a></li>
				<li><a class="homeblack" href="addemp.php">Add Employee</a></li>
				<li><a class="homeblack" href="viewemp.php">View Employee</a></li>
				<li><a class="homeblack" href="assign.php">Assign Project</a></li>
				<li><a class="homeblack" href="assignproject.php">Project Status</a></li>
				<li><a class="homeblack" href="salaryemp.php">Salary Table</a></li>
				<li><a class="homeblack" href="empleave.php">Employee Leave</a></li>
				<li><a class="homeblack" href="alogin.php">Log Out</a></li>
			</ul>
		</nav>
	</header>

	<div class="divider"></div>
	<div id="divimg">
		<h2>Empolyee Leaderboard </h2>
		<table>
			<tr>
				<th>Seq.</th>
				<th>Emp. ID</th>
				<th>Name</th>
				<th>Points</th>
			</tr>

			<?php
			$seq = 1;
			while ($employee = mysqli_fetch_assoc($result)) {
				echo "<tr>";
				echo "<td>" . $seq . "</td>";
				echo "<td>" . $employee['id'] . "</td>";

				echo "<td>" . $employee['firstName'] . " " . $employee['lastName'] . "</td>";

				echo "<td>" . $employee['points'] . "</td>";

				$seq += 1;
			}

			?>

		</table>

		<div class="p-t-20">
			<button class="btn btn--radius btn--green fr mr-60" type="submit">
				<a href="reset.php"> Reset Points</a>
			</button>
		</div>

	</div>
</body>

</html>