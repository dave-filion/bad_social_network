<?php


/**
 * Renders HTML using supplied template and info. 
 * Supplied css and script is inserted.
 */
function render($template,$css,$script,$info){
   $template = fopen($template, "r");
   $info["css"]    = $css;
   $info['script'] = $script;
   
   while($c = fgetc($template))
   {
      if($c == '{')
      {
         $keyword = "";
         $w = fgetc($template);
      
         while($w != '}')
         {
            $keyword .= $w;
            $w = fgetc($template);
         }
      
         echo $info[$keyword];
         $c = fgetc($template);
      
      }
      echo $c;
   }
}

function get_wall_output($user_id,$link){
	$q = "SELECT * FROM wall 
		  WHERE user_id = '$user_id'
		  ORDER BY id DESC LIMIT 0,10";
	$result = mysql_query($q,$link);
	
	while($row = mysql_fetch_array($result)){
		$friend    = $row['friend'];
		$friend_id = $row['friend_id'];
		$content   = stripslashes($row['content']);
		$karma     = $row['karma'];
		$id        = $row['id'];
				
		$q1 = "SELECT profile_pic FROM users WHERE user_id = '$friend_id'";
		$result1 = mysql_query($q1,$link);
		$row1 = mysql_fetch_array($result1);
		$profile_pic = $row1['profile_pic'];
		
		if($_COOKIE['user_id'] == $friend_id || $_COOKIE['user_id'] == $user_id){
			$delete = "<a href='scripts/remove_wall_post.php?id=$id&user_id=$user_id' class='delete'>remove</a>";
		}else{
			$delete = "";
		}
		
		$wall_ouput .= "<div class='wall_post'>
							<div class='image_box'>
								<a href='profile.php?user_id=$friend_id'>
								<img src='$profile_pic' />
								$friend
								</a>
							</div>
						<p>$content</p>
						$delete
						</div>";
	}
	
	return $wall_ouput;
}


function get_rep_list($num,$link){
	$q = "SELECT * FROM users ORDER BY karma DESC LIMIT 0,$num";
	$result = mysql_query($q,$link);
	$rep_list = "";
	
	while($row = mysql_fetch_array($result))
	{
		$name = $row['name'];
		$id   = $row['user_id'];
		$rep  = $row['karma'];
		
		$rep_list .=
		"<li><a href='profile.php?user_id=$id'>$name - $rep</a></li>";
	}
	
	return $rep_list;
}

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

//returns 1 if pending friendship, otherwise 0
function pending_friends($user_id,$friend_id,$link){
	$q = "SELECT * FROM friend_requests 
		  WHERE user_id='$user_id' AND requested_friend_id='$friend_id'";
	$result = mysql_query($q);
	$num1 = mysql_num_rows($result);
	$q = "SELECT * FROM friend_requests 
		  WHERE user_id='$friend_id' AND requested_friend_id='$user_id'";
	$result = mysql_query($q);
	$num2 = mysql_num_rows($result);
	
	if($num1 > 0 || $num2 > 0){
		return 1;
	}else{
		return 0;
	}
}

function get_post_info($post_id,$link){
	$q = "SELECT * FROM posts WHERE post_id='$post_id'";
	$result = "";
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

function get_user_id($user_name,$link){
	$q = "SELECT user_id FROM users WHERE name = '$user_name'";
	$result = mysql_query($q,$link);
	$row = mysql_fetch_array($result);
	$id  = $row['user_id'];
	return $id;
}

//Returns string saying since how long a post
//was posted
function get_time_since($time){

   $ts = time()- $time;
   
   $seconds = $ts % 60;
   $ts = $ts - $seconds;

   $minutes = $ts / 60;

   $hours   = $ts / 3600;

   $days    = $ts / 86400;
   
   if($days >= 1)
   {
      $days = floor($days);
      if($days == 1)return "posted $days day ago";
      else return "posted $days days ago";
   }
   else if($hours >= 1)
   {
      $hours= floor($hours);
      if($hours== 1)return "posted $hours hour ago";
      else return "posted $hours hours ago";
   }
   else if($minutes >= 1)
   {
      $minutes= floor($minutes);
      if($minutes== 1) return "posted $minutes minute ago";
      else return "posted $minutes minutes ago";
   }
   else
      return "posted $seconds seconds ago";
}

?>