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
    error_log("error while creating order - check if payment gateway is down?");
    error_log(var_export($resp, true));
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
