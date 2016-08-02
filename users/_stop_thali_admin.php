<?php
include('connection.php');
include('adminsession.php');

$result = mysqli_query($link,"SELECT * from thalilist WHERE Active='0' AND Thali = ".$_POST['thaali_id'] );
$count=mysqli_num_rows($result);

if ($count == 0) {
  $update = mysqli_query($link,"UPDATE thalilist set Active='0' WHERE Thali = ".$_POST['thaali_id'] ) or die(mysqli_error($link));
  $update = mysqli_query($link,"UPDATE thalilist set Thali_stop_date='" . $_POST['stop_date'] . "' WHERE Thali = ".$_POST['thaali_id'] ) or die(mysqli_error($link));

  mysqli_query($link,"update change_table set processed = 1 where Thali = '" . $_POST['thaali_id'] . "' and `Operation` in ('Start Thali','Stop Thali','Start Transport','Stop Transport') and processed = 0") or die(mysqli_error($link));
  mysqli_query($link,"INSERT INTO change_table (`Thali`, `Operation`, `Date`) VALUES ('" . $_POST['thaali_id'] . "', 'Stop Thali','" . $_POST['stop_date'] . "')") or die(mysqli_error($link));

  echo "success";
} else {
  echo "404";
}

?>