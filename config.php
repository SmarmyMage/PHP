<?php
session_start();
$loginOut = NULL;
$conn = mysqli_connect("localhost", "sherd_MartyAllen", "KUE7r2kX34kf3","sherd_MartyAllen");
if (isset($_POST['login'])) {
$loginOut .= <<<HERE
<form action="logout.php" class="form-inline" method="post">
    <input type="hidden" name="logout">
	<button class="btn btn-success" name="logout" type="submit">Logout</button>
</form>
HERE;
} else {
$loginOut .= <<<HERE
<form action="login.php" class="form-inline" method="post">
	<button class="btn btn-success" name="login" type="submit">Login</button>
</form>
HERE;
}
// Set up debug mode
function debug_data() { // called in template to print arrays at top of any page.
    echo '<pre>SESSION is ';
    echo print_r($_SESSION);
    echo 'COOKIE is ';
    echo print_r($_COOKIE);
    echo 'POST is ';
    echo print_r($_POST);
    echo 'GET is ';
    echo print_r($_GET);
    echo '</pre>';
}
//debug_data(); // Comment this out to hide debug information

?>