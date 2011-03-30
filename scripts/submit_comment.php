<?php
require "../functions/dbconnect.php";
$link = connect_to_database();

$comment_text = strip_tags($_POST['comment_text']);
$post_id      = $_POST['post_id'];
$col_num      = $_POST['col_num'];

$user_id      = $_COOKIE['user_id'];
$user         = $_COOKIE['user_name'];

//random assignment
if($col_num == 0){
	$col_num = rand(1,3);
}

$q = "INSERT INTO comments
 	  (comment_text,post_id,col_num,author,author_id,karma) 
	  VALUES
 ('$comment_text','$post_id','$col_num','$user','$user_id',0)";

mysql_query($q,$link) or die(mysql_error());
header("Location: ../post.php?post_id=$post_id");
?>