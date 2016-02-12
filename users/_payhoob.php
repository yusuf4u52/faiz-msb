<?php
include('connection.php');
include('adminsession.php');

if($_POST)
{
  
  $sql = "INSERT INTO receipts (`Receipt_No`, `Thali_No`, `Amount`, `Date`) VALUES ('" . $_POST['receipt_number'] . "','" . $_POST['receipt_thali'] . "','" . $_POST['receipt_amount'] . "', '" . $_POST['receipt_date'] . "')";
  $insert = mysqli_query($link, $sql) or die(mysqli_error($link));
  $sql = "UPDATE thalilist set Paid = Paid + '" . $_POST['receipt_amount'] . "' WHERE thali = '" . $_POST['receipt_thali']."'";
  $update = mysqli_query($link, $sql) or die(mysqli_error($link));
  
  echo "success";
}