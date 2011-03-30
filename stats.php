<?php
require "functions/dbconnect.php";
$link = connect_to_database();

echo "under development";


//number of users
$q = "SELECT * FROM users";
$result = mysql_query($q,$link);
$num_users = mysql_num_rows($result);
echo "<h1>NUMBER OF USERS: $num_users</h1>";

//number of posts
$q = "SELECT * FROM posts";
$result = mysql_query($q,$link);
$num_posts = mysql_num_rows($result);
echo "<h1>NUMBER OF POSTS: $num_posts</h1>";

//number of comments
$q = "SELECT * FROM comments";
$result = mysql_query($q,$link);
$num_comments = mysql_num_rows($result);
echo "<h1>NUMBER OF COMMENTS: $num_comments</h1>";






?>