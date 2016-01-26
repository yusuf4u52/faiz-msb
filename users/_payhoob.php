<?php
include('connection.php');
session_start();

if (!is_null($_SESSION['fromLogin']) && in_array($_SESSION['email'], array('yusuf4u52@gmail.com','tzabuawala@gmail.com','bscalcuttawala@gmail.com','mustafamnr@gmail.com'))) {
 
}
else
  header("Location: login.php");

if($_POST)
{
  $sql = "UPDATE thalilist set Paid = Paid + " . $_POST["receipt_amount"] . "   WHERE Email_id = '".$_SESSION['email']."'";
  $update = mysqli_query($link, $sql);

  $sql = "SELECT thali from thalilist WHERE Email_id = '".$_SESSION['email']."'";

  print_r($sql);

  $select = mysqli_query($link, $sql);
  $values = mysqli_fetch_assoc($select);

  var_dump($values);
  $thali = $values["thali"];
  $sql = "INSERT INTO receipts ('Receipt No', 'Thali No', 'Amount') VALUES (" . $_POST["receipt_number"] . "," . $thali . "," . $_POST["receipt_amount"] . ")";
  echo $sql; exit;
  $insert = mysqli_query($link, $sql);
  echo "success";
}