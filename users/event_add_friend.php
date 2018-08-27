<?php
include('connection.php');
$sql = "INSERT INTO event_response (`reference_id`,`thaliid`,`eventid`,`response`,`its`,`name`,`mobile`) VALUES ('".$_POST['reference_id']."','','".$_POST['eventid']."','yes','".$_POST['its']."','".$_POST['name']."','".$_POST['mobile']."')";
mysqli_query($link, $sql) or die(mysqli_error($link));
header("Location: /users/events.php");
?>