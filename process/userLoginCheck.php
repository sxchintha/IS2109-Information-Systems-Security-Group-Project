<?php

// check if the user is logged in or not
if (!isset($_SESSION['empid'])) {
    header("Location: 403.html?error=notloggedin");
	exit();
}
