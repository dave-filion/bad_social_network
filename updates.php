<?php
$login = $_COOKIE['LOGON'];	
if(!$login)
{
	header("Location:welcome.php");
}

require "functions/dbconnect.php";
$link = connect_to_database();

$q = "SELECT * FROM recent_updates";
$result = mysql_query($q);

$num = mysql_num_rows($result);
?>

<html>
<head>
	<title>recent updates</title> 
	<link rel="stylesheet" href="css/master.css" type="text/css" charset="utf-8">
	<link rel="stylesheet" href="css/update.css" type="text/css" charset="utf-8">
	<script src='js/jq.js'></script>
	<script>
	
	$(document).ready(function(){
		var offset = 0;
		var max    = <?php echo $num ?>;
		var NUM    = 7;
				
		$("#updates").load("ajax/updateList.php",{offset:offset});
		$("#backUpdates").hide();
		
		$("#moreUpdates").click(function(event){
			event.preventDefault();
			offset += NUM;
			$("#updates").load("ajax/updateList.php",{offset:offset})
			if(offset >= max){
				$("#moreUpdates").hide();
			}
			$("#backUpdates").show();
			
		});

		$("#backUpdates").click(function(event){
			event.preventDefault();
			offset -= NUM;
			$("#updates").load("ajax/updateList.php",{offset:offset})
			if(offset <= 0){
				$("#backUpdates").hide();
			}
			$("#moreUpdates").show();
			
		});

		
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

	<div id="updateWall">
		<h1>Recent Updates</h1>
		<a href="#" id="backUpdates"><img style="border:0;" src="images/upArrow.png" /></a>
		<a href="#" id="moreUpdates"><img style="border:0;" src="images/downArrow.png" /></a>
			
		<ul>
			<div id="updates">
			</div>
		</ul>
	</div>
	<?php require "include/footer.php" ?>;
</div>

</body>

</html>
	