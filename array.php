<?php

$albumRatings = ["Mama's Gun" => "9", "Introspection" => "8", "Stereotype A" => "10", "Marble" => "7", "This is the One" => "8"];
$albumRatings["Abbey Road"] = "10";
 
$ratingList = "";
ksort($albumRatings);
foreach ($albumRatings as $albumTilte => $rating) {
    $ratingList .="\n<p>$albumTitle is a $rating out of 10.</p>";
}

$beatles = ["A Hard Day's Night"=>"1964", "Help!"=>"1965", "Rubber Soul"=>"1965", "Abbey Road"=>"1969"];
$ledZepplin = ["Led Zepplin IV"=>"1971"]; 
$rollingStones = ["Let It Bleed"=>"1969", "Sticky Fingers"=>"1971"];
$theWho = ["Tommy"=>"1969", "Quadrophenia"=>"1973", "The Who by Numbers"=>"1975"];

$band = ["The Beatles" => $beatles, "Led Zepplin" => $ledZepplin, "Rolling Stones" => $rollingStones, "The Who" => $theWho];

$whoValue = $band ["The Who"] ["1969"];

$bandList = "";
foreach ($band as $bandName => $albumList) {
    $bandList .="\n<h2>$band</h2><ul>";
    foreach ($albumList as $songTitle => $songYear) {
        $bandList .="\n<li>$songTitle - $songYear</li>";
    }
    $bandList .="\n</ul>";
}

$whoList = "";
foreach ($band as $bandName => $albumList) {
    if ($bandName == "The Who") {
		$whoList .="\n<h2>$bandName</h2><ul>";
        foreach ($albumList as $songTitle => $songYear) {
            $whoList .="\n<li>$songTitle - $songYear</li>";
        }
        $whoList .="\n</ul>";
    }
}

$seventiesList = "";
foreach ($band as $bandName => $albumList) {
    $seventiesList .="\n<h2>$band</h2><ul>";
    foreach ($albumList as $songTitle => $songYear) {
        if (in_array($songYear = "1971", "1973", "1975")) {
            $seventiesList .="\n<li>$songTitle - $songYear</li>";
        }
        $seventiesList .="\n</ul>";
    }
}
$pageContent = '<h1>"Favorite Albums"</h1>' . $ratingList . $whoValue . $bandList . $whoList . $seventiesList;
echo $pageContent;

//First Test
//Second Test

?>