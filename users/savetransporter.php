<?php
include('connection.php');
include('adminsession.php');
$data = explode('|',$_POST['data']);

$result = mysqli_query($link,"UPDATE thalilist SET Transporter = '".$data[1]."' WHERE Thali = '".$data[0]."'") or die(mysqli_error($link));
echo 'Done';
?>