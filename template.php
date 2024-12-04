<!DOCTYPE html>
<html lang="en">

   <head>
      <meta charset="UTF-8">
      <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
      <title><?php echo $pageTitle; ?></title>
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

         <a><?php echo $loginOut; ?></a>
      </nav>

      <main class="container ml-2">
         <h1><a href="index.php">Welcome, Guest</a></h1>
         <?php echo $pageContent; ?>
      </main>

    </body>

   <footer>
        <p>&copy; Anthony Reyna, MyWebTraining, 2024</p>
   </footer>

</html>