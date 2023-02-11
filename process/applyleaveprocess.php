<?php
//including the database connection file
require_once ('dbh.php');
require_once('checkInput.php');

// check request method
if ($_SERVER['REQUEST_METHOD'] != 'POST' || !isset($_POST['mailuid']) || !isset($_POST['pwd']) || !isset($_POST['csrf_token'])) {
    header("Location: ../403.html?error=method");
    exit;
}

$csrf_token = checkInput($_POST['csrf_token']);

// check if csrf token is valid
if (!isset($_SESSION['csrf_token']) || !hash_equals($_SESSION['csrf_token'], $csrf_token)) {
    header("Location: ../403.html?error=csrf");
    exit;
}

//getting id of the data from url
$id = checkInput($_GET['id']);
//echo $id;
$reason = checkInput($_POST['reason']);

$start = checkInput($_POST['start']);
//echo "$reason";
$end = checkInput($_POST['end']);

$sql = "INSERT INTO `employee_leave`(`id`,`token`, `start`, `end`, `reason`, `status`) VALUES ('$id','','$start','$end','$reason','Pending')";

$result = mysqli_query($conn, $sql);

//redirecting to the display page (index.php in our case)
header("Location:../eloginwel.php?id=$id");
