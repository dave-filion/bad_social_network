<?php
	require "../functions/dbconnect.php";	
	$link = connect_to_database();
	
	$name     = $_POST['name'];
	$password = $_POST['password'];
	$name     = strtolower($name);

	$result = checkUserPass($name,$password);
	
	if($result == 1){
		$id = get_user_id($name,$link);

		setcookie('LOGON',1,time()+3600000,"/");
		setcookie('user_name',"$name",time()+3600000,"/");
		setcookie('user_id',"$id",time()+3600000,"/");

		header("Location: ../index.php");
	}else{
		header('Location: ../index.php?login=1');
	}

function isUser($name){
	$q = "SELECT * FROM users WHERE name='$name";
}

function checkUserPass($name,$password){
	$name = mysql_real_escape_string($name);
	$password = md5($password);

	$query = "SELECT password FROM users WHERE name='$name'";
	$result = mysql_query($query);

	if(!$result || (mysql_num_rows($result) < 1)){
		return 0; //NO USERNAME
	}
	
	$array = mysql_fetch_array($result);
	
	$checkPass = $array['password'];
		
	if($password == $checkPass){
		return 1;
	}else{
		return 0; //WRONG PASS
	}
}

function get_user_id($name,$link){
	$q = "SELECT user_id FROM users WHERE name = '$name'";
	$result = mysql_query($q,$link);
	$row = mysql_fetch_array($result);
	
	$id = $row['user_id'];
	return $id;
}

?>