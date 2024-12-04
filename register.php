<?php
include_once 'config.php';

$pageTitle = "Register";
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


if (isset($_POST['submit'])) {
//  $firstName = ucwords(htmlspecialchars($_POST['firstName']));
    $firstName = mysqli_real_escape_string($conn, trim($_POST['firstName']));
    if (empty($firstName)) {
        $firstNameError = "<span class='error'>You must enter a name in this field.</span>";
        $valid = FALSE;
    }

    // $lastName = ucwords(htmlspecialchars($_POST['lastName']));
    $lastName = mysqli_real_escape_string($conn, trim($_POST['lastName']));
    if (empty($lastName)) {
        $lastNameError = "<span class='error'>You must enter a name in this field.</span>";
        $valid = FALSE;
    }

    // $email = htmlspecialchars($_POST['email']);
    $email = mysqli_real_escape_string($conn, trim($_POST['email']));
    if (empty($_POST['email'])){
        $emailError = "<span class='error'>You must enter an email in this field.</span>";
        $valid = FALSE;
    }
  
    if (!preg_match('/[-\w.]+@([A-z0-9][-A-z0-9]+\.)+[A-z]{2,4}/', $email)) {
        $emailFormatError = "<span class='error'>You must enter a valid email address.</span>";
        $valid = FALSE;
    }
    
    $password = trim($_POST['password']);
    if (empty($password)) {
        $passwordError = "<span class='error'>You must enter a password in this field.</span>";
        $valid = FALSE;
    }

    $password2 = trim($_POST['password2']);
    if (strcmp($password, $password2) ) {
        $passwordMismatch = "<span class='error'>Passwords do not match each other.</span>";
        $valid = FALSE;
    }

    if (!preg_match('/(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}/',$password)){
	$passwordError = "Must contain at least one number and 
	one uppercase and lowercase letter, and at least 8 or more characters";
	$valid = FALSE;
    }
    $password = password_hash($password, PASSWORD_DEFAULT);

    $userName = strtolower(substr($firstName,0,1) . $lastName);

    if ($valid) {
        $filetype = pathinfo($_FILES['profilePic']['name'],PATHINFO_EXTENSION);
        if ((($filetype == "gif") or ($filetype == "jpg") or ($filetype == "png")) and $_FILES['profilePic']['size'] < 300000) {
            if ($_FILES["profilePic"]['error'] > 0) {
                $valid = FALSE;
                $fileError = $_FILES["profilePic"]["error"];
                $imageError = "<p class='error'>Return Code: $fileError<br>";
                switch ($fileError) {
                    case 1:
                        $imageError .= 'The file exceeds the upload_max_filesize setting in php.ini.</p>';
                        break;
                    case 2:
                        $imageError .= 'The file exceeds the MAX_FILE_SIZE setting in HTML form.</p>';
                        break;
                    case 3:
                        $imageError .= 'The file the file was only partially uploaded.</p>';
                        break;
                    case 4:
                        $imageError .= 'No file was uploaded.</p>';
                        break;
                    case 6:
                        $imageError .= 'The temporary folder does not exist.</p>';
                        break;
                    default:
                        $imageError .= 'Something unexpected happened.</p>';
                        break;
                    }
                } else {
                        $imageName = $_FILES["profilePic"]["name"];
                        $file = "uploads/$imageName";
                        $fileInfo = "<p>Upload: $imageName<br>";
                        $fileInfo .= "Type: " . $_FILES["profilePic"]["type"] . "<br>";
                        $fileInfo .= "Size: " . ($_FILES["profilePic"]["size"] / 1024) . " Kb<br>";
                        $fileInfo .= "Temp file: " . $_FILES["profilePic"]["tmp_name"] . "</p>";
                        if (file_exists($file)) {
                            $imageError = "<span class='error'>$imageName already exists.</span>";
                        } else {
                            if (move_uploaded_file($_FILES['profilePic']['tmp_name'], $file)) {
                                $fileInfo .= "<p>Your file has been uploaded. Saved as $file.</p>";

                                if (!$conn) {
                                    echo "Failed to connect to MySQL: ".mysqli_connect_error($conn);
                                }
                            
                                $query = "INSERT INTO `membership` VALUES (DEFAULT,'$firstName','$lastName','$userName','$email','$password', '$imageName');";
                                $result = mysqli_query($conn, $query) or die(mysqli_error($conn));
                                if (!$result) {
                                    die(mysqli_error($conn));
                                } else {
                                    $row_count = mysqli_affected_rows($conn);
                                    if ($row_count == 1) {
                                        $memberID = mysqli_insert_id($conn);
                                        $insert_success = TRUE;
                                        echo "<p>Record inserted</p>";
                                    } else {
                                        echo "<p>Insert failed</p>";
                                    }
                                }
                                
                            } else {
                                $imageError .= "<p><span class='error'>Your file could not be uploaded. $fileInfo</span></p>";
                        } 
                    } 
                } 
            } else {
            $imageError .= "<p><span class='error'>Invalid file. This is not an image.</span></p>";
        }
    }
}

if ($insert_success) {
    $query = "SELECT * FROM `membership` WHERE `memberID` = $memberID;";
    $result = mysqli_query($conn,$query);
    if (!$result) {
        die(mysqli_error($conn));
    }
    if ($row = mysqli_fetch_assoc($result)) {
        // set the database field values to local variables for futher use in the script
        $firstName = $row['firstname'];
        $lastName = $row['lastname'];
        $userName = $row['username'];
        $email = $row['email'];
        $image = $row['image'];     
        // $password = password_hash($password, PASSWORD_DEFAULT);
        // $stmt = $conn->stmt_init();
        // if ($stmt->prepare("INSERT INTO `membership` SET `password` = '$password' WHERE `memberID` = '$memberID';")) {
        // $stmt->bind_param("si", $password, $memberID);
        // $stmt->execute();
        // $stmt->close();
    } else {
        echo "Sorry, we couldn't find your record.";
    }
    
    $pageContent .= <<<HERE
    <section class="container pl-2">
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
        <p><a href="register.php>Page Reload</a></p>
    </section>\n
    HERE;

} else { 
    if (isset($_GET['action'])) {
        $errMsg = "<div> class='alert alert-danger my-2'> Record " . $_GET['action'] . "</div>";
    }
$pageContent .= <<<HERE
<section class="container pl-2">
    $errMsg
    <p>User Sign-In</p>
        <form action="register.php" enctype="multipart/form-data" method="post">
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
                <input type="password" name="password" id="password" value="" class="form-control" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}" 
                title="Must contain at least one number and one uppercase and lowercase letter, and at least 8 or more characters" 
                placeholder="Password" required /> $passwordError
            </div>
            <div class="form-group">
                <label for="password2">Verify Password:</label>
                <input type="password" name="password2" id="password2" value="" class="form-control"> $passwordMismatch
            </div>
            <p>Please select an image for your profile.</p>
            <div class="form-group">
                <input type="hidden" name="MAX_FILE_SIZE" value="300000">
                <label for="profilePic">File to Upload:</label> $imageError
                <input type="file" name="profilePic" id="profilePic" class="form-control">
            </div>
            <div class="form-group">
                <input type="submit" name="submit" value="Submit Profile" class="btn btn-primary">
                <input type="submit" name="reset" value="Reset Profile" class="btn btn-primary">
            </div>
        </form>
</section>\n
HERE;
}  

include 'template.php';
?>