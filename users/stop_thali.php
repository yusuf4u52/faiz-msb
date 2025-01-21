<?php
require_once('connection.php');
include('getHijriDate.php');

$today = getTodayDateHijri();
session_start();

if (is_null($_SESSION['fromLogin'])) {

 //send them back
   header("Location: login.php");
}

// check if request is in cut off time
date_default_timezone_set('Asia/Kolkata');
$cutoffTime = '20:00'; //Cut off time
$startTime = '23:59'; //reset back to open at midnight

$time = new DateTime($cutoffTime);
$time1 = date_format($time, 'H:i');
$time = new DateTime($startTime);
$time2 = date_format($time, 'H:i');

$current = date("H:i");
if ($current > $time1 && $current < $time2) {
  $cutoffmessage =  'Stop thali not allowed post 6 PM.';
  header("Location: index.php?status=$cutoffmessage");
  exit;
}

$update = mysqli_query($link,"UPDATE thalilist set Active='0' WHERE id = '".$_SESSION['thaliid']."'") or die(mysqli_error($link));
$update = mysqli_query($link,"UPDATE thalilist set Thali_stop_date='" . $today . "' WHERE id = '".$_SESSION['thaliid']."'") or die(mysqli_error($link));

mysqli_query($link,"update change_table set processed = 1 where userid = '".$_SESSION['thaliid']."' and `Operation` in ('Start Thali','Stop Thali','Start Transport','Stop Transport') and processed = 0") or die(mysqli_error($link));
mysqli_query($link,"INSERT INTO change_table (`Thali`, `userid`,`Operation`, `Date`) VALUES ('" . $_SESSION['thali'] . "','".$_SESSION['thaliid']."', 'Stop Thali','" . $today . "')") or die(mysqli_error($link));

$status = 'Stop Thali Successful';
header("Location: index.php?status=$status");
?>