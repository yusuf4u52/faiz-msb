<?php
require_once('connection.php');
include('../sms/_credentials.php');

function createReceipt($thali, $receiptAmount, $paymentType, $createdByEmailId, $transactionId = null)
{
  global $link;
  include('getHijriDate.php');

  $today = getTodayDateHijri();
  // getting receipt number
  $sql = mysqli_query($link, "SELECT MAX(`Receipt_No`) from receipts");
  $row = mysqli_fetch_row($sql);
  $receiptNumber = $row[0] + 1;

  // validation
  if ($receiptNumber == 1) {
    $msg = "Receipt Number cannot be 1, check with administrator";
    error_log($msg);
    die($msg);
  }
  $sql = "select NAME,id from thalilist WHERE thali = '" . $thali . "'";
  $result = mysqli_query($link, $sql) or die(mysqli_error($link));
  $name = mysqli_fetch_assoc($result);

  // validation
  if (empty($name)) {
    $msg = "Unable to find details of the thali #" . $thali;
    error_log($msg);
    die($msg);
  }

  $sql = mysqli_query($link, "SELECT SUM(`Amount`) from receipts");
  $row = mysqli_fetch_row($sql);
  $amount = $row[0];

  $sql = mysqli_query($link, "SELECT SUM(`Paid`) from thalilist");
  $row = mysqli_fetch_row($sql);
  $paid = $row[0];


  if ($amount != $paid) {
    $msg = "Database is not in sync. Please contact administrator";
    error_log($msg);
    die($msg);
  }

  $sql = "";
  if ($paymentType  == 'Bank') {
    $sql = "INSERT INTO receipts (`Receipt_No`, `Thali_No`, `userid` ,`name`, `Amount`, `payment_type`, `trasaction_id`, `Date`, `received_by`) VALUES ('" . $receiptNumber . "','" . $thali . "','" . $name['id'] . "','" . $name['NAME'] . "','" . $receiptAmount . "','" . $paymentType . "','" . $transactionId . "', '" . $today . "','" . $createdByEmailId . "')";
  } else {
    $sql = "INSERT INTO receipts (`Receipt_No`, `Thali_No`, `userid` ,`name`, `Amount`, `payment_type`, `Date`, `received_by`) VALUES ('" . $receiptNumber . "','" . $thali . "','" . $name['id'] . "','" . $name['NAME'] . "','" . $receiptAmount . "','" . $paymentType . "', '" . $today . "','" . $createdByEmailId . "')";
  }

  $result = mysqli_query($link, $sql);
  if (!$result) {
    $msg = mysqli_error($link);
    error_log($msg);
    die($msg);
  }

  $sql = "UPDATE thalilist set Paid = Paid + '" . $receiptAmount . "' WHERE thali = '" . $thali . "'";
  $result = mysqli_query($link, $sql);
  if (!$result) {
    $msg = mysqli_error($link);
    error_log($msg);
    die($msg);
  }

  return $receiptNumber;
}

function sendSms($smsBody, $smsTo)
{
  global $smsauthkey;

  $smsBodyEncoded = urlencode($smsBody);
  $result = file_get_contents("http://sms1.almasaarr.com/sendhttp.php?authkey=$smsauthkey&mobiles=$smsTo&message=$smsBodyEncoded&sender=FAIZST&route=Template");
  return $result;
}
