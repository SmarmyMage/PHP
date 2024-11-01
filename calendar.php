<?php
$pageContent = NULL;
$dateContent = NULL;
$timeContent = NULL;
$seasonContent = NUll;
$holidayContent = NULL;
$amChecked = $pmChecked = NULL;

date_default_timezone_set('America/Chicago');

$ampm = date('A');
$seconds = date('s');
$minutes = date('i');
$hours = date('g');
$displayHours = $hours;
$month = date('m');
$day = date('j');
$year = date('Y');


if(filter_has_var(INPUT_POST, 'submit')) {
    $ampm = filter_input(INPUT_POST, 'ampm');
    $seconds = filter_input(INPUT_POST, 'seconds');
    $minutes = filter_input(INPUT_POST, 'minutes');
    $displayHours = filter_input(INPUT_POST, 'hours');
    $month = filter_input(INPUT_POST, 'month');
    $day = filter_input(INPUT_POST, 'day');
    $year = filter_input(INPUT_POST, 'year');
    $hours = $displayHours;
}

if($ampm == 'PM') {
    if($hours < 12) {
        $hours += 12;
    }
    $pmChecked = "checked";
} else {
    if($hours == 12) {
        $hours = 0;
    }
    $amChecked = "checked";
}

$today = mktime($hours,$minutes,$seconds,$month,$day,$year);

$timeForm = <<<HERE
<p>You can enter another time here and show the results below.</p>
<form method="post>
<input type="number" name="hours" value="$displayHours" placeholder="HH" size="3" min="1" max="12">
<input type="number" name="minutes" value="$minutes" placeholder="MM" size="3" min="0" max="59">
<label><input type="radio" name="ampm" value="AM" $amChecked>&nbsp;AM</label>
<label><input type="radio" name="ampm" value="PM" $pmChecked>&nbsp;PM</label>
<input type="submit" name="submit" value="Show Selected Time">
<input type="submit" name="reset" value="Show Current Time">
HERE;

$monthSelect = array(1 => 'January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December');
$monthList = NULL;
foreach ($monthSelect as $key => $value) {
    if($key == $month) {
        $monthList .= <<<HERE
        <option value="$key" selected><$value</option>\n
    HERE;
    } else {
        $monthList .= <<<HERE
        <option value="$key">$value</option>\n
    HERE;
    }
}
$dayList = NULL;
for ($i=1; $i<=31; $i++) {
    if($i == $day) {
        $dayList .= <<<HERE
        <option value="$i" selected>$i</option>\n
    HERE;
    } else {
        if($i == $day)
            $dayList .= <<<HERE
            <option value="$i">$i</option>\n
        HERE;
    }
}
$yearList = NULL;
for ($j = date('Y'); $j >= 2000; $j--) {
    if($j == $year) {
        $yearList .= <<<HERE
        <option value="$j" selected>$j</option>\n
    HERE;
    } else {
        $yearList .= <<<HERE
        <option value="$j">$j</option>\n
    HERE;
    }
}

$dateForm = <<<HERE
<p>You can enter another date and show the results below?</p>
<select name="month">
    $monthList
</select>
<select name="day">
    $dayList
</select>
<select name="year">
    $yearList
</select>
<input type="submit" name="submit" value="Show Selected Date">
<input type="submit" name="reset" value="Show Current Date">
</form>
HERE;

$currentDate = date('1, F j, Y', $today);
$currentTime = date('g:i A', $today);
$dateContent = <<<HERE
<h2>Hello, there! Today is $currentDate. The current time is $currentTime.</h2>
HERE;

$morning = 6;
$afternoon = 12;
$evening = 18;

if ($hours >= $evening) {
    $timeContent .= <<<HERE
    <figure>
        <img src='images/evening.jpg' alt="Evening Moon Image">
        <figcaption>It's the evening...</figcaption>
    </figure>
HERE;
} else if ($hours >= $daytime) {
    $timeContent .= <<<HERE
    <figure>
        <img src='images/afternoon.jpg' alt="Afternoon Sun Image">
        <figcaption>It's the afternoon...</figcaption>
    </figure>
HERE;
} else {
    $timeContent .= <<<HERE
    <figure>
        <img src='images/morning.jpg' alt="Morning Sunrise Image">
        <figcaption>It's the morning...</figcaption>
    </figure>
HERE;
}

$day1 = Date('z',strtotime("February 14"));
$day2 = date('z', $today);
if ($day1 == $day2) {
    $holidayContent .= <<<HERE
    <figure>
        <img src='valentines_day.jpg' alt="Valentine's Day Tree">
        <figcaption>Happy Valentine's Day!</figcaption>
    </figure>
HERE;
} elseif ($day1 > $day2) {
    $diff = $day1 - $day2;
    $holidayContent .= <<<HERE
    <figure>
        <img src='holiday.jpg' alt="Holiday Image">
        <figcaption>There are $diff day(s) until Valentine's Day.</figcaption>
    </figure>
HERE;
} else {
    $day4 = date('z', strtotime("February 14"));
    $day3 = date('z', strtotime("February 14 +1 year"));
    $diff = ($day4 - $day2) + $day3;
    $holidayContent .= <<<HERE
    <figure>
        <img src='holiday.jpg' alt="Holiday Image">
        <figcaption>There are $diff day(s) until next Valentine's Day.</figcaption>
    </figure>
    HERE;
}

$pageContent .= <<<HERE
$dateContent
<div class="container">
    <div class="row>
        <div class="col-md>
            $timeContent
        </div>
        <div class="col-md>
            $seasonContent
        </div>
        <div class="col-md>
            $holidayContent
        </div>
    </div>
    $timeForm
    $dateForm
</div>
HERE;

$postArray = "<pre>";
$postArray = print_r($_POST, true);
$postArray = "</pre>";
$pageContent .= $postArray;
$pageContent .= $hours;

$pageTitle = "My Calendar";
include 'template.php';
?>