<?php
session_start();
require_once('dbh.php');
require_once('checkInput.php');

// check request method
if ($_SERVER['REQUEST_METHOD'] != 'POST' || !isset($_POST['pname']) || !isset($_POST['eid']) || !isset($_POST['duedate'])) {
    header("Location: ../403.html?error=method");
    exit;
}

$csrf_token = checkInput($_POST['csrf_token']);

// check if csrf token is valid
if (!isset($_SESSION['csrf_token']) || !hash_equals($_SESSION['csrf_token'], $csrf_token)) {
    header("Location: ../403.html?error=csrf");
    exit;
}

$pname = checkInput($_POST['pname']);
$eid = checkInput($_POST['eid']);
$subdate = checkInput($_POST['duedate']);

$sql = "INSERT INTO `project`(`eid`, `pname`, `duedate` , `status`) VALUES ('$eid' , '$pname' , '$subdate' , 'Due')";

$result = mysqli_query($conn, $sql);


if (($result) == 1) {
    header("Location: ../assignproject.php");
} else {
    echo ("<SCRIPT LANGUAGE='JavaScript'>
    window.alert('Failed to Assign')
    window.location.href='javascript:history.go(-1)';
    </SCRIPT>");
}
