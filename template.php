<?php
if (isset($_COOKIE['firstname'])) {
   $firstName = $_COOKIE['firstname'];
} else {
   $firstName = 'Guest';
}
if (isset($_SESSION['memberID'])) {
$loginOut = <<<HERE
<form action="logout.php" class="form-inline" method="post">
   <input type="hidden" name="logout">
  <button class="btn btn-error" name="logout" type="submit">Logout</button>
</form>
HERE;
} else {
$loginOut = <<<HERE
<form action="login.php" class="form-inline" method="post">
  <button class="btn btn-primary" name="loginButton" type="submit">Login</button>
</form>
HERE;
}
?>
<!DOCTYPE html>
<html lang="en">

   <head>
      <meta charset="UTF-8">
      <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
      <title><?= $pageTitle; ?></title>
   </head>

   <body>
      <header>2024FA-ITSE-1306-21701-PHP Programming | Anthony Reyna</header>
      <nav>
         <a href="index.php">Home</a> |
         <a href="array.php">Array</a> |
         <a href="form-validation.php">Form</a> |
         <a href="file-uploads.php">File Uploads</a> |
         <a href="register.php">Register</a> |
         <a href="profile.php">Profile</a> |
         <a href="blog.php">Blog</a> |

         <?= $loginOut; ?>
      </nav>

      <main class="container ml-2">
         <h1><a href="index.php">Welcome, <?= $firstName; ?></a></h1>
         <?= $pageContent; ?>
      </main>

    </body>

   <footer>
        <p>&copy; Anthony Reyna, MyWebTraining, 2024</p>
   </footer>

</html>