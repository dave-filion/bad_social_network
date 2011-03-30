<?php
require "../functions/dbconnect.php";
$link = connect_to_database();

$link_title = strip_tags($_POST['link_title']);
$link_url   = strip_tags($_POST['link_url']);

if(!$link_url || !$link_title || !$link){
	header("Location: ../index.php");
}else{

	$author  = $_COOKIE['user_name'];
	$author_id = $_COOKIE['user_id'];
	
	$link_title = mysql_real_escape_string($link_title);
	$link_url = mysql_real_escape_string($link_url);
	$time_posted = time();
	
	$link_title = "<a href=$link_url>$link_title</a>";
		
	$q = "INSERT INTO posts
	    (title,content,time_posted,author,author_id,link)
		VALUES('$link_title','$link_title','$time_posted','$author','$author_id','1')";
		
	mysql_query($q,$link) or die(mysql_error());
	
	header("Location: ../index.php");
}

?>