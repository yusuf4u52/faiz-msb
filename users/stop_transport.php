<?php
include('connection.php');
session_start();

if (is_null($_SESSION['fromLogin'])) {

 //send them back
   header("Location: login.php");
}
$update = mysqli_query($link,"UPDATE thalilist set Transporter='Pick Up' WHERE Email_id = '".$_SESSION['email']."'") or die(mysqli_error($link));

mysqli_query($link,"update change_table set processed = 1 where Thali = '" . $_SESSION['thali'] . "' and `Operation` in ('Start Transport','Stop Transport') and processed = 0") or die(mysqli_error($link));
mysqli_query($link,"INSERT INTO change_table (`Thali`, `Operation`, `Date`) VALUES ('" . $_SESSION['thali'] . "', 'Stop Transport','" . $_POST['stop_date'] . "')") or die(mysqli_error($link));

$status = "Pick Up request submitted";
header("Location: index.php?status=$status");
?>