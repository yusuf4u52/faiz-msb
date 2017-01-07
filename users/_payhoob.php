<?php
include('connection.php');
include('adminsession.php');
include('../sms/_credentials.php');

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

  
  if ($amount == $paid){
  echo "success";
  }

$user_amount = $_POST['receipt_amount'];
$user_thali = $_POST['receipt_thali'];
$user_receipt = $_POST['receipt_number'];
$user_date = $_POST['receipt_date'];
$sql = mysqli_query($link,"SELECT NAME, Email_ID, CONTACT from thalilist where Thali='".$user_thali."'");
$row = mysqli_fetch_row($sql);
$user_name = $row[0];
$sms_to = $row[2];
$sms_body = "Mubarak for earning sawab by participating in FMB. Moula(T.U.S) nu ehsan che ke apne jamarwa ma shamil kare che. Hub $user_amount/Thali $user_thali/Receipt $user_receipt";
$sms_body = urlencode($sms_body);
$result = file_get_contents("http://sms.myn2p.com/sendhttp.php?user=mustafamnr&password=$smspassword&mobiles=$sms_to&message=$sms_body&sender=FAIZST&route=Template");
//-----------------------------------------
}