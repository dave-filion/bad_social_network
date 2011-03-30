<?php
require "../functions/dbconnect.php";
$link = connect_to_database();

$user_id = $_POST['user_id'];
$status  = $_POST['new_status'];

$clear   = $_GET['clear'];

if($clear == 1){
	$user_id = $_COOKIE['user_id'];
	$q = "UPDATE users SET status = '' WHERE user_id = '$user_id'";
	mysql_query($q,$link);
	header("Location: ../profile.php?user_id=$user_id");	
}else{
	//update status field
	$q = "UPDATE users SET status = '$status' WHERE user_id = '$user_id'";
	mysql_query($q,$link);
	//put in recent updates table
	$q = "INSERT INTO recent_updates (status,user_id) VALUES('$status','$user_id')";
	mysql_query($q,$link);
	header("Location: ../profile.php?user_id=$user_id");
}
?>