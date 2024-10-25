<?php
$userName = NULL;
$email = NULL;
$instrument = NULL;
$instrumentList = NULL;
$instrumentChecked = NULL;
$animal = NULL;
$animalList = NULL;
$animal1 = $animal2 = NULL;
$animalChecked = NULL;
$activity = NULL;
$activityList = NULL;
$activityChecked = NULL;

$userNameError = NULL;
$emailError = NULL;
$instrumentError = NULL;
$animalError = NULL;
$activityError = NULL;

$valid = false;

$instrumentArray = array('Guitar', 'Piano', 'Lyre', 'Flute');
foreach ($instrumentArray as $instrumentName){
    $instrumentChecked[$instrumentName] = NULL;
}

$animalArray = array('Dog', 'Cat', 'Snake', 'Rabbit');
foreach ($animalArray as $animalIndex => $animalName){
    $animalChecked[$animalIndex] = NULL;
}

$activityArray = array('Tennis', 'Fencing', 'Hanafuda', 'Mancala', 'Golf');
foreach ($activityArray as $activityName){
    $activityChecked[$activityName] = NULL;
}

if (isset($_POST['submit'])) {
	$valid = true;

    if (empty($_POST['userName'])){
        $userNameError = "<span class='error'>You must enter a user name.</span>";
        $valid = false;
    } else {
        $userName = ucfirst(htmlspecialchars($_POST['userName']));
    }

    if (empty($_POST['email'])){
        $emailError = "<span class='error'>You must enter an email.</span>";
        $valid = false;
    } else {
        $email = trim($_POST['email']);
        if (!preg_match('/[-\w.]+@([A-z0-9][-A-z0-9]+\.)+[A-z]{2,4}/', $email)) {
            $emailError = "<span class='error'>You must enter a valid email address.</span>";
            $valid = false;
        }
    }

    if (empty($_POST['instrument'])){
        $userNameError = "<span class='error'>You must select an instrument.</span>";
        $valid = false;
    } else {
        $instrument = $_POST['instrument'];
        if (in_array($instrument, $instrumentArray)) {
            $instrumentChecked[$instrument] = "checked";
        }
    }

    if (isset($_POST['animal'])){
        $countAnimal = COUNT($_POST['animal']);
        foreach ($_POST['animal'] as $index => $animal) {
            $selectedAnimal[] = $animal;
            if (in_array($animal, $animalArray)) {
                $animalChecked[$index] = "checked";
            }
        }
        if($countAnimal == 2){
            $animal1 = $selectedAnimal[0];
            $animal2 = $selectedAnimal[1];
        } else {
            $animalError = "<span class='error'>You must select only two(2) animals.</span>";
            $valid = false;
        }
    } else {
        $animalError = "<span class='error'>You must select two(2) animals.</span>";
            $valid = false;
    }

    if (empty($_POST['activity'])){
        $activityError = "<span class='error'>You must select an activity.</span>";
        $valid = false;
    } else {
        $activity = $_POST['activity'];
        if (in_array($activity, $activityArray)) {
            $activityChecked[$activity] = "selected";
        }
    }
}
	if ($valid) {
        $pageContent = <<<HERE
        <h2> Hello $userName!</h2>
        <p>Your email is $email.<br>
        Your favorite instrument is $instrument.<br>
        Your favorite animals are $animal1 and $animal2.<br>
        Your facorite activity is $activity.</p>
        HERE;

$pageContent .= "<pre>";
$pageContent .= print_r($_POST, true);
$pageContent .= "</pre>";

} else {
    foreach ($instrumentArray as $instrumentName) {
        $instrumentList .= <<<HERE
        <input type="radio" name="instrument" id="$instrumentName" value="$instrumentName" $instrumentChecked>
        <label for="$instrumentName">$instrumentName</label>&emsp;\n
    HERE;
    }
    foreach ($animalArray as $animalIndex => $animalName) {
        $animalList .= <<<HERE
        <input type="checkbox" name="animal[$animalName]" id="$animalIndex" value="$animalName" $animalChecked>
        <label for="$animalIndex">$animalName</label>&emsp;\n
    HERE;
    }
    foreach ($activityArray as $activityName) {
        $activityList .= <<<HERE
        <option value="$activityName" $activityChecked[$activityName]>$activityName</option>\n
    HERE;
    }

$pageContent = <<<HERE
<fieldset class="container pl-2">
    <legend> Sample Form </legend>
        <form method="post" action="form-validation.php">
            <p>
                <label for="userName">Name $userNameError</label><br>
                <input type="text" name="userName" id="userName" value="$userName" class="form-control">
            </p>
            <p>
                <label for="email">Favorite Email $emailError</label>
                <input type="text" name="email" id="email" value="$email" class="form-control">
            </p>
            <div class="form-group"> 
                <label for="instrument">Favorite Instrument - Pick 1 $instrumentError</label><br>
                $instrumentList
            </div>
            <div class="form-group">
                <label for="animals">Favorite Animals - Pick 2 $animalError</label><br>
                $animalList
            </div>
            <div class="form-group"> 
                <label for="activity">Favorite Activity $activityError</label><br>
                <select name="activity" id="activity" class="form-control">
                    <option value="">&larr; Please Select an Activty &rarr;</option>
                    $activityList
                </select> 
            </div>
            <p class="form-group">
                <button type="submit" name="submit" value="Submit" class="btn btn-primary">Submit</button>
            </p>
    </form>
</fieldset>
HERE;
}

$pageTitle = "Form Validation";
include 'template.php';
?>

<!-- <!DOCTYPE html>
<html lang="en">

   <head>
      <meta charset="UTF-8">
      <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
      <title></title>
   </head>

   <body>
      <header>2024FA-ITSE-1306-21701-PHP Programming | Anthony Reyna</header>
      <nav>
         <a href="index.php">Home</a>
         <a href="array.php">Array</a> |
         <a href="form.php">Form</a> |
         <a href="invoice.php">Invoice</a>
      </nav>
    
      <div class="container">

            <header>
                <h1>Form Validation</h1>
            </header>

            <nav>
                <a href="index.php">Home</a> | <a href="form.php">Order Form</a>
            </nav>

            <section>
                <h2>Practice Form</h2>
                    <p>Please make your selections from the form below.</p>
            </section>
        </div>
    </body>

   <footer>
        <p>&copy; Anthony Reyna, MyWebTraining, 2024</p>
   </footer>

</html> -->