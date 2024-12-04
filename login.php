<?php
session_start();
include_once 'config.php';

if (!$conn) {
    echo "Failed to connect to MySQL: ".mysqli_connect_error();
}

if (isset($_POST['memberID'])) {
     $memberID = $_POST['memberID'];
} elseif (isset($_GET['memberID'])) {
    $memberID = $_GET['memberID'];
} else {
     header("Location: register.php");
     exit();
}
 
$pageTitle = 'Login';
$pageContent = NULL;
$userName = NULL;
$password = NULL;
$userNameError = NULL;
$passwordError = NULL;
$login = NULL;
$logOutButton = NULL;


if (isset($_POST['login'])) {
    $userName = $_POST['username'];
	$password = $_POST['password'];

	$query = "SELECT `memberID`, `firstname`, `lastname` FROM `membership` WHERE `username` = '$userName' AND `password` = '$password';";
	$result = mysqli_query($conn,$query);
	if (!$result) {
		die(mysqli_error($conn));
	}
    // $pageContent .= "$query<br>";
	if ($row = mysqli_fetch_assoc($result)) {
		$_SESSION['memberID'] = $row['memberID'];
		$_SESSION['firstname'] = $row['firstname'];
		$_SESSION['lastname'] = $row['lastname'];
        header("Location: profile.php");
        exit();
	} else {
		echo "Sorry, we could not find you in the system.";
	}
}

$pageContent .= <<<HERE
<form action="login.php" method="post">
    <div class="form-group">
        <label>Username</label>
        <input type="text" class="form-control" id="username" name="username" value="$userName" required />
    </div>
    <div class="form-group">
        <label>Password</label>
        <input type="password" class="form-control" id="password" name="password" value="" required />
    </div>
	<button class="btn btn-success" name="login" type="submit">Login</button>
</form>
HERE;

/* if($login){

} else {
$pageContent .= <<<HERE
<form action="login.php" method="post">
    <div class="form-group">
        <label>Username</label>
        <input type="text" class="form-control" id="username" name="username" required />
    </div>
    <div class="form-group">
        <label>Password</label>
        <input type="password" class="form-control" id="password" name="password" required />
    </div>
    <input type="submit" name="login" value="Login" class="btn btn-primary">
</form>
HERE;
} */

include 'template.php';

?>