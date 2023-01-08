<?php
session_start();
require_once('process/userLoginCheck.php');
require_once('process/dbh.php');
require_once('process/checkInput.php');


$sql = "SELECT * FROM `employee` WHERE 1";

//echo "$sql";
$result = mysqli_query($conn, $sql);
if (isset($_POST['update'])) {

  if (!isset($_POST['csrf_token']) || !isset($_SESSION['csrf_token']) || !hash_equals($_SESSION['csrf_token'], $_POST['csrf_token'])) {
    header("Location: ../403.html?error=csrf");
    exit;
  }

  $id = mysqli_real_escape_string($conn, $_POST['id']);

  $email = mysqli_real_escape_string($conn, $_POST['email']);

  $contact = mysqli_real_escape_string($conn, $_POST['contact']);
  $address = mysqli_real_escape_string($conn, $_POST['address']);

  $result = mysqli_query($conn, "UPDATE `employee` SET `email`='$email',`contact`='$contact',`address`='$address' WHERE id=$id");

  echo ("<SCRIPT LANGUAGE='JavaScript'>
    window.alert('Succesfully Updated')
    window.location.href='myprofile.php?id=$id  ';
    </SCRIPT>");
}

$id = $_SESSION['empid'];
$sql = "SELECT * from `employee` WHERE id=$id";
$result = mysqli_query($conn, $sql);
if ($result) {
  while ($res = mysqli_fetch_assoc($result)) {
    $firstname = $res['firstName'];
    $lastname = $res['lastName'];
    $email = $res['email'];
    $contact = $res['contact'];
    $address = $res['address'];
    $gender = $res['gender'];
    $birthday = $res['birthday'];
    $nid = $res['nid'];
    $dept = $res['dept'];
    $degree = $res['degree'];
    // $salary = $res['salary'];
  }
}

?>

<html>

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta http-equiv="Content-Security-Policy" content="
		default-src 'self' https://fonts.googleapis.com; 
		font-src 'self' https://fonts.gstatic.com;">
  <title>Update Profile | XYZ Corporation</title>
  <!-- Icons font CSS-->
  <link href="vendor/mdi-font/css/material-design-iconic-font.min.css" rel="stylesheet" media="all">
  <link href="vendor/font-awesome-4.7/css/font-awesome.min.css" rel="stylesheet" media="all">
  <!-- Font special for pages-->
  <link href="https://fonts.googleapis.com/css?family=Roboto:100,100i,300,300i,400,400i,500,500i,700,700i,900,900i" rel="stylesheet">

  <!-- Vendor CSS-->
  <link href="vendor/select2/select2.min.css" rel="stylesheet" media="all">
  <link href="vendor/datepicker/daterangepicker.css" rel="stylesheet" media="all">

  <!-- Main CSS-->
  <link href="css/main.css" rel="stylesheet" media="all">
</head>

<body>
  <header>
    <nav>
      <h1>XYZ Corp.</h1>
      <ul id="navli">
        <li><a class="homeblack" href="eloginwel.php">HOME</a></li>
        <li><a class=" homered" href="myprofile.php">My Profile</a></li>
        <li><a class=" homeblack" href="applyleave.php">Apply Leave</a></li>
        <li><a class=" homeblack" href="elogin.php">Log Out</a></li>
      </ul>
    </nav>
  </header>

  <div class="divider"></div>


  <!-- <form id = "registration" action="edit.php" method="POST"> -->
  <div class="page-wrapper bg-blue p-t-100 p-b-100 font-robo">
    <div class="wrapper wrapper--w680">
      <div class="card card-1">
        <div class="card-heading"></div>
        <div class="card-body">
          <h2 class="title">Update Employee Info</h2>

          <?php
          $token = bin2hex(random_bytes(32));
          $_SESSION['csrf_token'] = $token;
          ?>

          <form id="registration" action="myprofileup.php" method="POST">

            <div class="input-group">
              <p>Email</p>
              <input class="input--style-1" type="email" name="email" value="<?php echo $email; ?>">
            </div>

            <div class="input-group">
              <p>Contact</p>
              <input class="input--style-1" type="number" name="contact" value="<?php echo $contact; ?>">
            </div>

            <div class="input-group">
              <p>Address</p>
              <input class="input--style-1" type="text" name="address" value="<?php echo $address; ?>">
            </div>

            <input type="hidden" name="id" id="textField" value="<?php echo $id; ?>" required="required"><br><br>
            <input type="hidden" name="csrf_token" value="<?php echo $token; ?>">

            <div class="p-t-20">
              <button class="btn btn--radius btn--green" type="submit" name="update">Submit</button>
            </div>

          </form>
          <br>
          <button class="btn btn--radius btn--green" onclick="window.location.href = 'changepassemp.php';">Change Password</button>
        </div>
      </div>
    </div>
  </div>

</body>

</html>