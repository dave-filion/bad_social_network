<?php 

//returns 1 if already friends, otherwise 0
function already_friends($user_id,$friend_id,$link){
	$q = "SELECT * FROM friends WHERE user_id='$user_id' AND friend_id='$friend_id'";
	$result = mysql_query($q,$link);
	$num = mysql_num_rows($result);
	if($num > 0){
		return 1;
	}else{
		return 0;
	}
}

function get_user_info($user_id,$link){
	$q = "SELECT * FROM users WHERE user_id=$user_id";
	$result = mysql_query($q,$link);

	$row = mysql_fetch_array($result);

	$name        = $row['name'];
	$date_joined = $row['date_joined'];
	$karma       = $row['karma'];
	$profile_pic = $row['profile_pic'];
	$status      = $row['status'];
		
	date_default_timezone_set('America/New_York');
	$dt = date("l, M d",$date_joined);
	
	$info = array('name' => $name, 'date_joined' => $dt, 'karma' => $karma, 'profile_pic' => $profile_pic, 'status' => $status);
	
	return $info;
}

function get_user_posts($user_id,$num_of_posts,$link){
	$q = "SELECT * FROM posts WHERE author_id = '$user_id' ORDER BY post_id DESC LIMIT 0,$num_of_posts";
	$result = mysql_query($q,$link);
	return $result;
}

function get_user_friends($user_id,$num_of_friends,$link){
	$q = "SELECT * FROM friends WHERE user_id = '$user_id' LIMIT 0,$num_of_friends";
	$result = mysql_query($q,$link);
	return $result;
}

//returns friends profile pic
function get_friend_pic($friend_id,$link){
	$q = "SELECT profile_pic FROM users WHERE user_id = '$friend_id'";
	$result = mysql_query($q,$link);
	$pic_row = mysql_fetch_array($result);
	$pic = $pic_row['profile_pic'];
	return $pic;
}

//print random word for "friend"		
function get_friend_word(){
	$friend_words = array("buddies","pals","chums","allies","mates");
	$max   = count($friend_words) - 1;
	$index = rand(0,$max);
	$friend_word = $friend_words[$index];
	return $friend_word;
}


?>
