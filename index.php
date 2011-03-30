<?php
$login = $_COOKIE['LOGON'];	
if(!$login)
{
	header("Location:welcome.php");
}
require "functions/dome.php";
require "functions/dbconnect.php";
require "controllers/index_controller.php";

//for nav bar
$more = 0;
if($_GET['offset']){
	$offset = $_GET['offset'];
	$num =20;
}
else{
	$offset = 0;
	$num =20;
}

//post filter variable
$FILTER = $_GET['filter'];
?>
<html>
<head>
	<title>domepage</title>
	<link rel="stylesheet" href="css/master.css" type="text/css">
	<script src="js/jq.js"></script>
	<script src="js/index.js"></script>
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
	
	
<div id = "all">

	<?php require "include/navbar.php"; ?>

<div id = "leftBar">	
	<?php 
		require "include/userBox.php";
	
		include "include/friend_request_box.php";
	
		include "include/rep_box.php";
	?>
</div>


<div id = "content">	
	<?php
	display_writebox($login);
	?>
	
	<?php
	display_filters($link);
	?>
	
	<?php
	display_posts($FILTER,$link,$offset,$num);
	?>
				
</div>
</div>

<?php require "include/footer.php" ?>

</body>
</html>
