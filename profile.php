<?php
$login = $_COOKIE['LOGON'];	
if(!$login)
{
	header("Location:welcome.php");
}

require "functions/dbconnect.php";
require "functions/dome.php";
require "models/Models.php";
$link = connect_to_database();

$user_id  = $_GET['user_id'];

//CHECK FOR OWN PROFILE
if($user_id == $_COOKIE['user_id']){
	$ownProfile = 1;
}

//CHECK FOR ALREADY FRIENDS
$already_friends = already_friends($_COOKIE['user_id'],$user_id,$link);

//CHECK FOR PENDING FRIENDS
if(!$already_friends){
	$pending_friends = pending_friends($_COOKIE['user_id'],$user_id,$link);
}

//get users info
$user = new User($user_id);
$name        = $info['name'];
$cleanName   = $user->name;
$date_joined = $user->date_joined;
$karma       = $user->karma;
$profile_pic = $user->profile_pic;
$status      = $user->status;
	
//HTML reformating... THIS PART FUCKING SUCKS PLEASE FIX IT
$profile_pic = "<a href='$profile_pic' title='$name' ><img src='$profile_pic' /></a>";
$name        = "<h1>$name</h1>";
if($ownProfile){
	$change_pic = "<a href='#' id='changePic'>change pic</a>";
}else{
	$change_pic = "";
}

$change_pic_form = 
"<a href='#' id='closePicForm'>close</a>			
<form action='scripts/upload_profile_pic.php' method='post'
enctype='multipart/form-data'>
   <input type='hidden' name='MAX_FILE_SIZE' value='500000' />
<input type='hidden' name='user_id' value='$user_id' />
<input type='file' name='pic' id='pic' />
<br />
<input type='submit' name='submit' value='Upload' />
</form>";

if(!$ownProfile && !$already_friends && !$pending_friends){
	$add_friend_button = "
	<form action='scripts/add_friend.php' method='post'>
	<input type='hidden' name='friend_id' value='$user_id'>
	<input type='hidden' name='friend_name' value='$cleanName'>
	<input type='submit' id='addFriendButton' value='add friend'>
	</form>";
}else if($pending_friends ==1){
	$add_friend_button = "<p>Pending Friends</p>";
}else{
	$add_friend_button = "";
}

$friend_id = $_POST['friend_id'];
$friend_name = $_POST['friend_name'];

if($status){
	$status = "<p class='status'>$status</p>";
}else{
	$status = "<p class='status'>What's on your mind?</p>";
}
if($ownProfile){
	$status_change =
	"<a href='#' id='status_change'>change</a>
	 <a href='scripts/change_status.php?clear=1'
	 	id='status_clear'>clear</a>
	";
}else{
	$status_change = "";
}
$status_update = 
"<a href='#' id='close_status'>close</a>
<form action='scripts/change_status.php' 
	method='post' 
	accept-charset='utf-8'>
<input type='text' name='new_status' id='new_status' />
<input type='hidden' name='user_id' value='$user_id' id='user_id'/>
<input type='submit' value='update' id='change_status_submit' />
</form>";
$rep         = "<h2>Current Rep: $karma</h2>";

$q = "SELECT * FROM comment_check WHERE user_id='$user_id' AND liked=-1";
$result = mysql_query($q,$link);
$numDislike = mysql_num_rows($result);
$q = "SELECT * FROM comment_check WHERE user_id='$user_id' AND liked=1";
$result = mysql_query($q,$link);
$numLike = mysql_num_rows($result);


$likeAndDislike = "<h2>Has liked $numLike things, and disliked $numDislike</h2>"; 

$date_joined = "<h2>Part of it since: $date_joined";

$posts = get_user_posts($user_id,5,$link);
while($post = mysql_fetch_array($posts))
{
	$post_title = stripslashes($post['title']);
	$post_id    = $post['post_id'];
	$karma      = $post['karma'];
	
	$posts_output .= "<div class='postRow'>
						<p>($karma)</p>
						<a href='post.php?post_id=$post_id'>
						$post_title</a>
					  </div>";
}

$friends = get_user_friends($user_id,9,$link);
while($friend = mysql_fetch_array($friends))
{
	$friend_name = $friend['friend'];
	$friend_id   = $friend['friend_id'];
	$q = "SELECT profile_pic FROM users WHERE user_id = $friend_id";
	$result = mysql_query($q,$link);
	$row    = mysql_fetch_array($result);
	$pic    = $row['profile_pic'];

	$friends_output .= "<div class='friend'>
						<a href='profile.php?user_id=$friend_id'>
						<img src='$pic' />
						$friend_name</a>
						</div>";
} 
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
	"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html>
<head>
	<title>profile</title>
	<link rel="stylesheet" href="css/master.css" type="text/css">
	<link rel="stylesheet" href="css/profile.css" type="text/css">
	<script src="js/jq.js"></script>
	<script src="js/profile.js"></script>
	<script src="js/google.js"></script>
</head>

<body>

<?php require "include/header.php"; ?>

<div id="all">
	<?php require "include/navbar.php"; ?>

	<div id="profileLeftBar">
		<div id="pictureBox">
			<?php echo $name;        ?>
			<?php echo $profile_pic; ?>
			<?php echo $change_pic;  ?>

			<div id="changePicForm">
				<?php echo $change_pic_form; ?>
			</div>		
		</div>
		
		<?php echo $add_friend_button; ?>
		
		<div id="friendsBox">
			<h1>Friends</h1>
			<?php echo $friends_output; ?>
			<a href="all_friends.php?user_id=<?php echo $user_id; ?>">see all friends</a>
		</div>
		
		
	</div>

	<div id="content">
		<div id="profileBox">
			
			<?php echo $status; ?>
			
			<div id="status_change_box">
				<?php echo $status_change; ?>
			</div>
					
			<div id="statusUpdate">
				<?php echo $status_update; ?>
			</div>
			
			<?php echo $rep; ?>	
			<?php echo $likeAndDislike; ?>		
			<?php echo $date_joined; ?>
			
			<h2>Latest Posts:</h2>
			<?php echo $posts_output; ?>
		</div>
		
		<?php require "include/wall.php"; ?>
		
		
	</div>

	<?php require "include/footer.php" ?>
	
</div>
</body>

</html>