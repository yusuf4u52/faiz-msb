<?php
include('connection.php');
session_start();

if (is_null($_SESSION['fromLogin'])) {

 //send them back
   header("Location: login.php");
}

$update = mysqli_query($link,"UPDATE thalilist set Active='0' WHERE Email_id = '".$_SESSION['email']."'") or die(mysqli_error($link));
$update = mysqli_query($link,"UPDATE thalilist set Thali_stop_date='" . $_POST['stop_date'] . "' WHERE Email_id = '".$_SESSION['email']."'") or die(mysqli_error($link));

mysqli_query($link,"update change_table set processed = 1 where Thali = '" . $_SESSION['thali'] . "' and `Operation` in ('Start Thali','Stop Thali','Start Transport','Stop Transport') and processed = 0") or die(mysqli_error($link));
mysqli_query($link,"INSERT INTO change_table (`Thali`, `Operation`, `Date`) VALUES ('" . $_SESSION['thali'] . "', 'Stop Thali','" . $_POST['stop_date'] . "')") or die(mysqli_error($link));

$status = 'Stop Thali Successful';
header("Location: index.php?status=$status");
?>