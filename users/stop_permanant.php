<?php
include('connection.php');
include('_authCheck.php');

$sql = "select id from thalilist WHERE thali = '" . $_POST['Thaliid'] . "'";
$result = mysqli_query($link, $sql) or die(mysqli_error($link));
$name = mysqli_fetch_assoc($result);

 mysqli_query($link,"INSERT INTO change_table (`Thali`,`userid`, `Operation`, `Date`) VALUES ('" . $_POST['Thaliid'] . "','".$name['id']."', 'Stop Permanent','" . $_POST['date'] . "')") or die(mysqli_error($link));
 mysqli_query($link,"UPDATE thalilist set Active='2', `old_thali` = `Thali`, `Thali` = NULL WHERE id = '".$name['id']."'") or die(mysqli_error($link));
 mysqli_query($link,"update change_table set processed = 1 where userid = '" . $name['id'] . "' and `Operation` in ('New Thali') and processed = 0") or die(mysqli_error($link));
?> 