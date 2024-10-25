<?php
$pageTitle = "File Uploads";
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
$valid = FALSE;
$signedIn = NULL;
$pageContent = NULL;
$errMsg = NULL;

if (isset($_POST['submit'])) {
	$valid = true;

    $firstName = ucfirst(htmlspecialchars($_POST['firstName']));
    if (empty($firstName)) {
        $firstNameError = "<span class='error'>You must enter a name in this field.</span>";
        $valid = FALSE;
    }

    $lastName = ucfirst(htmlspecialchars($_POST['lastName']));
    if (empty($lastName)) {
        $lastNameError = "<span class='error'>You must enter a name in this field.</span>";
        $valid = FALSE;
    }

    $email = htmlspecialchars($_POST['email']);
    if (empty($_POST['email'])){
        $emailError = "<span class='error'>You must enter an email in this field.</span>";
        $valid = FALSE;
    }
  
    if (!preg_match('/[-\w.]+@([A-z0-9][-A-z0-9]+\.)+[A-z]{2,4}/', $email)) {
        $emailFormatError = "<span class='error'>You must enter a valid email address.</span>";
        $valid = FALSE;
    }
    
    $password = trim($_POST('password'));
    if (empty($password)) {
        $passwordError = "<span class='error'>You must enter a password in this field.</span>";
        $valid = FALSE;
    }

    $password2 = trim($_POST('password2'));
    if (strcmp($password, $password2)) {
        $passwordMismatch = "<span class='error'>Passwords do not match each other.</span>";
        $valid = FALSE;
    }

    $userName = strtolower(substr($firstname,0,1) . $lastName);

    if ($valid) {
        $filetype = pathinfo($_FILES['profilePic']['name'], PATHINFO_EXTENSION);
        if((($filetype = "gif") or ($filetype = "jpg") or ($filetype = "png")) and $_FILES['profilePic']['size'] < 300000) {
            if($_FILES["profilePic"]["error"] > 0) {
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
                    case 5:
                        $imageError .= 'The temporary folder does not exist.</p>';
                        break;
                    default:
                        $imageError .= 'Something unexpected happened.</p>';
                        break;
                    }
                } else {
                    $imageName = $_FILES['profilePic']['name'];
                    $file = "uploads/$imageName";
                    $fileInfo = "<p>Upload: $imageName<br>";
                    $fileInfo .= "Type: " . $_FILES["profilePic"]["type"] . "<br>";
                    $fileInfo .= "Size: " . ($_FILES["profilePic"]["size"] / 1024) . " Kb<br>";
                    $fileInfo .= "Temp file: " . $_FILES["profilePic"]["tmp_name"] . "</p>";
                    if (file_exists($file)) {
                        $imageError = "<span class='error'>$imageName already exists.</span>";
                    } else {
                        if (move_upload_file($_FILES["profilePic"]["tmp_name"], $file)) {
                            $fileInfo .= "<p>Your file has been uploaded. Saved as $file.</p>";

                            $fileName = "membership.txt";
                            $dataEntry = $firstName . "," . $lastName . "," . $email . "," . $userName . "," . $password . "\n";
                            $fp = fopen($fileName, "a") or die ("Couldn't open file.");
                            if (fwrite($fp, $dataEntry) > 0) {
                                $fp = fclose($fp);
                                $signedIn = TRUE;
                            } else {
                                $fp = fclose($fp);
                                $errMsg = "Your information was not saved. Please try again later.<br>"
                            }
                        } else {
                            $imageError .= "<p><span class='error'>Your file could not be uploaded. $fileInfo</span></p>"
                        }
                    }
                }
        } else {
            $imageError .= "<p><span class='error'>Invalid file. This is not an image.</span></p>"
        }
    }
}

if ($signedIn) {
    $poem = "poem.txt";
    $fp = fopen($poem, "r") or die ("Couldn't open file.");
    if (!feof($fp)) {
        $poemText = fgets($fp);
    } else {
        $pageContent .= "Your information was not found. Please try again later.<br>";
    }
    $fp = fclose($fp);

    $pageContent = <<<HERE
    <section class="container pl-2">
        $errMsg
        <p>Thank you, $firstName $lastName.</p>
        <figure><img src="$file" alt="Profile Image" class="profilePic" />
        <figcaption>Member: $firstName $lastName</figcaption>
        </figure>
        <p>Email: $email</p>
        <p>You are now signed into our system. We hope you enjoy the site.</p>
        <p>Your information is now saved. Use the username provided below for future logins.</p>
        <p>Username: <strong>$userName</strong></p>
        <p><a href="file-uploads.php>Page Reload</p>
        <h2>A Poem You Might Enjoy: </h2>
        <p>$poemText</p>
    </section>\n
    HERE;
} else {
$pageContent = <<<HERE
<fieldset class="container pl-2">
    <legend> User Sign-In </legend>
        <form method="post" action="file-uploads.php">
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
			<input type="text" name="email" id="email" value="$email" class="form-control"> $emailError $emailFormantError
		</div>
		<p>Please select an image for your profile.</p>
		<div class="form-group">
			<input type="hidden" name="MAX_FILE_SIZE" value="100000">
			<label for="profilePic">File to Upload:</label> $imageError
			<input type="file" name="profilePic" id="profilePic" class="form-control">
		</div>
		<div class="form-group">
			<input type="submit" name="submit" value="Submit Profile" class="btn btn-primary">
		</div>
    </form>
</fieldset>
HERE;
}

include 'template.php';
?>