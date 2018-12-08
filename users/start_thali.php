<?php
include('connection.php');
session_start();
if (is_null($_SESSION['fromLogin'])) {
 //send them back\
   header("Location: login.php");
}

$query="SELECT * FROM thalilist where id = '".$_SESSION['thaliid']."'";
$values = mysqli_fetch_assoc(mysqli_query($link,$query));

if($values['hardstop'] == 1) exit;

mysqli_query($link,"UPDATE thalilist set Active='1' WHERE id = '".$_SESSION['thaliid']."'") or die(mysqli_error($link));
mysqli_query($link,"UPDATE thalilist set Thali_start_date='" . $_POST['start_date'] . "' WHERE id = '".$values['id']."'") or die(mysqli_error($link));

// $capture = mb_substr($_POST['start_date'], -2);
// $capture=str_replace("-","0",$capture);
// $result1 = mysqli_query($link,"SELECT * from thalilist WHERE Dues=0 AND Email_id = '".$_SESSION['email']."'");
// $count1=mysqli_num_rows($result1);
// if ($count1 == 1) {
// 			if ($capture >= 1 && $capture <= 10)
// 			{
// 				mysqli_query($link,"UPDATE thalilist set Dues='1800' WHERE Email_id = '".$_SESSION['email']."'");
// 				mysqli_query($link,"UPDATE thalilist set TranspFee='250' WHERE Transporter != 'Pick Up' AND Email_id = '".$_SESSION['email']."'");
// 			}
// 			elseif ($capture >= 11 && $capture <= 20)
// 			{
// 				mysqli_query($link,"UPDATE thalilist set Dues='1200' WHERE Email_id = '".$_SESSION['email']."'");
// 				mysqli_query($link,"UPDATE thalilist set TranspFee='180' WHERE Transporter != 'Pick Up' AND Email_id = '".$_SESSION['email']."'");
// 			}
// 			elseif ($capture >= 20 && $capture <= 26)
// 			{	
// 				mysqli_query($link,"UPDATE thalilist set Dues='600' WHERE Email_id = '".$_SESSION['email']."'");
// 				mysqli_query($link,"UPDATE thalilist set TranspFee='90' WHERE Transporter != 'Pick Up' AND Email_id = '".$_SESSION['email']."'");
// 			}
// }

mysqli_query($link,"update change_table set processed = 1 where userid = '" . $_SESSION['thaliid'] . "' and `Operation` in ('Start Thali','Stop Thali') and processed = 0") or die(mysqli_error($link));
mysqli_query($link,"INSERT INTO change_table (`Thali`, `userid`, `Operation`, `Date`) VALUES ('".$values['Thali']."','".$_SESSION['thaliid']."', 'Start Thali','" . $_POST['start_date'] . "')") or die(mysqli_error($link));

$status = 'Start Thali Successful';

header("Location: index.php?status=$status");



?>