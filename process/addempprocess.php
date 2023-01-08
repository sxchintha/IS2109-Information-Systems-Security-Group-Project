<?php
session_start();
require_once('dbh.php');
require_once('checkInput.php');

// check request method
if (
    $_SERVER['REQUEST_METHOD'] != 'POST'
    || !isset($_POST['firstName'])
    || !isset($_POST['lastName'])
    || !isset($_POST['email'])
    || !isset($_POST['birthday'])
    || !isset($_POST['gender'])
    || !isset($_POST['contact'])
    || !isset($_POST['nid'])
    || !isset($_POST['dept'])
    || !isset($_POST['degree'])
) {
    header("Location: ../403.html?error=method");
    exit;
}

$csrf_token = checkInput($_POST['csrf_token']);

// check if csrf token is valid
if (!isset($_SESSION['csrf_token']) || !hash_equals($_SESSION['csrf_token'], $csrf_token)) {
    header("Location: ../403.html?error=csrf");
    exit;
}

$firstname = checkInput($_POST['firstName']);
$lastName = checkInput($_POST['lastName']);
$email = checkInput($_POST['email']);
$contact = checkInput($_POST['contact']);
$address = checkInput($_POST['address']);
$gender = checkInput($_POST['gender']);
$nid = checkInput($_POST['nid']);
$dept = checkInput($_POST['dept']);
$degree = checkInput($_POST['degree']);
$salary = checkInput($_POST['salary']);
$birthday = checkInput($_POST['birthday']);
//echo "$birthday";
$files = $_FILES['file'];
$filename = $files['name'];
$filrerror = $files['error'];
$filetemp = $files['tmp_name'];
$fileext = explode('.', $filename);
$filecheck = strtolower(end($fileext));
$fileextstored = array('png', 'jpg', 'jpeg');

if (in_array($filecheck, $fileextstored)) {

    $destinationfile = 'images/' . $filename;
    move_uploaded_file($filetemp, $destinationfile);

    $sql = "INSERT INTO `employee`(`id`, `firstName`, `lastName`, `email`, `password`, `birthday`, `gender`, `contact`, `nid`,  `address`, `dept`, `degree`, `pic`) VALUES ('','$firstname','$lastName','$email','1234','$birthday','$gender','$contact','$nid','$address','$dept','$degree','$destinationfile')";

    $result = mysqli_query($conn, $sql);

    $last_id = $conn->insert_id;

    $sqlS = "INSERT INTO `salary`(`id`, `base`, `bonus`, `total`) VALUES ('$last_id','$salary',0,'$salary')";
    $salaryQ = mysqli_query($conn, $sqlS);
    $rank = mysqli_query($conn, "INSERT INTO `rank`(`eid`) VALUES ('$last_id')");

    if (($result) == 1) {
        echo ("<SCRIPT LANGUAGE='JavaScript'>
        window.alert('Succesfully Registered')
        window.location.href='../viewemp.php';
        </SCRIPT>");
        //header("Location: ..//aloginwel.php");
    } else {
        echo ("<SCRIPT LANGUAGE='JavaScript'>
        window.alert('Failed to Registere')
        window.location.href='javascript:history.go(-1)';
        </SCRIPT>");
    }
} else {

    $sql = "INSERT INTO `employee`(`id`, `firstName`, `lastName`, `email`, `password`, `birthday`, `gender`, `contact`, `nid`,  `address`, `dept`, `degree`, `pic`) VALUES ('','$firstname','$lastName','$email','1234','$birthday','$gender','$contact','$nid','$address','$dept','$degree','images/no.jpg')";

    $result = mysqli_query($conn, $sql);

    $last_id = $conn->insert_id;

    $sqlS = "INSERT INTO `salary`(`id`, `base`, `bonus`, `total`) VALUES ('$last_id','$salary',0,'$salary')";
    $salaryQ = mysqli_query($conn, $sqlS);
    $rank = mysqli_query($conn, "INSERT INTO `rank`(`eid`) VALUES ('$last_id')");

    if (($result) == 1) {

        echo ("<SCRIPT LANGUAGE='JavaScript'>
        window.alert('Succesfully Registered')
        window.location.href='../viewemp.php';
        </SCRIPT>");
        //header("Location: ..//aloginwel.php");
    }

    // else{
    //     echo ("<SCRIPT LANGUAGE='JavaScript'>
    //     window.alert('Failed to Registere')
    //     window.location.href='javascript:history.go(-1)';
    //     </SCRIPT>");
    // }
}
