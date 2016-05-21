<?php
include('connection.php');
session_start();

if (is_null($_SESSION['fromLogin'])) {

 //send them back
   header("Location: login.php");
}

$update = mysqli_query($link,"UPDATE thalilist set Active='0' WHERE Email_id = '".$_SESSION['email']."'");
$update = mysqli_query($link,"UPDATE thalilist set Thali_stop_date='" . $_POST['stop_date'] . "' WHERE Email_id = '".$_SESSION['email']."'");

mysqli_query($link,"update change_table set processed = 1 where Thali = '" . $_SESSION['thali'] . "' and `Operation` in ('Start Thali','Stop Thali','Start Transport','Stop Transport') and processed = 0");
mysqli_query($link,"INSERT INTO change_table (`Thali`, `Operation`, `Date`) VALUES ('" . $_SESSION['thali'] . "', 'Stop Thali','" . $_POST['stop_date'] . "')");

$status = 'Stop Thali Successful';
header("Location: index.php?status=$status");
?>