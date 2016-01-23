<?php
session_start();

if (is_null($_SESSION['fromLogin'])) {

 //send them back
   header("Location: login.php");
}
else {
$link=mysqli_connect("mysql.hostinger.in","u380653844_yusuf","FaizPassword","u380653844_faiz") or die("Cannot Connect to the database!");
$result = mysqli_query($link,"SELECT * from thalilist WHERE Transporter='Pick Up' AND Email_id = '".$_SESSION['email']."'");
$count=mysqli_num_rows($result);

if ($count == 0) {
$update = mysqli_query($link,"UPDATE thalilist set Transporter='Pick Up' WHERE Email_id = '".$_SESSION['email']."'");

$myfile = fopen("stoptransport.txt", "a") or die("Unable to open file!");
$txt="".$_SESSION['thali']."\n";
fwrite($myfile, $txt);
fclose($myfile);
}
header('Location: index.php');
}
?>