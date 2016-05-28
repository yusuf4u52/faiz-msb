<?php
include('connection.php');
include('_authCheck.php');

if(isset($_GET['option']))
{
	$huboptions = array(
						1 => '21000',
						2 => '24000',
						3 => '27000',
						4 => '53000'
							);
	$hub_amount = $huboptions[$_GET['option']];
	$update = mysqli_query($link,"UPDATE thalilist set yearly_hub='".$hub_amount."' WHERE Email_id = '".$_SESSION['email']."'");
}
header("Location: index.php");
?>