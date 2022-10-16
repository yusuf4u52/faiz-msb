<?php
require_once('connection.php');
include('_authCheck.php');

if (isset($_GET['option'])) {
	$huboptions = array(
		1 => '30000',
		2 => '32000',
		3 => '35000',
		4 => '40000',
		5 => '5300'
	);
	$hub_amount = $huboptions[$_GET['option']];
} else if (isset($_POST['other_takhmeen'])) {
	$hub_amount = (int)$_POST['other_takhmeen'];
	if ($hub_amount < 30000) {
		header("Location: selectyearlyhub.php?message=error");
		exit;
	}
}

if (isset($hub_amount)) {
	$thali_details = mysqli_fetch_assoc(mysqli_query($link, "SELECT musaid FROM thalilist WHERE Email_ID = '" . $_SESSION['email'] . "'"));
	$musaid_name = !empty($thali_details['musaid']) ? $thali_details['musaid'] : 'mustafamnr@gmail.com';
	$update = mysqli_query($link, "UPDATE thalilist set yearly_hub='$hub_amount', musaid='$musaid_name' WHERE Email_id = '" . $_SESSION['email'] . "'") or die(mysqli_error($link));
}

header("Location: index.php");
