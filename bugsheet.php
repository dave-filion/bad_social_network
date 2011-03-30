<?php
$login = $_COOKIE['LOGON'];	
if(!$login)
{
	header("Location:welcome.php");
}

require "functions/dbconnect.php";
$link = connect_to_database();
require "include/navbar.php";

echo "<h1>BUG SHEET</h1>";
$q = "SELECT * FROM posts";
$result = mysql_query($q,$link);
echo "<ol>";
while($row = mysql_fetch_array($result))
{
	$title = $row['title'];
	$pattern = '/^BUG/';
	$match = preg_match($pattern,$title,$matches,PREG_OFFSET_CAPTURE,0);
	if($match == 1){
		echo "<li>".$row['content']." - by ".$row['author']."</li>";
	}
}
echo "</ol>";

echo"<h1>SUGGESTIONS</h1>";
$q = "SELECT * FROM posts";
$result = mysql_query($q,$link);
echo "<ol>";
while($row = mysql_fetch_array($result))
{
	$title = $row['title'];
	$pattern = '/^SUGGESTION/';
	$match = preg_match($pattern,$title,$matches,PREG_OFFSET_CAPTURE,0);
	if($match == 1){
		echo "<li>".$row['content']." - by ".$row['author']."</li>";
	}
}
echo "</ol>";


?>