<?php
include('connection.php');
if ($faiz_api_key != $_POST['api_key']) {
    header("Location: login.php");
    exit;
}
$query = "Select * from thalilist where id='".$_POST['Thaliid']."'";
$result= mysqli_query($link,$query);
$values = mysqli_fetch_assoc($result);

print_r(json_encode($values));

if (isset($_POST['Response'])) {
    mysqli_query($link, "INSERT INTO event_response (`thaliid`,`thalino`,`eventid`,`response`,`its`,`name`,`mobile`,`comments`) VALUES ('".$_POST['Thaliid']."','".$values['Thali']."','".$_POST['Eventid']."','".$_POST['Response']."','".$values['ITS_No']."','".$values['NAME']."','".$values['CONTACT']."','".$_POST['Comments']."')") or die(mysqli_error($link));
}
?>