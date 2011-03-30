<?php

setcookie('LOGON',0,time()+360000,'/');
setcookie('user_name',0,time()+360000,'/');
setcookie('user_id',0,time()+360000,'/');
header('Location:../index.php');

?>