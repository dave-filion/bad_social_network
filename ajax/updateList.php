<?php
require "../functions/dbconnect.php";
$link = connect_to_database();
$offset = $_POST['offset'];

$q = "SELECT * FROM recent_updates ORDER BY update_id DESC LIMIT $offset,7";
$result = mysql_query($q,$link);

while($row = mysql_fetch_array($result)){
	$status  = $row['status'];
	$user_id = $row['user_id'];
	$q = "SELECT name,profile_pic FROM users WHERE user_id='$user_id'";
	$result1 = mysql_query($q);
	$row1 = mysql_fetch_array($result1);
	$pic = $row1['profile_pic'];
	$user = $row1['name'];
	echo '<p class="quote">'.$user. '- "'.$status.'"</p>';
	echo "<a href='profile.php?user_id=$user_id'><img class='pic' src='$pic' /></a>";
	
}

?>