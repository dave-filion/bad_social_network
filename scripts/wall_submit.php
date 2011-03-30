<?php

require "../functions/dbconnect.php";
require "../functions/dome.php";
$link = connect_to_database();

$user      = $_POST['user_name'];
$user_id   = $_POST['user_id'];
$friend    = $_COOKIE['user_name'];
$friend_id = $_COOKIE['user_id'];
$content   = strip_tags(mysql_real_escape_string($_POST['content']));
$karma     = 0;

$q = "INSERT INTO wall (user,user_id,friend,friend_id,content,karma) 
	  VALUES ('$user','$user_id','$friend','$friend_id','$content','$karma')";
mysql_query($q,$link);

if($user_id != $friend_id){
	$q = "UPDATE users SET karma = karma + 1 WHERE user_id = '$friend_id'";
	mysql_query($q,$link);
}

header("Location: ../profile.php?user_id=$user_id");
?>