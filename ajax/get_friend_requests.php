<?php

echo "<h1>Friend Requests</h1>";

$user_id = $_COOKIE['user_id'];

$q = "SELECT * FROM friend_requests WHERE requested_friend_id = $user_id";
$result = mysql_query($q);

while($row = mysql_fetch_array($result))
{
	print_r($row);
	$user = $row['user'];
	echo "<p>$user</p>";
}

?>