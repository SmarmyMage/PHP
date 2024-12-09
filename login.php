<?php
session_start();
include_once 'config.php';

if (!$conn) {
    echo "Failed to connect to MySQL: ".mysqli_connect_error();
}

// if (isset($_POST['memberID'])) {
//      $memberID = $_POST['memberID'];
// } elseif (isset($_GET['memberID'])) {
//     $memberID = $_GET['memberID'];
// } else {
//      header("Location: register.php");
//      exit();
// }
 
$pageTitle = 'Login';
$pageContent = NULL;
$username = NULL;
$password = NULL;
$usernameError = NULL;
$passwordError = NULL;
$login = NULL;
$logOutButton = NULL;
$msg = NULL;

if(filter_has_var(INPUT_GET, 'msg')) {
    $msg = filter_input(INPUT_GET, 'msg');
    $msg = "<p class='alert alert-success'>$msg</p>";
} else {
    $msg = NULL;
}


if (isset($_POST['login'])) {
    $username = $_POST['username'];
	$passwordSubmit = $_POST['password'];

	$query = "SELECT `memberID`, `password` FROM `membership` WHERE `username` = '$username';";
	$result = mysqli_query($conn,$query);
	if (!$result) {
		die(mysqli_error($conn));
	}
    // $pageContent .= "$query<br>";
	if ($row = mysqli_fetch_assoc($result)) {
        $password = $row['password'];
        $memberID = $row['memberID'];
        if (password_verify($passwordSubmit, $password)) { // checks submitted password against stored password for a match
            $stmt = $conn->stmt_init();
            if ($stmt->prepare("SELECT `firstname`, `lastname`, `email` FROM `membership` WHERE `memberID` = ?")) {
                $stmt->bind_param("i", $memberID);
                $stmt->execute();
                $stmt->store_result();
                $stmt->bind_result($firstname, $lastname, $email); // get authenticated member record
                    
                if($stmt->num_rows == 1){
                    $stmt->fetch();
        
                    $_SESSION['memberID'] = $memberID;
                        
                    setcookie("firstname", $firstname, time()+(3600*3));
                    setcookie("lastname", $lastname, time()+(3600*3));
                    setcookie("email", $email, time()+(3600*3));
        
                    header("Location: profile.php?memberID=$memberID&msg=You are logged in.");
                    exit();
        
                } else {
                    $msg = <<<HERE
                    <h3 class="error">We could not access the login records.</h3>
HERE;
                }
                $stmt->close();
            } else {
                $msg = <<<HERE
                <h3 class="error">We could not find your information.</h3>
HERE;
                }
            } else {
                $msg = <<<HERE
                <h3 class="error">We could not find you in the system. 
                New users must register before gaining access to the site. 
                If you forgot your login, please use the Password Recover tool.</h3>
HERE;
            }
	} else {
		echo "Sorry, we could not find you in the system.";
	}
}

$pageContent .= <<<HERE
<form action="login.php" method="post">
    <div class="form-group">
        <label>Username</label>
        <input type="text" class="form-control" id="username" name="username" value="$username" required />
    </div>
    <div class="form-group">
        <label>Password</label>
        <input type="password" class="form-control" id="password" name="password" value="" required />
    </div>
	<button class="btn btn-success" name="login" type="submit">Log Me In Now</button>
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