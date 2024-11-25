<?php
include_once 'config.php';
 
$pageTitle = 'Login';
$pageContent = NULL;
$userName = NULL;
$password = NULL;
$userNameError = NULL;
$passwordError = NULL;
$login = NULL;

if (isset($_POST['login'])) {

    $userName = mysqli_real_escape_string($conn, trim($_POST['userName']));
    if (empty($userName)) {
        $firstNameError = "<span class='error'>You must enter a username in this field.</span>";
        $valid = FALSE;
    }

    $password = mysqli_real_escape_string($_POST['password']);
    if(!empty($password)) {
        $passwordError = '<span class="error">You must enter a password in this field.</span>';
        $valid = FALSE;
    }
}


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

?>