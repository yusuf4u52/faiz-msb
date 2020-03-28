<?php
include('connection.php');
$query = "Select * from thalilist where id='".$_POST['Thaliid']."'";
$result= mysqli_query($link,$query);
$values = mysqli_fetch_assoc($result);

mysqli_query($link, "INSERT INTO event_response (`thaliid`,`thalino`,`eventid`,`response`,`its`,`name`,`mobile`) VALUES ('".$_POST['Thaliid']."','".$values['Thali']."','".$_POST['Eventid']."','".$_POST['Response']."','".$values['ITS_No']."','".$values['NAME']."','".$values['CONTACT']."')") or die(mysqli_error($link));
?>