<?php
require_once "common.php";
include('_authCheck.php');

function createOrder($amount, $paymentType=NULL)
{
    $headers = array(
        "content-type: application/json",
        "x-client-id: " . CashfreeConfig::$appId,
        "x-client-secret: " . CashfreeConfig::$secret,
        "x-api-version: " . CashfreeConfig::$apiVersion,
    );
    $expiry_time = new DateTime();
    $expiry_time->add(new DateInterval('PT16M'));
    $expiry_time = $expiry_time->format('c');
    $data = array(
        "order_amount" => $amount,
        "order_currency" => "INR",
        "order_expiry_time" => $expiry_time,
        "customer_details" => array(
            "customer_id" => $_SESSION['thaliid'],
            "customer_email" => $_SESSION['email'],
            "customer_phone" => $_SESSION['mobile']
        ),
        "order_meta" => array(
            "return_url" => CashfreeConfig::$returnHost . "/users/return.php?orderId={order_id}&token={order_token}",
            "notify_url" => CashfreeConfig::$returnHost . "/users/notify.php",
        )
    );
    if($paymentType) {
      $data['order_tags']['paymentType'] = $paymentType;
    }
    $postResp = doPost(CashfreeConfig::$baseUrl . "/orders", $headers, $data);
    return $postResp;
}

$amount = $_POST['amount'];
// TODO: force user to update their mobile and email before payment
// so that generated receipt can be easily obtained

// TODO: move all cashfree logic to a single helper file
try {
    $resp = createOrder($amount, "thali");
} catch (Exception $e) {
    $message = $e->getMessage();
    // TODO: display message
    exit(0);
}

if ($resp["code"] != 200) {
    /*
    array (size=2)
    'code' => int 400
    'data' => 
        array (size=3)
        'message' => string 'order_expiry_time : Expiry time should be more than 15 min and less than 30 days' (length=80)
        'code' => string 'order_expiry_time_invalid' (length=25)
        'type' => string 'invalid_request_error' (length=21)
    */
    $message = "Something went wrong with order creation server side! \n";
    echo $message;
    $server_message = $resp["data"]["message"];
    $server_error_code = $resp["data"]["code"];
    $server_error_type = $resp["data"]["type"];
    var_dump($resp);
    // TODO: display message
    // echo json_encode($resp["data"]);
    // exit out - most likely the payment gateway is down
    exit(0);
}

$data = $resp["data"];
$customer_details = $data["customer_details"];
$thaliId = $customer_details["customer_id"];
$mobile = $customer_details["customer_phone"];
$email = $customer_details["customer_email"];
$orderId = $data["order_id"];
$amount = $data["order_amount"];
$status = $data["order_status"]; # ACTIVE
$gwName = "cashfree";
$query =    "insert into order_details ".
            "(thali_id, mobile,     email,      payment_type, gw_order_id,    amount,     gw_status,  gw_name     ) values ".
            "($thaliId, '$mobile',  '$email',   'thali',      '$orderId',     $amount,    '$status',  '$gwName'   )";

$result = mysqli_query($link, $query) or die(mysqli_error($link));

$paymentLink = $data["payment_link"];
header("Location: $paymentLink");


/*
Order: create link with

Flow:
Order is created:
    1. store order id in Transaction table along with other necessary details, customer_id mobile_number, etc
    2. wait for PG to call return.php
    3. update Txn table with status from PG response
        > success: create receipt
        > failure: send back to payment.php giving reason why it failed
    4. create receipt (and also download/whatsapp)
Failure scenarios to be tested/implemented
    > Abort if any issue creating the order
    > Abort if you cannot update transaction table (sql error)
    > Disable double click on "Pay Now" (payment.php)

createOrder returns this:
array (size=2)
  'code' => int 200
  'data' => 
    array (size=17)
      'cf_order_id' => int 2439764
      'order_id' => string 'order_10325729BDUMTFEIOfJ9nBaPrAV27u4gl' (length=39)
      'entity' => string 'order' (length=5)
      'order_currency' => string 'INR' (length=3)
      'order_amount' => float 5
      'order_expiry_time' => string '2022-06-14T06:49:59+05:30' (length=25)
      'customer_details' => 
        array (size=4)
          'customer_id' => string '859' (length=3)
          'customer_name' => null
          'customer_email' => string 'abc@xyz.com' (length=19)
          'customer_phone' => string '1234567890' (length=10)
      'order_meta' => 
        array (size=3)
          'return_url' => string 'https://1123-60-254-88-207.in.ngrok.io/users/return.php?orderId={order_id}&token={order_token}' (length=98)
          'notify_url' => null
          'payment_methods' => null
      'settlements' => 
        array (size=1)
          'url' => string 'https://sandbox.cashfree.com/pg/orders/order_10325729BDUMTFEIOfJ9nBaPrAV27u4gl/settlements' (length=90)
      'payments' => 
        array (size=1)
          'url' => string 'https://sandbox.cashfree.com/pg/orders/order_10325729BDUMTFEIOfJ9nBaPrAV27u4gl/payments' (length=87)
      'refunds' => 
        array (size=1)
          'url' => string 'https://sandbox.cashfree.com/pg/orders/order_10325729BDUMTFEIOfJ9nBaPrAV27u4gl/refunds' (length=86)
      'order_status' => string 'ACTIVE' (length=6)
      'order_token' => string 'PBEqMMTJZLCgKbbNOsDE' (length=20)
      'order_note' => null
      'payment_link' => string 'https://payments-test.cashfree.com/order/#PBEqMMTJZLCgKbbNOsDE' (length=62)
      'order_tags' => 
        array (size=1)
          'paymentType' => string 'thali' (length=5)
      'order_splits' => 
        array (size=0)
          empty

*/