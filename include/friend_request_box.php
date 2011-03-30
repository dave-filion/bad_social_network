<?php
$user_id = $_COOKIE['user_id'];

$fq = "SELECT * FROM friend_requests WHERE requested_friend_id='$user_id'";
$fresult = mysql_query($fq);
$fnum = mysql_num_rows($fresult);

if($fnum == 1){
	$word = "request";
}else{
	$word = "requests";
}

if($fnum > 0){
	echo "<div id='friend_request_box'>
			<p>You have $fnum new friend $word!</p>
		  </div>";
}

?>