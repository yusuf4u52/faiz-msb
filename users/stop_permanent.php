<?php
include('connection.php');
session_start();
if (is_null($_SESSION['fromLogin'])) {
 //send them back\
   header("Location: login.php");
}

mysqli_query($link,"INSERT INTO change_table (`Thali`, `Operation`, `Date`) VALUES ('" . $_SESSION['thali'] . "', 'Stop Permanent','" . date("Y-m-d") . "')") or die(mysqli_error($link));

mysqli_query($link,"UPDATE thalilist set Active='2', `old_thali` = `Thali`, `Thali` = NULL WHERE Email_id = '".$_SESSION['email']."'") or die(mysqli_error($link));

session_unset();  
session_destroy();

$status = "Request for stopping your thali permanently has been registered";

header("Location: login.php?status=$status");
?>