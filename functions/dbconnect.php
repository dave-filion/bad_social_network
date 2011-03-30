<?php

function connect_to_database(){
	$DEV = 0;
	
	if($DEV == 0)
	{
		$info = get_database_info();
		$host = $info['host'];
		$user = $info['user'];
		$pass = $info['pass'];
		$db   = $info['db'];
		
		$link = mysql_connect($host,$user,$pass);
		if(!$link) {
		   die('could not connect: ' . mysql_error());
		}

		$db_selected = mysql_select_db($db,$link);
		if(!$db_selected){
		   die('No database: ' . mysql_error());
		}
		return $link;	
	}
	else
	{
	$link = mysql_connect("localhost",'root','');
	if(!$link) {
	   die('could not connect: ' . mysql_error());
	}

	$db_selected = mysql_select_db('dome',$link);
	if(!$db_selected){
	   die('No database: ' . mysql_error());
	}
	return $link;
	}
}

function get_database_info(){
	$F = fopen("/home/users/web/b614/ipg.domepagenet/functions/INFO.txt","r");

	$host = fgets($F);
	$user = fgets($F);
	$pass = fgets($F);
	$db   = fgets($F);
	
	$host = trim($host);
	$user = trim($user);
	$pass = trim($pass);
	$db   = trim($db);

	$info = array('host'=>$host,'user'=>$user,'pass'=>$pass,'db'=>$db);
	fclose($F);
	return $info;
}
?>