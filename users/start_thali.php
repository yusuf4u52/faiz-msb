<?php
require_once('connection.php');
include('getHijriDate.php');

$today = getTodayDateHijri();
session_start();
if (is_null($_SESSION['fromLogin'])) {
 //send them back\
   header("Location: login.php");
}

$query="SELECT * FROM thalilist where id = '".$_SESSION['thaliid']."'";
$values = mysqli_fetch_assoc(mysqli_query($link,$query));

if($values['hardstop'] == 1) exit;

mysqli_query($link,"UPDATE thalilist set Active='1' WHERE id = '".$_SESSION['thaliid']."'") or die(mysqli_error($link));
mysqli_query($link,"UPDATE thalilist set Thali_start_date='" . $today . "' WHERE id = '".$values['id']."'") or die(mysqli_error($link));


mysqli_query($link,"update change_table set processed = 1 where userid = '" . $_SESSION['thaliid'] . "' and `Operation` in ('Start Thali','Stop Thali') and processed = 0") or die(mysqli_error($link));
mysqli_query($link,"INSERT INTO change_table (`Thali`, `userid`, `Operation`, `Date`) VALUES ('".$values['Thali']."','".$_SESSION['thaliid']."', 'Start Thali','" . $today . "')") or die(mysqli_error($link));

$status = 'Start Thali Successful';

header("Location: index.php?status=$status");



?>