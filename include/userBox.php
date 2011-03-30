<div id = "signInBox">
	<?php
	
	require "models/Models.php";
	$user = new User($user_id);
	
	echo "<a class='userName' href='profile.php?user_id=$user->id'>
			$user->name</a>";
	echo "<h2>rep - $user->karma</h2>";
	
	echo "<a href='scripts/logout.php'>logout</a>";
	
	?>
</div>
