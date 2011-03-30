<?php
$login = $_COOKIE['LOGON'];	
if(!$login)
{
	header("Location:welcome.php");
}


require "functions/dbconnect.php";
$link  = connect_to_database();

$login = $_COOKIE['LOGON'];
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
	"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html>
<head>
	<title>write</title>
	<link rel="stylesheet" href="css/master.css" type="text/css">
	<link rel="stylesheet" href="css/write.css" type="text/css">
	<script src="js/jq.js"></script>
	<script src="js/write.js"></script>
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
		if($login == 1)
			require "include/userBox.php";
		else
			require "include/signInBox.php";		
		?>	
		
		<div id="instructionBox">
			<h1>This is the write window, where you write stuff.</h1>
			<p>To report a bug/make a suggestions, make your title "BUG" or "SUGGESTION".</p>
			<p>I'm working on custom image tags/video tags, so that's coming.</p>
			<p class='signature'>thanks -dave</p>
		</div>
	</div>

	<div id="content">
		<div id="write_box">
			<h1>write</h1>
			<form action="scripts/write_submit.php" method="post" accept-charset="utf-8">
				<input type="text" onFocus="this.value=''" name="title" value="title" id="title">			
				<textarea name="content" id="text_content"></textarea>
				<input type="submit" name="submit" value="submit" id="submit">
			</form>
			
			<h1>...or submit a link</h1>
			<form action="scripts/link_submit.php" method="post">
				<input type="text" onFocus="this.value=''" name="link_title" value="link title" id="link_title">
				<input type="text" onFocus="this.value=''" name="link_url" value="your url" id="link_url">
				<input type="submit" name="link_submit" value="submit" id="link_submit">
			</form>
		</div>
	</div>

	<?php require "include/footer.php" ?>
</div>
	
</body>

</html>
