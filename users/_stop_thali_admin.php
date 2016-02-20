<?php
include('connection.php');
include('adminsession.php');

$result = mysqli_query($link,"SELECT * from thalilist WHERE Active='0' AND Thali = ".$_POST['thaali_id'] );
$count=mysqli_num_rows($result);

if ($count == 0) {
  $update = mysqli_query($link,"UPDATE thalilist set Active='0' WHERE Thali = ".$_POST['thaali_id'] );
  $update = mysqli_query($link,"UPDATE thalilist set Thali_stop_date='" . $_POST['stop_date'] . "' WHERE Thali = ".$_POST['thaali_id'] );

  mysqli_query($link,"INSERT INTO change_table (`Thali`, `Operation`, `Date`) VALUES ('" . $_POST['thaali_id'] . "', 'Stop Thali','" . $_POST['stop_date'] . "')");

  $myfile = fopen("stopthali.txt", "a") or die("Unable to open file!");
  $txt="".$_POST['thaali_id']." via admin\n";
  fwrite($myfile, $txt);
  fclose($myfile);
  //$status = 'Stop Thali Successful';
  echo "success";
} else {
  echo "404";
}

?>