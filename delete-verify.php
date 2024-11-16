<?php
include 'config.php';

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

$pageTitle = "Profile";
$firstName = NULL;
$lastName = NULL;
$email = NULL;
$userName = NULL;
$image = NULL;
$pageContent = NULL;
$errMsg = NULL;

if(isset($_POST['delete-profile'])) {
    $query = "DELETE FROM 'membership' WHERE 'memberID' = $memberID LIMIT 1;";
    $result = mysqli_query($conn, $query);
    if (!$result) {
        $errMsg = "<p>Delete failed</p>";
    } else {
        $row_count = mysqli_affected_rows($conn);
        if ($row_count == 1) {
            unlink("uploads/".$_POST['image']);
            header("Location: register.php?action=deleted");
            exit();
        } else {
            $errMsg = "<p>Insert Failed</p>";
        }
    }
}

$query = "SELECT * FROM `membership` WHERE `memberID` = $memberID;";
$result = mysqli_query($conn,$query);
if (!$result) {
    die(mysqli_error($conn));
}
if ($row = mysqli_fetch_assoc($result)) {
    $firstName = $row['firstname'];
    $lastName = $row['lastname'];
    $userName = $row['username'];
    $email = $row['email'];
    $image = $row['image'];
} else {
    echo "Sorry, we couldn't find your record.";
}

$pageContent .= <<<HERE
<section class="container">
	<figure><img src="uploads/$image" alt="Profile image" class="profilePic" />
		<figcaption>Member: $firstName $lastName</figcaption>
	</figure>
	<h1>Delete User Account</h1>
	<p class='bg-warning'>Are you sure you want to delete this member account? This cannot be undone.</p>
	<p>Email: $email</p>
	<p>Username: <strong>$userName</strong></p>
	<form action="profile.php" method="post">
		<div class="form-group">
			<input type="hidden" name="memberID" value="$memberID">
			<input type="submit" name="profile" value="Cancel" class="btn btn-success">
		</div>
	</form>
	<form action="delete-verify.php" method="post">
		<div class="form-group">
			<input type="hidden" name="image" value="$image">
			<input type="hidden" name="memberID" value="$memberID">
			<input type="submit" name="delete-profile" value="Verify Delete" class="btn btn-danger">
		</div>
	</form>
  </section>\n
HERE;

include 'template.php';
?>