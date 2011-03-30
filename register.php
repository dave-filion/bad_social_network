<?php
require "functions/dbconnect.php";
$link  = connect_to_database();

$dupe = $_GET['dupe'];
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
	"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html>
<head>
	<title>register</title>
	<link rel="stylesheet" href="css/master.css" type="text/css">		
	<script src="js/jq.js"></script>
	<script>
	
	$(document).ready(function(){
		//checks to see if forms are filled and passes match
		$("#registerBox #submit").click(function(event){
			var username = $("#registerBox #username").val();
			var p1       = $("#registerBox #password1").val();
			var p2       = $("#registerBox #password2").val();

			if(p1.length == 0 || username.length == 0){
				alert("Please enter a user name");
				event.preventDefault();
			}else if(p1 != p2){
				alert("Passwords do not match");
				event.preventDefault();
			}else if(username.length > 13){
				alert("Username must be less then 13 characters");
				event.preventDefault();
			}				
		});
	})
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

<?php require "include/header.php" ?>

<div id="all">
	

	<div id="content">
		<div id="registerBox">
			<h1>register</h1>
			<p>Enter your desired username and password below.</p>
			<p class="desc">if you want to be a part of it, sign up.</p>
			<form action="scripts/register_user.php" method="post">
				<?php
				if($dupe==1)
					echo "<h2>username in use</h2>";
				?>
				<label>username</label><input type="text" value="" name="username" id="username"><br/>			
				<label>password</label><input type="password" value="" name="password" id="password1"><br/>
				<label>again</label><input type="password" value="" id="password2">	
				<label>alpha key</label><input type="password" value="" name="alpha_key" id="alpha_key"><br/>							
				<input type="submit" value="submit" id="submit">
			</form>
		</div>
	</div>
	<?php require "include/footer.php" ?>
</div>
	
</body>

</html>
