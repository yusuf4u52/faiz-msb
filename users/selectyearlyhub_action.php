<?php
include('connection.php');
include('_authCheck.php');

if(isset($_GET['option']))
{
	$huboptions = array(
						1 => '21000',
						2 => '22000',
						3 => '24000',
						4 => '27000',
						5 => '53000'
							);
	$hub_amount = $huboptions[$_GET['option']];
	$update = mysqli_query($link,"UPDATE thalilist set yearly_hub='".$hub_amount."' WHERE Email_id = '".$_SESSION['email']."'") or die(mysqli_error($link));
}
header("Location: index.php");
?>