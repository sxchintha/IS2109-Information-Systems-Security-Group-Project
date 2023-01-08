<?php
session_start();
require_once('process/userLoginCheck.php');
require_once('process/dbh.php');

$id = $_SESSION['empid'];
$sql1 = "SELECT * FROM `employee` where id = '$id'";
$result1 = mysqli_query($conn, $sql1);
$employeen = mysqli_fetch_array($result1);
$empName = ($employeen['firstName']);

$sql = "SELECT id, firstName, lastName,  points FROM employee, `rank` WHERE `rank`.eid = employee.id order by `rank`.points desc";
$sql1 = "SELECT `pname`, `duedate` FROM `project` WHERE eid = $id and status = 'Due'";

$sql2 = "Select * From employee, employee_leave Where employee.id = $id and employee_leave.id = $id order by employee_leave.token";

$sql3 = "SELECT * FROM `salary` WHERE id = $id";

//echo "$sql";
$result = mysqli_query($conn, $sql);
$result1 = mysqli_query($conn, $sql1);
$result2 = mysqli_query($conn, $sql2);
$result3 = mysqli_query($conn, $sql3);
?>

<html>

<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta http-equiv="Content-Security-Policy" content="
		default-src 'self' https://fonts.googleapis.com; 
		font-src 'self' https://fonts.gstatic.com;">
	<title>Employee Panel | XYZ Corporation</title>
	<link rel="stylesheet" type="text/css" href="styleemplogin.css">
	<link href="https://fonts.googleapis.com/css?family=Lobster|Montserrat" rel="stylesheet">
</head>

<body>

	<header>
		<nav>
			<h1>XYZ Corp.</h1>
			<ul id="navli">
				<li><a class="homered" href="eloginwel.php">HOME</a></li>
				<li><a class=" homeblack" href="myprofile.php">My Profile</a></li>
				<li><a class=" homeblack" href="empproject.php">My Projects</a></li>
				<li><a class=" homeblack" href="applyleave.php">Apply Leave</a></li>
				<li><a class=" homeblack" href="elogin.php">Log Out</a></li>
			</ul>
		</nav>
	</header>

	<div class="divider"></div>
	<div id="divimg">
		<div>
			<!-- <h2>Welcome <?php echo "$empName"; ?> </h2> -->

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

			<h2>Due Projects</h2>

			<table>
				<tr>
					<th>Project Name</th>
					<th>Due Date</th>
				</tr>
				<?php
				while ($employee1 = mysqli_fetch_assoc($result1)) {
					echo "<tr>";
					echo "<td>" . $employee1['pname'] . "</td>";
					echo "<td>" . $employee1['duedate'] . "</td>";
				}

				?>

			</table>

			<h2>Salary Status</h2>
			<table>
				<tr>
					<th>Base Salary</th>
					<th>Bonus</th>
					<th>Total Salary</th>
				</tr>

				<?php
				while ($employee = mysqli_fetch_assoc($result3)) {
					echo "<tr>";
					echo "<td>" . $employee['base'] . "</td>";
					echo "<td>" . $employee['bonus'] . " %</td>";
					echo "<td>" . $employee['total'] . "</td>";
				}

				?>

			</table>

			<h2>Leave Satus</h2>
			<table>
				<tr>
					<th>Start Date</th>
					<th>End Date</th>
					<th>Total Days</th>
					<th>Reason</th>
					<th>Status</th>
				</tr>

				<?php
				while ($employee = mysqli_fetch_assoc($result2)) {
					$date1 = new DateTime($employee['start']);
					$date2 = new DateTime($employee['end']);
					$interval = $date1->diff($date2);
					$interval = $date1->diff($date2);

					echo "<tr>";
					echo "<td>" . $employee['start'] . "</td>";
					echo "<td>" . $employee['end'] . "</td>";
					echo "<td>" . $interval->days . "</td>";
					echo "<td>" . $employee['reason'] . "</td>";
					echo "<td>" . $employee['status'] . "</td>";
				}

				?>
			</table>

			<br>
			<br>
			<br>
			<br>
			<br>
		</div>

	</div>
</body>

</html>