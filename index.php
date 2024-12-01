<?php
include 'config.php';
$pageTitle = "Index";
$pageContent = NULL;
$name = "Anthony Reyna";
$myString = "I know the moon, and this is an alien city - Amy Lowell, A London Throughfare. 2 A.M.";
$brookhavenName = "Dallas College Brookhaven Campus";
$brookhavenStreet = " 3939 Valley View Lane";
$brookhavenCity = " Farmers Branch";
$brookhavenState = " Texas";
$brookhavenPostal = " 75244";
$brookhavenAddress = $brookhavenName . $brookhavenStreet . $brookhavenCity . $brookhavenState . $brookhavenPostal;
$x = 37;
$y = 6;
$sum = $x + $y;
$difference = $x - $y;
$product = $x * $y;
$quotient = $x / $y;
$modulus = $x % $y;
$currentPage= $_SERVER['SCRIPT_NAME'];

$pageContent .= <<<HERE
<p>$name 's PHP Web Page.</p>

\n<p>Hello, and welcome to my page.</p>
\n<p>My name is Anthony Reyna. I am 21 years old, and I am currently a college student.<br>\nI like playing video games, playing D&D, and watching videos on the interent.
\n<p>I am taking this class to learn more programming lanugages, and to complete my Web Design degree.</p>

\n<p>$myString</p>

\n<p>$brookhavenAddress</p>

\n<p> $x + $y = $sum</p>
\n<p> $x -  $y = $difference </p>
\n<p> $x * $y = $product</p>
\n<p> $x / $y = $quotient</p>
\n<p> $x % $y = $modulus</p>

\n<p>$currentPage</p>
HERE;

include 'template.php';

//This is a comment for the assignment.
//This is the first version of the file.
//I will add more comments to show more updates.
//Update One: Forgot to add semicolons to certain lines, and added them where needed.
//Update Two: Added line breaks to sperate everything.

?>