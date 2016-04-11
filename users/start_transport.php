<?php
include('connection.php');
session_start();

if (is_null($_SESSION['fromLogin'])) {

 //send them back
   header("Location: login.php");
}
else {
$result = mysqli_query($link,"SELECT * from thalilist WHERE Transporter!='Pick Up' AND Email_id = '".$_SESSION['email']."'");
$count=mysqli_num_rows($result);

if ($count == 0) {
$update = mysqli_query($link,"UPDATE thalilist set Transporter='Transporter' WHERE Email_id = '".$_SESSION['email']."'");

mysqli_query($link,"INSERT INTO change_table (`Thali`, `Operation`, `Date`) VALUES ('" . $_SESSION['thali'] . "', 'Start Transport','" . $_POST['start_date'] . "')");

$myfile = fopen("starttransport.txt", "a") or die("Unable to open file!");
$txt="".$_SESSION['thali']." - ".$_SESSION['address']."\n";
fwrite($myfile, $txt);
fclose($myfile);
$status = "Transport request submitted";
}
header("Location: index.php?status=$status");
}
?>