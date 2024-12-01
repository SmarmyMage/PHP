<?php
include 'config.php';
if (isset($_POST['logout'])) {
	$msg = 'You are Logged out.';
	session_destroy();
	header("Location: index.php?msg=$msg");
	exit();
}

?>