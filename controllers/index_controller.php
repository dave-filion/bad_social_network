<?php
$link = connect_to_database();

function display_posts($filter,$link,$offset,$num){
	//get posts
	$posts_result = get_posts($filter,$link,$offset,$num);
	
	while($row = mysql_fetch_array($posts_result)){
		$id           = $row['post_id'];
		$title        = stripslashes($row['title']);
		$author       = $row['author'];
		$author_id    = $row['author_id'];
		$karma        = $row['karma'];
		$time_posted  = $row['time_posted'];
		$num_comments = get_num_comments($link,$id); 
		$spread       = get_up_down_count($link,$id);
		$isLink       = $row['link'];
		
		if($spread > 0)
			$spread = "+" . $spread;
		else if(!$spread)
			$spread = "even";
		
		$dt = get_time_since($time_posted);
				
		$more    = 1;
		
		echo '<div class="score_box">';
		echo "<a href='#' id='up$id' class='upvote'><img src='images/up.png' title='plus' /></a>";
		echo "<a href='#' id='down$id' class='downvote'><img src='images/down.png' title='minus' /></a>";
		echo '</div>';
	
		echo "<div class='post' id="."$id"."post>";
		echo"<a class='postTitle' href='post.php?post_id=$id'>$title</a>";
		
		if($isLink){
			echo "<h3>LINK</h3>";
		}
		
		echo"<h2>comments: $num_comments</h2>";
		echo"<h2>($spread)</h2>";
		
		if($author_id == $_COOKIE['user_id']){
		echo"<a href='scripts/remove_post.php?id=$id'><img class='removeButton' src='images/removeIcon.png' title='remove' /></a>";
		}
	
		echo"<br/>";
		echo"<a class='author' href='profile.php?user_id=$author_id'>by $author</a>";
		echo"<p class='timestamp'>$dt</p>";
		echo '</div>';
	}
		
	if($more == 0){
		echo "<h1>Nothing here bra...</h1>";
	}
	
	display_pageNav($offset,$num,$more);
}

function display_writebox($login){
	if($login == 1){ 
		echo '<div id="writeBox">';
		echo	'<a href="write.php">write</a>';
		echo '</div>';
	}else{
		echo '<div id="writeBox">';
		echo 	'<a href="register.php">sign in to write</a>';
		echo '</div>';
	}
}

function get_posts($filter,$link,$offset,$num){
	//normal output
	if($filter == 0)
	{
		$query = "select * from posts order by time_posted DESC limit $offset,$num";
		$result = mysql_query($query,$link);
		return $result;	
	}
	//top scoring posts
	else if($filter == 1)
	{
		$query = "select * from posts order by karma DESC limit $offset,$num";
		$result = mysql_query($query,$link);
		return $result;	
	}
	//latest (same as normal)
	else if($filter == 2)
	{
		$query = "select * from posts order by time_posted DESC limit $offset,$num";
		$result = mysql_query($query,$link);
		return $result;	
	}
	//most comments
	else if($filter == 3)
	{
		$query = "select * from posts order by time_posted DESC limit $offset,$num";
		$result = mysql_query($query,$link);
		return $result;	
	}
	//default
	else
	{
		$query = "select * from posts order by time_posted DESC limit $offset,$num";
		$result = mysql_query($query,$link);
		return $result;	
	}

}

function get_num_comments($link,$post_id){
	$q = "SELECT * FROM comments WHERE post_id='$post_id'";
	$result = mysql_query($q, $link);
	$num = mysql_num_rows($result);
	return $num;
}

function get_up_down_count($link,$post_id){
	$q = "SELECT SUM(karma) FROM comments 
		  WHERE post_id='$post_id' 
		  GROUP BY post_id;";
	$result = mysql_query($q, $link);
	$row = mysql_fetch_array($result);
	
	$spread = $row['SUM(karma)'];
	
	return $spread;				   
}	

function display_pageNav($offset,$num,$more){
	echo '<div id="pageNav">';
	if($offset-20 >= 0){ 
		//display back button
		$newOffset = $offset - 20;
		echo "<a href='index.php?offset=$newOffset&num=$num'><</a>";
	}
			
	if($more == 1){
		//display front button if there's a row...
		$newOffset = $offset + 20;
		echo "<a href='index.php?offset=$newOffset&num=$num'>></a>";
	}
	echo '</div>';
}		

function display_filters($link){
	echo "<div id='filter_box'>";
	echo "<a href='index.php?filter=1'>top</a>";
	echo "<a href='index.php?filter=2'>latest</a>";
	echo "<a href='index.php?filter=3'>talked about</a>";
	echo "</div>";
}

?>