<?php
include('connection.php');
include('adminsession.php');

if($_POST)
{
  
  $sql = "INSERT INTO receipts (`Receipt_No`, `Thali_No`, `Amount`, `Date`) VALUES ('" . $_POST['receipt_number'] . "','" . $_POST['receipt_thali'] . "','" . $_POST['receipt_amount'] . "', '" . $_POST['receipt_date'] . "')";
  mysqli_query($link, $sql) or die(mysqli_error($link));

  $sql = "UPDATE thalilist set Paid = Paid + '" . $_POST['receipt_amount'] . "' WHERE thali = '" . $_POST['receipt_thali']."'";
  mysqli_query($link, $sql) or die(mysqli_error($link));

  $sql = "UPDATE thalilist set Zabihat = Zabihat + '" . $_POST['zabihat'] . "' WHERE thali = '" . $_POST['receipt_thali']."'";
  mysqli_query($link, $sql) or die(mysqli_error($link));

  $sql = mysqli_query($link,"SELECT SUM(`Amount`) from receipts");
  $row = mysqli_fetch_row($sql);
  $amount = $row[0];

  $sql = mysqli_query($link,"SELECT SUM(`Paid`) from thalilist");
  $row = mysqli_fetch_row($sql);
  $paid = $row[0];

  require "emailTest.php";

  if ($amount == $paid)
  echo "success";

}