<?php
function memberEditView($memberID, $firstname, $lastname) {
//     $email = NULL;
//     $username = NULL;
//     $password = NULL;
//     $password2 = NULL;
//     $firstnameError = NULL;
//     $lastnameError = NULL;
//     $emailError = NULL;
//     $emailFormatError = NULL;
//     $passwordError = NULL;
//     $passwordMismatch = NULL;
//     $imageError = NULL;
//     $fileInfo = NULL;
//     $imagename = NULL;
// $pageContent = <<<HERE
//     <section class="container">
//     $message
//     <p>Please update your information.</p>
//         <form action="profile.php" enctype="multipart/form-data" method="post">
//             <div class="form-group">
//                 <label for="firstname">First name:</label>
//                 <input type="text" name="firstname" id="firstname" value="$firstname" class="form-control"> $firstnameError
//             </div>
//             <div class="form-group">
//                 <label for="lastname">Last name:</label>
//                 <input type="text" name="lastname" id="lastname" value="$lastname" class="form-control"> $lastnameError
//             </div>
//             <div class="form-group">
//                 <label for="email">Email:</label>
//                 <input type="text" name="email" id="email" value="$email" class="form-control"> $emailError $emailFormatError
//             </div>
//             <div class="form-group">
//                 <label for="password">Password:</label>
//                 <input type="text" name="password" id="password" value="" class="form-control"> $passwordError
//             </div>
//             <div class="form-group">
//                 <label for="password2">Verify Password:</label>
//                 <input type="password" name="password2" id="password2" value="" class="form-control"> $passwordMismatch
//             </div>
//             <figure><img src="uploads/$image" alt="Profile Image" class="profilePic" />
//                 <figcaption>Member: $firstname $lastname</figcaption>
//             </figure>
//             <p style="clear: both;">Please select an image for your profile.</p>
//             <div class="form-group">
//                 <input type="hidden" name="MAX_FILE_SIZE" value="300000">
//                 <label for="profilePic">File to Upload:</label> $imageError
//                 <input type="file" name="profilePic" id="profilePic" class="form-control">
//             </div>
//             <div class="form-group">
//                 <input type="hidden" name="imagename" value="$image" class="btn btn-primary">
//                 <input type="hidden" name="memberID" value="$memberID" class="btn btn-primary">
//                 <input type="submit" name="update" value="Update Profile" class="btn btn-primary">
//             </div>
//         </form>
//     </section>
// HERE;
header("Location: profile.php");
}

function memberView($memberID, $firstname, $lastname) {
$pageContent = <<<HERE
<h2>$firstname $lastname</h2>
<form action="dashboard.php" method="post">
    <div class="form-group">
        <input type="hidden" name="memberID" value="$memberID">
        <input type="submit" name="edit" value="Edit Member" class="btn btn-success">
    </div>
</form>
<form action="dashboard.php" method="post">
    <div class="form-group">
        <input type="submit" name="cancel" value="Show Members List" class="btn btn-primary">
    </div>
</form>
<form action="dashboard.php" method="post">
    <input type="hidden" name="memberID" value="$memberID">
    <div class="form-group">
        <input type="submit" name="delete" value="Delete Member" class="btn btn-danger">
    </div>
</form>
HERE;
return $pageContent;
}

function memberListView($memberList) {
$pageContent = <<<HERE
<h2>Member Selection</h2>
<p>Please select a member below.</p>
$memberList
HERE;
return $pageContent;
}
?>