<?php
require_once "common.php";
require_once('connection.php');
// include('googlesheet.php');
require_once('_payhoob_helper.php');

function getOrderStatus($orderId)
{
  $url = CashfreeConfig::$baseUrl . "/orders/" . $orderId;

  $headers = array(
    "content-type: application/json",
    "x-client-id: " . CashfreeConfig::$appId,
    "x-client-secret: " . CashfreeConfig::$secret,
    "x-api-version: " . CashfreeConfig::$apiVersion,
  );

  $orderResp = doGet($url, $headers);
  return $orderResp;
}

function getPaymentBankReference($orderId)
{
  $url = CashfreeConfig::$baseUrl . "/orders/" . $orderId . "/payments";

  $headers = array(
    "content-type: application/json",
    "x-client-id: " . CashfreeConfig::$appId,
    "x-client-secret: " . CashfreeConfig::$secret,
    "x-api-version: " . CashfreeConfig::$apiVersion,
  );

  $paymentResp = doGet($url, $headers);
  return $paymentResp;
}

if ($_POST) {
  if (!isset($_POST["orderId"])) {
    $msg = "No order id present";
    error_log($msg);
    die($msg);
  }
  $orderId = $_POST["orderId"];
  $query = "select * from order_details where gw_order_id='$orderId'";
  $result = mysqli_query($link, $query);
  if (!$result) {
    $msg = mysqli_error($link);
    error_log($msg);
    die($msg);
  }
  if (mysqli_num_rows($result) === 0) {
    $msg = "FATAL ERROR: Order $orderId not present in local database";
    error_log($msg);
    die($msg);
  }
  $orderDetails = mysqli_fetch_assoc($result);

  //----------------------

  $order = getOrderStatus($orderId);
  $response_body = $order["data"];
  $order_status = $response_body["order_status"];

  $query = "update order_details set gw_status='$order_status' where gw_order_id='$orderId'";
  $result = mysqli_query($link, $query);
  if (!$result) {
    $msg = mysqli_error($link);
    error_log($msg);
    die($msg);
  }

  //------------------------------

  if ($order_status == "PAID") {
    $payment = getPaymentBankReference($orderId);
    $bankreferenceid = is_null($payment["data"][0]["bank_reference"]) ? "" : $payment["data"][0]["bank_reference"];
    // create_receipt_in_sheet($_SESSION['thali'], $response_body["order_amount"], $bankreferenceid, $orderId);
    $receiptNumber = createReceipt($orderDetails['thali_id'], $orderDetails['amount'], 'Bank', 'help@faizstudents.com', $bankreferenceid);
    $query = "update order_details set Receipt_No='$receiptNumber' where gw_order_id='$orderId'";
    $result = mysqli_query($link, $query);
    if (!$result) {
      $msg = mysqli_error($link);
      error_log($msg);
      die($msg);
    }
  }
  //-------------------------------
}
