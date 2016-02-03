<?php
include('connection.php');
session_start();

if (is_null($_SESSION['fromLogin'])) {

 //send them back
   header("Location: login.php");
}
else {
$result = mysqli_query($link,"SELECT * from thalilist WHERE Active='0' AND Email_id = '".$_SESSION['email']."'");
$count=mysqli_num_rows($result);

if ($count == 0) {

$update = mysqli_query($link,"UPDATE thalilist set Active='0' WHERE Email_id = '".$_SESSION['email']."'");
$update = mysqli_query($link,"UPDATE thalilist set Thali_stop_date='" . $_POST['stop_date'] . "' WHERE Email_id = '".$_SESSION['email']."'");

mysqli_query($link,"INSERT INTO change_table (`Thali`, `Operation`, `Date`) VALUES ('" . $_SESSION['thali'] . "', 'Stop Thali','" . $_POST['stop_date'] . "')";

$myfile = fopen("stopthali.txt", "a") or die("Unable to open file!");
$txt="".$_SESSION['thali']."\n";
fwrite($myfile, $txt);
fclose($myfile);

$status = 'Stop Thali Successful';
}
header("Location: index.php?status=$status");
}
?>