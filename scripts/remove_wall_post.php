<?php
	require "../functions/dbconnect.php";
	$link = connect_to_database();
	
	$id = $_GET['id'];
	$user_id = $_GET['user_id'];
		
	$q = "DELETE FROM wall WHERE id='$id'";
	mysql_query($q,$link);
	
	$q = "UPDATE users SET karma = karma-1 WHERE user_id = '$user_id'";
	mysql_query($q);
	
	header("Location: ../profile.php?user_id=$user_id");
?>