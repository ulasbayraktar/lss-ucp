<?php

if(isset($_SESSION['oturum']))
	header("Location:index.php");

session_start();

$_SESSION['oturum'] = false;
$_SESSION['admin'] = false;
$_SESSION['tester'] = false;
$_SESSION['register_step'] = 0;
$_SESSION['switch_to'] = false;

unset($_SESSION['switch_to']);
unset($_SESSION['oturum']);
unset($_SESSION['admin']);
unset($_SESSION['tester']);
unset($_SESSION['register_step']);

session_destroy();

header("Location:index.php");

?>
