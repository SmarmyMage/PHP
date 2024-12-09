<?php
session_start();
$loginOut = NULL;
$conn = mysqli_connect("localhost", "sherd_MartyAllen", "KUE7r2kX34kf3","sherd_MartyAllen");
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
ini_set('display_errors', 1); ini_set('log_errors',1); error_reporting(E_ALL); mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

function auth_user() {
	if(isset($_SESSION['memberID'])) {
		return TRUE;
	} else {
		return FALSE;
	}
}
?>