<?php

$pageTitle = "Form Validation";

$userName = NULL;
$email = NULL;
$instrument = NULL;
$guitarChecked = NULL;
$pianoChecked = NULL;
$lyreChecked = NULL;
$fluteChecked = NULL;
$animal = NULL;
$animalChecked = NULL;
$animalChecked = NULL;
$animalChecked = NULL;
$animalChecked = NULL;
$activity = NULL;
$activityChecked = NULL;
$activityChecked = NULL;
$activityChecked = NULL;
$activityChecked = NULL;

$userNameError = NULL;
$emailError = NULL;
$instrumentError = NULL;
$animalError = NULL;
$activityError = NULL;

$valid = false;

if (isset($_POST['submit'])) {
	$valid = true;
	$userName = htmlspecialchars($_POST['userName']);
	if (empty($userName)) {
		$userNameError = "<span class='error'>You must enter a user name.</span>";
		$valid = false;
	}
	$email = htmlspecialchars($_POST['email']);
	if (empty($email)) {
		$emailError = "<span class='error'>You must enter an album</span>";
		$valid = false;
	}
	if (isset($_POST['instrument'])) {
		$instrument = $_POST['instrument'];
		if ($instrument == "guitar") {$guitarChecked = "checked";}
		if ($instrument == "piano") {$pianoChecked = "checked";}
        if ($instrument == "lyre") {$lyreChecked = "checked";}
		if ($instrument == "flute") {$fluteChecked = "checked";}
	} else {
		$instrumentError = "<span class='error'>Please select an instrument.</span>";
		$valid = false;
	}
    if (isset($_POST['animal'])) {
		$animal = $_POST['animal'];
		if ($animal == "guitar") {$guitarChecked = "checked";}
		if ($animal == "piano") {$pianoChecked = "checked";}
        if ($animal == "lyre") {$lyreChecked = "checked";}
		if ($animal == "flute") {$fluteChecked = "checked";}
        //$checked_count = count($_POST['animal']);
	} else {
		$animalError = "<span class='error'>Please select two animals.</span>";
		$valid = false;
	}
    /*if (isset($_POST['instrument'])) {
		$instrument = $_POST['instrument'];
		if ($instrument == "guitar") {$guitarChecked = "checked";}
		if ($instrument == "piano") {$pianoChecked = "checked";}
        if ($instrument == "lyre") {$lyreChecked = "checked";}
		if ($instrument == "flute") {$fluteChecked = "checked";}
	} else {
		$instrumentError = "<span class='error'>Please select an instrument.</span>";
		$valid = false;
	}*/
    if (isset($_POST['activity'])) {
        $activity = $_POST['activity'];
        echo $activity;
    } else {
        $activityError = "<span class='error'>Please select an activity.</span>"
    }
}

?>

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
                    <fieldset class="pl-2">
                        <legend> Sample Form </legend>
                        <form method="post" action="form-validation.php">
                            <p>
                                <label for="userName">Name</label><br>
                                <input type="text" name="userName" id="userName" value="" class="form-control">
                            </p>
                            <p>
                                <label for="email">Favorite Email </label>
                                <input type="text" name="email" id="email" value="" class="form-control">
                            </p>
                            <div class="form-group"> 
                                <label for="instrument">Favorite Instrument - Pick 1 </label><br>
                                <input type="radio" name="instrument" id="Guitar" value="Guitar" >
                                <label for="Guitar">Guitar</label>&emsp;
                                <input type="radio" name="instrument" id="Violin" value="Violin" >
                                <label for="Violin">Violin</label>&emsp;
                                <input type="radio" name="instrument" id="Piano" value="Piano" >
                                <label for="Piano">Piano</label>&emsp;
                                <input type="radio" name="instrument" id="Saxaphone" value="Saxaphone" >
                                <label for="Saxaphone">Saxaphone</label>&emsp;

                            </div>
                            <div class="form-group">
                                <label for="animals">Favorite Animals - Pick 2 </label><br>
                                <input type="checkbox" name="animals[0]" id="0" value="Dogs" >
                                <label for="0">Dogs</label>&emsp;
                                <input type="checkbox" name="animals[1]" id="1" value="Cats" >
                                <label for="1">Cats</label>&emsp;
                                <input type="checkbox" name="animals[2]" id="2" value="Snakes" >
                                <label for="2">Snakes</label>&emsp;
                                <input type="checkbox" name="animals[3]" id="3" value="Rabbits" >
                                <label for="3">Rabbits</label>&emsp;

                            </div>
                            <div class="form-group"> 
                                <label for="activity">Favorite Activity </label><br>
                                <select name="activity" id="activity" class="form-control">
                                    <option value="">&larr; Please Select an Activity &rarr;</option>
                                    <option value="Tennis" >Tennis</option>
                                    <option value="Fencing" >Fencing</option>
                                    <option value="Hanafuda" >Hanafuda</option>
                                    <option value="Mancala" >Mancala</option>
                                    <option value="Chess" >Chess</option>

                                </select> 
                            </div>
                            <p class="form-group">
                                <button type="submit" name="submit" value="Submit" class="btn">Submit</button>
                            </p>
                        </form>
                    </fieldset>
            </section>
        </div>
    </body>

   <footer>
        <p>&copy; Anthony Reyna, MyWebTraining, 2024</p>
   </footer>

</html>