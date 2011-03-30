<?php

if(!$link){
	$link = connct_to_database();
}

$uid = $_GET['user_id'];


echo "<div id='wall_box'>";
$wall_ouput = get_wall_output($uid,$link);
echo $wall_ouput;


echo "<h1>write</h1>
	  <form action='scripts/wall_submit.php' method='post'>
	     <textarea name='content'></textarea>
		 <input type='hidden' name='user_id' value='$uid' id=''>
		 <input type='hidden' name='user_name' value='$cleanName' id=''>
		 <input type='submit' value='submit'>
	  </form>";
echo "</div>";
?>

