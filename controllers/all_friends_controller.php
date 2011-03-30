<?php
require "functions/dome.php";
require "functions/dbconnect.php";
require "models/Models.php";

$link  = connect_to_database();

$friend_list = get_friend_list($user_id);

$info['friend_list'] = $friend_list;
$template = "templates/all_friends.tmp";
$css      = "css/all_friends.css";
$script   = "js/all_friends.js";

render($template,$css,$script,$info);


function get_friend_list($user_id){
   $q = "SELECT friend_id FROM friends WHERE user_id = '$user_id'";
   $result = mysql_query($q);
   $output = "";
   
   while($row = mysql_fetch_array($result))
   {
      $friend_id = $row['friend_id'];
	  $friend      = new User($friend_id);
	
	  $friend_name = $friend->name;
	  $profile_pic = $friend->profile_pic;
      
      $output .= "<div id=$friend_id class='friend'>
                  <img src='$profile_pic' title='$friend_name' /> 
                  </div>";
   }

   return $output; 
}
?>