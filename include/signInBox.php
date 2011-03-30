<div id = "signInBox">
	<h1>sign in</h1>
	<?php
	$login_result = $_GET['login'];
	 
	if ($login_result == 1)
		echo "<h2>bad user/pass</h2>";
	else if($login_result == 2)
		echo "<h2 class='good'>Now sign in to post!</h2>";
	?>
	<form action="scripts/validate_user.php" method="post" accept-charset="utf-8">
		<input type="text" onFocus="this.value=''" value="username" id="name" name="name">
		<input type="password" onFocus="this.value=''" value="password" id="password" name="password">
		<input class="submit" type="submit" value="login">
	</form>
	<a href="register.php">not a member?</a>
</div>
