<?php
include('connection.php');
include('adminsession.php');
if(isset($_POST['hardstop']) && $_POST['hardstop'] == 1) {
	mysqli_query($link,"UPDATE thalilist set Active='" . $_POST['active'] . "',hardstop='" . $_POST['hardstop'] . "',hardstop_comment='" . $_POST['hardstopcomment'] . "' WHERE Thali = ".$_POST['thaali_id'] ) or die(mysqli_error($link));
} else {
	mysqli_query($link,"UPDATE thalilist set Active='" . $_POST['active'] . "' WHERE Thali = ".$_POST['thaali_id'] ) or die(mysqli_error($link));
}
mysqli_query($link,"update change_table set processed = 1 where Thali = '" . $_POST['thaali_id'] . "' and `Operation` in ('Start Thali','Stop Thali','Start Transport','Stop Transport') and processed = 0") or die(mysqli_error($link));
if ($_POST['active'] == 0) {
mysqli_query($link,"UPDATE thalilist set Thali_stop_date='" . $_POST['stop_date'] . "' WHERE Thali = ".$_POST['thaali_id'] ) or die(mysqli_error($link));
mysqli_query($link,"INSERT INTO change_table (`Thali`, `Operation`, `Date`) VALUES ('" . $_POST['thaali_id'] . "', 'Stop Thali','" . $_POST['stop_date'] . "')") or die(mysqli_error($link));
}else{
mysqli_query($link,"UPDATE thalilist set Thali_start_date='" . $_POST['stop_date'] . "', hardstop = 0, hardstop_comment = '' WHERE Thali = ".$_POST['thaali_id'] ) or die(mysqli_error($link));
mysqli_query($link,"INSERT INTO change_table (`Thali`, `Operation`, `Date`) VALUES ('" . $_POST['thaali_id'] . "', 'Start Thali','" . $_POST['stop_date'] . "')") or die(mysqli_error($link));
}
echo "success";
?>