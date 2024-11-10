<?php

$conn = mysqli_connect("localhost", "MartyAllen", "KUE7r2kX34kf3","sherd_MartyAllen");

if (!$conn) {
	echo "Failed to connect to MySQL: ".mysqli_connect_error();
} else {
	echo "Connection ok.";
}

$result = mysqli_query(connName, query);

$query = "SHOW GRANTS;";
$result = mysqli_query($conn,$query);
if (!$result) {
	die(mysqli_error($conn));
}
while ($row = mysqli_fetch_array($result)) {
	$permissions = $row[0];
	echo "$permissions<br>";
}

if (mysqli_num_rows($result) > 0) {
} else {
	echo "0 results";
}

while ($row = mysqli_fetch_assoc($result)) {
	echo $row['fieldName'];
}

?>