<?php
$mottos = array("the best website","no place like","back again, for more","didn't forget did we?","never again","you guys are the best","it's the alpha","look at all the new colors!","all this and more","all you need","come back!","check out all the stuff!","what do you want from me?","it's good for you","low fat","come again?","stop what you're doing","for everyone who's every said anything to anyone","don't look at me like that","remember me?","where'd everybody go?","nice to make your e-quaintance","the social network","voted best online community","keep it secret","YOU CAN'T RUN","to the moon!","9000","talk to all your friends!","now with sharp corners!","i don't know where you think you're going","it's a big loop, really","your favorite thing on the internet","beware!","gotcha!","i've never seen anything like it","that takes me back","fight the good fight","is here for you","it's right here in front of you","d o m e","dAVES oLD mUTUAL eQUAINTANCES"," > everything","twice as good","talk to someone!","forever lowercase");

$max   = count($mottos) - 1;
$index = rand(0,$max);
$motto = $mottos[$index];
$user_id = $_COOKIE['user_id'];
$profile_path = "profile.php?user_id=$user_id";
?>


<div id="header">
	<a href = 'index.php'><h1>dome</h1></a>
	<p class='betaTag'>alpha</p>
	<h2>-<?php echo"$motto" ?></h2>
</div>


