<?php
$login = $_COOKIE['LOGON'];	
if(!$login)
{
	header("Location:welcome.php");
}

require "functions/dbconnect.php";
$link = connect_to_database();

$user_id = $_COOKIE['user_id'];

$q = "SELECT * FROM friend_requests WHERE requested_friend_id = '$user_id'";

$result = mysql_query($q,$link);

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
	"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html>
<head>
	<title>Friend Requests</title>
	<link rel="stylesheet" href="css/master.css" type="text/css">
	<link rel="stylesheet" href="css/friend_requests.css" type="text/css">
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
	<div id="friend_request_box">
		<h1>Friend Requests</h1>
		<ul>
		<?php
	
		while ($row = mysql_fetch_array($result))
		{
			$user    = $row['user'];
			$user_id = $row['user_id'];
		
			echo "<li>$user";
			echo "<form action='scripts/accept_friend.php' method='post'>
				  <input type='hidden' name='friend_id' value='$user_id'>
				  <input type='hidden' name='friend'    value='$user'>
				  <input type='submit' value='add friend'>
			      </form></li>";
		}
	
		?>
		</ul>
	</div>

<?php require "include/footer.php"; ?>
</div>
</body>