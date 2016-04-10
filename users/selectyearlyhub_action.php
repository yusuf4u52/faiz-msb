<?php
include('connection.php');
include('_authCheck.php');

if(isset($_GET['option']))
{
	$huboptions = array(
						1 => '25000',
						2 => '27000',
						3 => '29000'
							);
	$hub_amount = $huboptions[$_GET['option']];
	$update = mysqli_query($link,"UPDATE thalilist set Dues='".$hub_amount."' WHERE Email_id = '".$_SESSION['email']."'");
}
header("Location: index.php");
?>