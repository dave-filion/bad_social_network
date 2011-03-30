<?php
require "../functions/dbconnect.php";
$link = connect_to_database();

$friend_id = $_POST['friend_id'];
$friend_name = $_POST['friend_name'];

$user_name = $_COOKIE['user_name'];
$user_id   = $_COOKIE['user_id'];


$q = "SELECT * FROM friend_requests WHERE user_id = '$user_id' AND requested_friend_id = '$friend_id'";
$result = mysql_query($q);
if(mysql_num_rows($result) > 0){
	header("Location: ../profile.php?user_id=$friend_id&aa=1");
}


else{
	$q = "INSERT INTO friend_requests (user,requested_friend,user_id,requested_friend_id) VALUES ('$user_name','$friend_name','$user_id','$friend_id')";
	mysql_query($q);
		
	header("Location:../profile.php?user_id=$friend_id");
}

?>