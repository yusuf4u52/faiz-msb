<?php
include('connection.php');

$sql = "INSERT INTO event_response (`thaliid`,`eventid`,`response`) VALUES ('".$_POST['Thaliid']."','".$_POST['Eventid']."','".$_POST['Response']."')";
mysqli_query($link, $sql) or die(mysqli_error($link));
?>