<?php
include('connection.php');
if ($faiz_api_key != $_GET['api_key']) {
    echo "You are not authorized";
    exit;
}
$query = "Select * from thalilist where Thali='".$_GET['thalino']."'";
$result= mysqli_query($link,$query);
$values = mysqli_fetch_assoc($result);

echo json_encode($values);
?>