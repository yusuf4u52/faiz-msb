<?php
include('connection.php');
session_start();

if (is_null($_SESSION['fromLogin'])) {

 //send them back
   header("Location: login.php");
}
else {
$result = mysqli_query($link,"SELECT * from thalilist WHERE Active='1' AND Email_id = '".$_SESSION['email']."'");
$count=mysqli_num_rows($result);

if ($count == 0) {
$update = mysqli_query($link,"UPDATE thalilist set Active='1' WHERE Email_id = '".$_SESSION['email']."'");
$update = mysqli_query($link,"UPDATE thalilist set Thali_start_date='" . date("Y-m-d") . "' WHERE Email_id = '".$_SESSION['email']."'");

$myfile = fopen("startthali.txt", "a") or die("Unable to open file!");
$txt="".$_SESSION['thali']." - ".$_SESSION['name']." - ".$_SESSION['contact']." - ".$_SESSION['address']."\n";
fwrite($myfile, $txt);
fclose($myfile);
 }
header('Location: index.php');

}
?>