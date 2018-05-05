<?php
include('connection.php');
include('adminsession.php');

$sql =  "UPDATE thalilist set Active='" . $_POST['active'] . "', " . (($_POST['active'] == 0)? "Thali_stop_date = '": "hardstop = 0, hardstop_comment = '', Thali_start_date='") . $_POST['stop_date'] . "'";
if(isset($_POST['hardstop']) && $_POST['hardstop'] == 1) {
  $sql = $sql . ", hardstop='" . $_POST['hardstop'] . "', hardstop_comment='" . $_POST['hardstopcomment'] . "'";
}
$sql = $sql . " WHERE Thali in (".$_POST['thaali_id'] .");";

$sql = $sql . "\r\nUPDATE change_table set processed = 1 WHERE Thali in (" . $_POST['thaali_id'] . ") and `Operation` in ('Start Thali','Stop Thali','Start Transport','Stop Transport') and processed = 0;";

$thaaliIDs = explode(",", $_POST['thaali_id']);
$sizeOfArray = count($thaaliIDs);
for ($i=0; $i < $sizeOfArray ; $i++) { 
  $sql = $sql . "\r\nINSERT INTO change_table (`Thali`, `Operation`, `Date`) VALUES ('" . $thaaliIDs[$i] . "', 'Stop Thali','" . $_POST['stop_date'] . "');";
}
// echo $sql;
// exit;
mysqli_query($link,$sql) or die(mysqli_error($link));
echo "success";
?>