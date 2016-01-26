<?php
session_start(); //session start
 

	$_SESSION['fromLogin'] = "true";
	$_SESSION['email'] = "tzabuawala@gmail.com";
	header('Location: index.php');

?>

