<?php
require "../functions/dbconnect.php";
$link = connect_to_database();

$user_name = $_COOKIE['user_name'];
$user_id = $_POST['user_id'];

$name     = $_FILES['pic']['name'];
$type     = $_FILES['pic']['type'];
$size     = $_FILES['pic']['size'];
$tmp_name = $_FILES['pic']['tmp_name'];
$error    = $_FILES['pic']['error'];

if($type == 'image/jpeg'){
	$type = '.jpeg';
}else if($type == 'image/jpg'){
	$type = '.jpg';
}else if($type == 'image/png'){
	$type = '.png';
}else{
	echo 'illegal file format';
	$error = 1;
}

$FINAL_NAME = $user_id . $type;

$DEST = "/home/users/web/b614/ipg.domepagenet/uploads/profile_pics/$FINAL_NAME";
$DBNAME = "uploads/profile_pics/$FINAL_NAME";

if($error ==0){
	
	if(is_uploaded_file($tmp_name)){
		
		move_uploaded_file($tmp_name,$DEST);
		$q = "UPDATE users SET profile_pic = '$DBNAME'  WHERE user_id = '$user_id'";
		mysql_query($q);
		header("Location: ../profile.php?user_id=$user_id");
	}
	
}else{
	echo "ERROR";
}

?>