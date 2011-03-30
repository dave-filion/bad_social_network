<?php

require "../functions/dbconnect.php";
$link = connect_to_database();

$user_id = $_GET['user_id'];

$q = "SELECT social_score,content_score FROM users WHERE user_id='$user_id'";
$result = mysql_query($q,$link);
$row = mysql_fetch_array($result);

$social_score = $row['social_score'];
$content_score = $row['content_score'];

$karma = (.4 * $social_score) + (.6 * $content_score);

echo $karma;


?>