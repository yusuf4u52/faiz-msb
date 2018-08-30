<?php
include('connection.php');
$query = "Select * from thalilist where id='".$_POST['Thaliid']."'";
$result= mysqli_query($link,$query);
$values = mysqli_fetch_assoc($result);

mysqli_query($link, "INSERT INTO event_response (`thaliid`,`eventid`,`response`,`its`,`name`,`mobile`) VALUES ('".$_POST['Thaliid']."','".$_POST['Eventid']."','".$_POST['Response']."','".$values['ITS_No']."','".$values['NAME']."','".$values['CONTACT']."')") or die(mysqli_error($link));
?>