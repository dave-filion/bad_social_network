<?php
$login = $_COOKIE['LOGON'];	
if(!$login)
{
	header("Location:welcome.php");
}

require "functions/dbconnect.php";
require "functions/dome.php";
$link = connect_to_database();

$user_id = $_COOKIE['user_id'];
$post_id = $_GET['post_id'];

//get post info
$q = "SELECT * FROM posts 
      WHERE post_id = $post_id";
$result = mysql_query($q,$link);
$info = mysql_fetch_array($result);

//get comment info
$q = "SELECT * FROM comments 
	  WHERE post_id='$post_id' 
	  ORDER BY comment_id 
	  LIMIT 0,20";
$result = mysql_query($q,$link);
while($row = mysql_fetch_array($result))
{
	$comment_id   = $row['comment_id'];
	$col_num      = $row['col_num'];
	$comment_text = $row['comment_text'];
	$author       = $row['author'];
	$author_id    = $row['author_id'];
	$karma        = $row['karma'];
	
	$q3      = "SELECT profile_pic FROM users 
				WHERE user_id = '$author_id'";
	$result3 = mysql_query($q3,$link);
	$row3    = mysql_fetch_array($result3);
	$profile_pic = $row3['profile_pic'];
	
	//Find user's previous likes of comments
	$q2 = "SELECT liked FROM comment_check
			WHERE comment_id='$comment_id'
			AND user_id='$user_id'";
	$result2 = mysql_query($q2,$link);
	$row2    = mysql_fetch_array($result2);
	$liked   = $row2['liked'];
	
	//Color comments based on previous likes
	if($liked == -1){
		$liked_class = "<div class='comment bad' id='$comment_id'>";
	}else if($liked == 0){
		$liked_class = "<div class='comment' id='$comment_id'>";
	}else if($liked == 1){
		$liked_class = "<div class='comment good' id='$comment_id'>";	
	}else{
		$liked_class = "<div class='comment' id='$comment_id'>";
	}

	//sort comments into proper rows
	if($col_num == 1){
		$comment_col1_output .= 
		"$liked_class
		 <p>$comment_text</p>
		 <a href='profile.php?user_id=$author_id'>
	     <img src=$profile_pic /></a>
		 <p class='karma' id='$comment_id_karma'>$karma</p>
		 <a href='profile.php?user_id=$author_id'>
		 <p class='author'>$author</p></a>
		 </div>";
	}else if($col_num == 2){
		$comment_col2_output .= 
		"$liked_class
		 <p>$comment_text</p>
		 <a href='profile.php?user_id=$author_id'>
	     <img src=$profile_pic /></a>
		 <p class='karma' id='$comment_id_karma'>$karma</p>
		 <a href='profile.php?user_id=$author_id'>
		 <p class='author'>$author</p></a>
		 </div>";
	}else if($col_num == 3){
		$comment_col3_output .= 
		"$liked_class
		 <p>$comment_text</p>
		 <a href='profile.php?user_id=$author_id'>
	     <img src=$profile_pic ></a>
		 <p class='karma' id='$comment_id_karma'>$karma</p>
		 <a href='profile.php?user_id=$author_id'>
		 <p class='author'>$author</p></a>
		 </div>";
	}
}


?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
	"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html>
<head>
	<title><?php echo $info['title'] ?></title>
	<link rel="stylesheet" href="css/master.css" type="text/css" charset="utf-8">
	<link rel="stylesheet" href="css/post.css" type="text/css" media="screen" title="no title" charset="utf-8">
	<script src="js/jq.js"></script>
	<script>
	
	$("document").ready(function(){
		var user_id = <?php echo $user_id; ?>;
		var post_id = <?php echo $post_id; ?>;
		
		$("#add_comment").click(function(event){
			$("#write_comment").show('fast');
		});
		
		$("#close_write").click(function(event){
			$("#write_comment").hide('slow');
		});
		
		$(".comment").mousedown(function(event){
			var comment_id = $(this).attr('id');
			
			switch(event.which){
				case 1:
					var liked = 1;
					$(this).removeClass("bad");
					$(this).addClass("good");
					$.post('ajax/comment_vote.php',
						{comment_id:comment_id,
							user_id:user_id,
							liked:liked,
							post_id:post_id});
					break;
				case 2:
					break;
				case 3:
					var liked = -1;
					$(this).removeClass("good");
					$(this).addClass("bad");
					$.post('ajax/comment_vote.php',
						{comment_id:comment_id,
							user_id:user_id,
							liked:liked,
							post_id:post_id});
					break;
				default:
					alert("hmm");
			}
		})
		
	});
	</script>
	
	<script type="text/javascript">

	  var _gaq = _gaq || [];
	  _gaq.push(['_setAccount', 'UA-22173085-1']);
	  _gaq.push(['_trackPageview']);

	  (function() {
	    var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
	    ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
	    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
	  })();

	</script>
	
</head>

<body>

<?php require "include/header.php"; ?>

<div id="all">

	<?php require "include/navbar.php"; ?>
	
	<div id="leftBar">
		<?php 
		if($login == 0)
			require "include/signInBox.php";
		else
			require "include/userBox.php";		
		?>
		
		<div id="instructionBox">
			<h1>This is the post window, where you view posts</h1>
			<p>To comment, click 'comment' and write something.</p>
			<p>Left-click on comments you like, Right-click on one's 
				you don't like.</p>
			<p>This feature is still being work on though, so be patient</p>
			<p class='signature'>thanks -dave</p>
		</div>
	</div>
	
	<div id="content">
		<div id="mainpost">
			<?php
			$title       = stripslashes($info['title']);
			$author      = $info['author'];
			$author_id   = $info['author_id'];
			$content     = stripslashes($info['content']);
			$time_posted = $info['time_posted']; 
			date_default_timezone_set('America/New_York');
			$dt = date("M d  h:i a",$time_posted);
			
			
			echo "<h1>$title</h1>";
			echo "<a href='profile.php?user_id=$author_id'>by $author</a>";
			echo "<p class='content'>$content</p>";
			echo" <p class='timestamp'>$dt</p>"; 	
			?>
			<a href='#' id="add_comment">Comment?</a>
		</div>
		
		<div id="write_comment" >
			<a href="#" id="close_write">close</a>
			<form action="scripts/submit_comment.php" method="post">
			<textarea name="comment_text" rows="8" cols="30"></textarea>
			<input type="hidden" name="post_id" value="<?php echo $post_id; ?>" id="post_id_text">
			<select name="col_num" id="col_num">
				<option value="1">First</option>
				<option value="2">Second</option>
				<option value="3">Third</option>
				<option value="0">SUPRISE</option>
				
			</select>
			<input type="submit" value="submit">
			</form>
		</div>
		
		<div id="comment_col1">
			<?php echo $comment_col1_output; ?>
		</div>
		
		<div id="comment_col2">
			<?php echo $comment_col2_output; ?>
		</div>
		
		<div id="comment_col3">
			<?php echo $comment_col3_output; ?>
		</div>
		

	</div>
	<?php require "include/footer.php" ?>
</div>

</body>