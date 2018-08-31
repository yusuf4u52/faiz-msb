<?php
include('connection.php');
include('_authCheck.php');

 mysqli_query($link,"INSERT INTO change_table (`Thali`, `Operation`, `Date`) VALUES ('" . $_POST['Thaliid'] . "', 'Stop Permanent','" . $_POST['date'] . "')") or die(mysqli_error($link));
 mysqli_query($link,"UPDATE thalilist set Active='2', `old_thali` = `Thali`, `Thali` = NULL WHERE Thali = '".$_POST['Thaliid']."'") or die(mysqli_error($link));
?> 