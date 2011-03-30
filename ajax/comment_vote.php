<?php

require "../functions/dbconnect.php";
$link = connect_to_database();

$post_id    = $_POST['post_id'];
$comment_id = $_POST['comment_id'];
$user_id    = $_POST['user_id'];
$liked      = $_POST['liked'];

$q = "SELECT * FROM comment_check 
		WHERE user_id = '$user_id' 
		AND comment_id = '$comment_id'";

$result = mysql_query($q,$link);

$num = mysql_num_rows($result);

if($num > 0){
	$row = mysql_fetch_array($result);
	$old_liked = $row['liked'];
	
	if($old_liked != $liked){
		$q = "UPDATE comment_check
				SET liked='$liked'
				WHERE comment_id = '$comment_id'
				AND user_id = '$user_id'";
		mysql_query($q);
		
		if($liked == 1){
			//its +2 to make up for the inital -1
			$q = "UPDATE comments 
					SET karma=karma+2 
					WHERE comment_id = '$comment_id'";
			mysql_query($q,$link);
		}else if($liked == -1){
			//its -2 to make up for the inital +1
			$q = "UPDATE comments 
					SET karma=karma-2 
					WHERE comment_id = '$comment_id'";
			mysql_query($q,$link);		
		}else{

		}
	}

}else{
	$q = "INSERT INTO comment_check (comment_id,user_id,liked,post_id) 
			VALUES ('$comment_id','$user_id','$liked','$post_id')";
	mysql_query($q,$link);
	
	if($liked == 1){
		$q = "UPDATE comments 
				SET karma=karma+1 
				WHERE comment_id = '$comment_id'";
		mysql_query($q,$link);
	}else if($liked == -1){
		$q = "UPDATE comments 
				SET karma=karma-1 
				WHERE comment_id = '$comment_id'";
		mysql_query($q,$link);		
	}else{
		
	}
}


?>