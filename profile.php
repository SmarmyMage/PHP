<?php
include 'config.php';

if (!$conn) {
    echo "Failed to connect to MySQL: ".mysqli_connect_error();
}

if (isset($_POST['memberID'])) {
    $memberID = $_POST['memberID'];
} elseif (isset($_GET['memberID'])) {
    $memberID = $_GET['memberID'];
} elseif (isset($_SESSION['memberID'])) {
    $memberID = $_SESSION['memberID'];
} else {
    header("Location: register.php");
    exit();
}

$pageTitle = "Profile";
$firstName = NULL;
$lastName = NULL;
$email = NULL;
$userName = NULL;
$password = NULL;
$password2 = NULL;
$firstNameError = NULL;
$lastNameError = NULL;
$emailError = NULL;
$emailFormatError = NULL;
$passwordError = NULL;
$passwordMismatch = NULL;
$imageError = NULL;
$fileInfo = NULL;
$imageName = NULL;
$valid = TRUE;
$insert_success = FALSE;
$pageContent = NULL;
$errMsg = NULL;
$update = FALSE;

if(isset($_GET['action'])) {
    $errMsg = "<p class'text-danger'>Record " .$_GET['action'] . "</p>";
} else {
    $errMsg = NULL;
}

if(isset($_GET['update'])) {
    $update = TRUE;
}

if(isset($_POST['update'])) {
    $firstName = mysqli_real_escape_string($conn, trim($_POST['firstName']));
    if (empty($firstName)) {
        $firstNameError = "<span class='error'>You must enter a name in this field.</span>";
        $valid = FALSE;
    }

    $lastName = mysqli_real_escape_string($conn, trim($_POST['lastName']));
    if (empty($lastName)) {
        $lastNameError = "<span class='error'>You must enter a name in this field.</span>";
        $valid = FALSE;
    }

    $email = mysqli_real_escape_string($conn, trim($_POST['email']));
    if (empty($_POST['email'])){
        $emailError = "<span class='error'>You must enter an email in this field.</span>";
        $valid = FALSE;
    }
  
    if (!preg_match('/[-\w.]+@([A-z0-9][-A-z0-9]+\.)+[A-z]{2,4}/', $email)) {
        $emailFormatError = "<span class='error'>You must enter a valid email address.</span>";
        $valid = FALSE;
    }

    //$userName = strtolower(substr($firstName,0,1) . $lastName);

    if($valid) {
        $query = "UPDATE 'membership' SET 'firstname' = '$firstName', 'lastname' = '$lastName' 'email' = '$email' WHERE 'memberID' = $memberID;";
        $result = mysqli_query($conn, $query);
        if (!$result) {
            die(mysqli_error($conn));
        }
    }

    //'username' = '$userName'

    $password = trim($_POST['password']);
    if(!empty($password)) {
        $password2 = trim($_POST['password2']);
        if (!strcmp($password, $password2)) {
            $passwordMismatch = '<span class="error">Passwords do not match each other.</span>';
            $valid = FALSE;
        } else {
            $password = password_hash($password, PASSWORD_DEFAULT);
            $query = "UPDATE 'membership' SET 'password' = '$password' WHERE 'memberID' = $memberID;";
            $result = mysqli_query($conn, $query);
            if (!$result) {
                die(mysqli_error($conn));
            } else{
                $row_count = mysqli_affected_rows($conn);
                if ($row_count == 1) {
                    echo "<p>Record Updated</p>";
                } else {
                    echo "<p>Update Failed</p>";
                }
            }
        }
    }

    if (file_exist($file)) {
        $imageError = "<span class='error'>$imageName already exist.</span>";
        $valid = FALSE;
    } else {
        if (move_uploaded_file($_FILE['profilePic']['tmp_name'], $file)) {
            $fileInfo .= "<p<Your file has been uploaded. Stored as $file</p>";

            $query = "UPDATE 'membership' SET 'image' = '$imageName' WHERE 'memberID' = $memberID;";
            $result = mysqli_query($conn, $query);
            if (!$result) {
                die(mysqli_error($conn));
            } else{
                $row_count = mysqli_affected_rows($conn);
                if ($row_count == 1) {
                    echo "<p>Record Updated</p>";
                } else {
                    echo "<p>Update Failed</p>";
                }
            }
        } else {
            $imageError .= "<p><span class='error'>Your file could not be uploaded. ";
            $valid = FALSE;
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
    $errMsg = "Sorry, we couldn't find your record.";
}

// if ($valid) { // if the form data are valid
// 	$stmt = $conn->stmt_init(); // create the database connection
// 	if ($stmt->prepare("SELECT `memberID`, `password` FROM `membership` WHERE `username` = '$userName';")) { // prepare the db query
// 		$stmt->bind_param("s", $username); // lookup this user
// 		$stmt->execute();
// 		$stmt->store_result();
// 		$stmt->bind_result($memberID, $password); // bind the stored password from the db record to a variable
// 		$stmt->fetch();
// 		$stmt->free_result();
// 		$stmt->close();
// 	} else {
// 		$msg = <<<HERE
// 		<h3 class="error">We could not find you in the system. 
// 		New users must register before gaining access to the site. 
// 		If you forgot your login, please use the Password Recover tool.</h3>
// HERE;
// 	}

// if (password_verify($passwordSubmit, $password)) { // checks submitted password against stored password for a match
// 	$stmt = $conn->stmt_init();
// 	if ($stmt->prepare("SELECT `firstname`, `lastname`, `email` FROM `membership` WHERE `memberID` = $memberID;")) {
// 		$stmt->bind_param("i", $memberID);
// 		$stmt->execute();
// 		$stmt->store_result();
// 		$stmt->bind_result($firstName, $lastName, $email); // get authenticated member record
			
// 		if($stmt->num_rows == 1){
// 			$stmt->fetch();

// 			// $_SESSION['memberID'] = $memberID;
				
// 			// setcookie("firstname", $firstname, time()+(3600*3));

// 			header("Location: profile.php?memberID=$memberID&msg=You are logged in.");
// 			exit;

// 		} else {
// 			$msg = <<<HERE
// 			<h3 class="error">We could not access the login records.</h3>
// HERE;
// 	    }
// 		$stmt->close();
// 	} else {
// 		$msg = <<<HERE
// 		<h3 class="error">We could not find your information.</h3>
// HERE;
// 		}
// 	} else {
// 		$msg = <<<HERE
// 		<h3 class="error">We could not find you in the system. 
// 		New users must register before gaining access to the site. 
// 		If you forgot your login, please use the Password Recover tool.</h3>
// HERE;
// 	}
// }

if (!$update) {
$pageContent .= <<<HERE
    <section class="container">
        $errMsg
        <figure><img src="uploads/$image" alt="Profile Image" class="profilePic" />
            <figcaption>Member: $firstName $lastName</figcaption>
        </figure>
        <p>Thank you, $firstName $lastName.</p>
        <p><a href="profile.php?update&memberID=$memberID">Update Profile</a></p>
        <p>Email: $email</p>
        <p>You are now signed into our system. We hope you enjoy the site.</p>
        <p>Your information is now saved. Use the username provided below for future logins.</p>
        <p>Username: <strong>$userName</strong></p>
    </section>\n
HERE;

} else {
$pageContent .= <<<HERE
<div class="container">
    <section class="container">
        <p>Please update your information.</p>
        <form action="profile.php" enctype="multipart/form-data" method="post">
            <div class="form-group">
                <label for="firstName">First Name:</label>
                <input type="text" name="firstName" id="firstName" value="$firstName" class="form-control"> $firstNameError
            </div>
            <div class="form-group">
                <label for="lastName">Last Name:</label>
                <input type="text" name="lastName" id="lastName" value="$lastName" class="form-control"> $lastNameError
            </div>
            <div class="form-group">
                <label for="email">Email:</label>
                <input type="text" name="email" id="email" value="$email" class="form-control"> $emailError $emailFormatError
            </div>
            <div class="form-group">
                <label for="password">Password:</label>
                <input type="text" name="password" id="password" value="" class="form-control"> $passwordError
            </div>
            <div class="form-group">
                <label for="password2">Verify Password:</label>
                <input type="password" name="password2" id="password2" value="" class="form-control"> $passwordMismatch
            </div>
            <figure><img src="uploads/$image" alt="Profile Image" class="profilePic" />
                <figcaption>Member: $firstName $lastName</figcaption>
            </figure>
            <p style="clear: both;">Please select an image for your profile.</p>
            <div class="form-group">
                <input type="hidden" name="MAX_FILE_SIZE" value="300000">
                <label for="profilePic">File to Upload:</label> $imageError
                <input type="file" name="profilePic" id="profilePic" class="form-control">
            </div>
            <div class="form-group">
                <input type="hidden" name="imageName" value="$image" class="btn btn-primary">
                <input type="hidden" name="memberID" value="$memberID" class="btn btn-primary">
                <input type="submit" name="update" value="Update Profile" class="btn btn-primary">
            </div>
        </form>
        <form action="delete-verify.php" method="post">
            <div class="form-group">
                <input type="hidden" name="memberID" value="$memberID" class="btn btn-primary">
                <input type="submit" name="delete" value="Delete Profile" class="btn btn-danger">
            </div>
        </form>
    </section>
</div>
HERE;
}

include 'template.php';
?>