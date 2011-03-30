<?php
require "../functions/dbconnect.php";
$link = connect_to_database();

$id      = $_GET['id'];
$user_id = $_COOKIE['user_id'];

if(!$id){
	die("ID wasn't supplied");
}else{
	$query = "DELETE from posts WHERE post_id='$id'";
	mysql_query($query);
	
	$query = "DELETE from comments WHERE post_id='$id'";
	mysql_query($query);
	
	$query = "DELETE from comment_check WHERE post_id='$id'";
	mysql_query($query);
	
	$query = "UPDATE users SET karma = karma-1 WHERE user_id = '$user_id'";
	mysql_query($query);
	
	header("Location: ../index.php");
}
?>