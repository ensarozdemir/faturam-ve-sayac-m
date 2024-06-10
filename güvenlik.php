<?php
session_start();

$security_code = substr(md5(mt_rand()), 0,4 ); 

$_SESSION['security_code'] = $security_code;

echo $security_code;
?>
