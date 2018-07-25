<?php
include('connection.php');
include('adminsession.php');
include('../sms/_credentials.php');
include('../sms/_helper.php');

if($_POST)
{

  $sql = "select NAME,id from thalilist WHERE thali = '" . $_POST['receipt_thali'] . "'";
  $result = mysqli_query($link, $sql) or die(mysqli_error($link));
  $name = mysqli_fetch_assoc($result);

  $sql = "INSERT INTO receipts (`Receipt_No`, `Thali_No`, `userid` ,`name`, `Amount`, `Date`, `received_by`) VALUES ('" . $_POST['receipt_number'] . "','" . $_POST['receipt_thali'] . "','" . $name['id'] . "','" . $name['NAME'] . "','" . $_POST['receipt_amount'] . "', '" . $_POST['receipt_date'] . "','" . $_SESSION['email'] . "')";
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
$user_name = helper_getFirstNameWithSuffix($row[0]);
$sms_to = $row[2];
$user_pending = helper_getTotalPending($user_thali);
// use \n in double quoted strings for new line character
$sms_body = "Mubarak $user_name for contributing Rs. $user_amount (R.No. $user_receipt) in FMB. Moula TUS nu ehsan che ke apne jamarwa ma shamil kare che.\n"
            ."Thali#:$user_thali\n"
            ."Pending:$user_pending";
$sms_body = urlencode($sms_body);
$result = file_get_contents("http://54.254.154.166/sendhttp.php?user=mustafamnr&password=$smspassword&mobiles=$sms_to&message=$sms_body&sender=FAIZST&route=Template");
//-----------------------------------------
}