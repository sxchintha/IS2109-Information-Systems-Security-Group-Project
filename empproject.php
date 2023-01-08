<?php
session_start();
require_once('process/userLoginCheck.php');
require_once('process/dbh.php');

$id = $_SESSION['empid'];
$sql = "SELECT * FROM `project` where eid = '$id'";
$result = mysqli_query($conn, $sql);

?>

<html>

<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta http-equiv="Content-Security-Policy" content="
		default-src 'self' https://fonts.googleapis.com; 
		font-src 'self' https://fonts.gstatic.com;">
	<title>Employee Panel | XYZ Corporation</title>
	<link rel="stylesheet" type="text/css" href="styleview.css">
</head>

<body>

	<header>
		<nav>
			<h1>XYZ Corp.</h1>
			<ul id="navli">
				<li><a class="homeblack" href="eloginwel.php">HOME</a></li>
				<li><a class="homeblack" href="myprofile.php">My Profile</a></li>
				<li><a class="homered" href="empproject.php">My Projects</a></li>
				<li><a class="homeblack" href="applyleave.php">Apply Leave</a></li>
				<li><a class="homeblack" href="elogin.php">Log Out</a></li>
			</ul>
		</nav>
	</header>

	<div class="divider"></div>
	<div id="divimg">
		<table>
			<tr>
				<th>Project ID</th>
				<th>Project Name</th>
				<th>Due Date</th>
				<th>Sub Date</th>
				<th>Mark</th>
				<th>Status</th>
				<th>Option</th>
			</tr>

			<?php
			while ($employee = mysqli_fetch_assoc($result)) {

				echo "<tr>";
				echo "<td>" . $employee['pid'] . "</td>";
				echo "<td>" . $employee['pname'] . "</td>";
				echo "<td>" . $employee['duedate'] . "</td>";
				echo "<td>" . $employee['subdate'] . "</td>";
				echo "<td>" . $employee['mark'] . "</td>";
				echo "<td>" . $employee['status'] . "</td>";

				echo "<td><a href=\"psubmit.php?pid=$employee[pid]&id=$employee[eid]\">Submit</a>";
			}

			?>

		</table>

</body>

</html>