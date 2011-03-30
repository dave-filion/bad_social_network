<?php
require "../functions/dome.php";
require "../functions/dbconnect.php";
$link = connect_to_database();

$name = $_POST['username'];
$password = $_POST['password'];
$alpha_key = $_POST['alpha_key'];

//check for duplicate username
$dupe = duplicate_name($name,$link);
if($dupe == 1){
	header("Location:../register.php?dupe=1");
}else{	
	if($alpha_key == 'remy9000')
	{
		//enter user in USERS
		enter_user_in_database($name, $password, $link);
		$id = get_user_id($name,$link);

		setcookie('LOGON',1,time()+36000,"/");
		setcookie('user_name',"$name",time()+36000,"/");
		setcookie('user_id',"$id",time()+36000,"/");
	
		header('Location: ../index.php');
	}else{
		header('Location: ../register.php');
	}
}

/*
*check for duplicate name in database
*@return 0 if no, 1 if yes
*/
function duplicate_name($name,$link){
	$q = "SELECT * FROM users WHERE name = '$name'";
	$result = mysql_query($q,$link);
	$num = mysql_num_rows($result);
	
	if($num == 0){
		return 0;
	}else{
		return 1;
	}
}

//puts user into database
function enter_user_in_database($name,$password,$link){
	$cleanName = mysql_real_escape_string($name) or die(mysql_error());
	$encryptedPass = md5($password) or die(mysql_error());
	$date_joined = time();
	$default_pic = "uploads/profile_pics/default.png";

	$query = "INSERT into users (name,karma,password,date_joined,profile_pic) VALUES ('$cleanName',0,'$encryptedPass','$date_joined','$default_pic')";
	mysql_query($query,$link) or die(mysql_error());
}

?>