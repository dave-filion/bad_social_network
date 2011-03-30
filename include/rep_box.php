<?php
$rep_list = get_rep_list(10,$link)
?>

<div id="rep_box">
	<h1>top rep</h1>
	<ul>
	<?php echo $rep_list; ?>
	</ul>
</div>