<?php
require "../functions/dbconnect.php";
$link = connect_to_database();

$friend_name = $_POST['friend'];
$friend_id   = $_POST['friend_id'];
$user_name   = $_COOKIE['user_name'];
$user_id     = $_COOKIE['user_id'];

if($user_id == $friend_id){
	die("same person");
}else{
	$q = "INSERT INTO friends (user,friend,user_id,friend_id) VALUES ('$user_name','$friend_name','$user_id','$friend_id')";
	mysql_query($q);
	$q = "INSERT INTO friends (user,friend,user_id,friend_id) VALUES ('$friend_name','$user_name','$friend_id','$user_id')";
	mysql_query($q);
	$q = "DELETE FROM friend_requests WHERE user_id = '$friend_id' AND requested_friend_id = '$user_id'";
	mysql_query($q);

	//update user karma
	$q = "UPDATE users SET karma = karma+1 WHERE user_id = $user_id";
	mysql_query($q);
	$q = "UPDATE users SET karma = karma+1 WHERE user_id = $friend_id";
	mysql_query($q);


	header("Location:../profile.php?user_id=$user_id");
}
?>