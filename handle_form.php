<?php

$shipping = 2.99;
$downloadPrice = 9.99;
$cdPrice = 12.99;
$heading = "Cost by Quantity";
$orderList = '';


if (empty($_POST['userName'])) {
    $userName = "Guest";
    $userNameError = "<p class='error'>Username was missing from the form submission and is required to process your order. Please <a href='form.php'>go back to the order form</a> and complete the form.</p>";
} else {
    $userName = $_POST['userName'];
    $userNameError = NULL;
}

if (empty($_POST['quantity'])) {
    $quantity = NULL;
    $quantityError = "<p class='error'>Quantity was missing from the form submission and is required to process your order. Please <a href='form.php'>go back to the order form</a> and complete the form.</p>";
} else {
    $quantity = $_POST['quantity'];
    $quantityError = NULL;
}

if (!isset($_POST['media'])) {
    $media = NULL;
    $mediaError = "<p class='error'>Media selection was missing from the form submission and is required to process your order. Please <a href='form.php'>go back to the order form</a> and complete the form.</p>";
} else {
    $media = $_POST['media'];
    $mediaError = NULL;
}

if ($media == "cd") {
    for ($i = 1; $i <= $quantity; $i++) {
        $totalCDPrice = $i * ($cdPrice + $shipping); 
        $orderList .= "<p>The price for $i CD(s) is $totalCDPrice.<p>";
    }
}

if ($media == "download") {
    $i = 1;
    while ($i <= $quantity) {
        $totalDownloadPrice = $quantity * ($downloadPrice + $shipping);
        $orderList .= "<p>The price for $i Download(s) is $totalDownloadPrice.<p>"; 
        $i++;
    }
}
?>

<!DOCTYPE html>
<html lang="en">

    <head>
        <meta charset="utf-8">
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
        <title>Form Processing</title>
    </head>

    <body>
        <div class="container pl-2">
            <header>
                <h1>Form Processing</h1>
            </header>

            <nav>
			    <a href="index.php">Home</a> | <a href="form.php">Order Form</a>
		    </nav>

            <section>
				<h2><?php echo $heading; ?> - <?php echo $media; ?></h2>
				<article>
                    <?php
                        echo "<h3>Order for $userName</h3>";
                        echo $orderList;
                        echo $userNameError;
                        echo $quantityError;
                        echo $mediaError;
                    ?>
				</article>
			</section>
        </div>
    </body>

</html>