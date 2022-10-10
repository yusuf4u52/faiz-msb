<?php
require_once "common.php";
include('connection.php');
// include('googlesheet.php');
require 'get_receipt_html.php';
require 'get_receipt_pdf.php';

function echoSuccessOrFailurePage($errorMessage, $orderId)
{
?>
  <style>
    .button {
      background-color: #4CAF50;
      /* Green */
      border: none;
      color: white;
      padding: 15px 32px;
      text-align: center;
      text-decoration: none;
      display: inline-block;
      font-size: 16px;
      margin: 4px 2px;
      cursor: pointer;
      border-radius: 4px;
    }

    .error {
      color: red;
      font-size: 16px;
      text-align: center;
    }
  </style>
  <div style="text-align:center">
    <span>
      <p class='error'><?= $errorMessage ?></p>
      <a class='button' href="index.php">Home</a>
      <a class='button' href="hoobHistory.php" style="background-color: #008CBA">Receipts</a>
      <?php if (!$errorMessage) { ?>
        <a class='button' href="download_receipt_pdf.php?order_id=<?= $orderId ?>" style="background-color: chocolate">Download Again</a>
        <p style="font-size: 12px"> Kindly allow pop-ups to download the receipt </p>
        <script type="text/javascript">
          window.onload = function() {
            url = "download_receipt_pdf.php?order_id=<?= $orderId ?>";
            console.log(url);
            window.open(url, "_blank");
          }
        </script>
      <?php } ?>
    </span>
  </div>
<?php
}

function pollOrderStatus($orderId, $timeout = 20, $interval = 2)
{
  // This function polls the order_details table and retrieves
  // the updated order status that notify.php has written
  // timeout = The total time to spend polling
  // interval = waiting time before checking database again
  // all time values are in seconds
  global $link;

  $current_time = time();
  $final_time = $current_time + $timeout;
  while ($current_time <= $final_time) {
    $query = "select gw_status, Receipt_No from order_details where gw_order_id='$orderId'";
    $result = mysqli_query($link, $query);
    $num_rows = mysqli_num_rows($result);
    if ($num_rows == 0) {
      die("FATAL ERROR: Order id $orderId doesn't exist in the table.");
    }
    if ($num_rows > 1) {
      die("FATAL ERROR: Multiple order ids $orderId exist in the table.");
    }
    $row = mysqli_fetch_row($result);
    // We want to wait till order status AND receipt is updated in DB
    if ($row[0] == "PAID" && $row[1] != null) {
      return array("status" => $row[0], "receiptNo" => $row[1]);
    }
    // We wait if order is still processing OR order is PAID but receipt generation is pending
    else if ($row[0] == "ACTIVE" || $row[0] == "PAID") {
      sleep($interval);
      $current_time = time();
    }
    // otherwise we report error and break from polling
    else {
      break;
    }
  }
  return array("error" => "Order status not updated", "status" => $row[0]);
}

if ($_GET) {
  $orderId = $_GET["orderId"];
  // $orderToken = $_GET["token"];

  //check if order is already paid and if order token and id match
  $polled = pollOrderStatus($orderId);
  if (array_key_exists("error", $polled)) {
    $errorMessage = "ERROR: Unable to get updated order status for order id:<br/>$orderId";
    echoSuccessOrFailurePage($errorMessage, null);
  } else {
    $status = $polled['status'];
    $receiptNo = $polled['receiptNo'];
    // $status_from_server = $response_body["data"]["order_status"];

    $receiptTemplate = file_get_contents("receipt.html");
    $sql = "select * from receipts where Receipt_No=$receiptNo";
    $result = mysqli_query($link, $sql);
    $receiptDetails = mysqli_fetch_assoc($result);
    $content = getReceiptHtml($link, $receiptTemplate, $receiptDetails);
    // generate_pdf($content);
    echo $content;
    echoSuccessOrFailurePage(null, $orderId);
  }
} else {
  die("Wrong protocol");
}  



/*
successful payment scenario

------------------/orders/order_id------------------
array (size=18)
  'cf_order_id' => int 2444037
  'created_at' => string '2022-05-17T07:10:44+05:30' (length=25)
  'customer_details' => 
    array (size=4)
      'customer_id' => string '859' (length=3)
      'customer_name' => null
      'customer_email' => string 'abc@xyz.com' (length=19)
      'customer_phone' => string '1234567890' (length=10)
  'entity' => string 'order' (length=5)
  'order_amount' => float 12
  'order_currency' => string 'INR' (length=3)
  'order_expiry_time' => string '2022-05-17T07:26:43+05:30' (length=25)
  'order_id' => string 'order_10325729GuG9iorbfO1tOGWVOMBByjQD5' (length=39)
  'order_meta' => 
    array (size=3)
      'return_url' => string 'https://4c76-116-72-42-49.in.ngrok.io/users/return.php?orderId={order_id}&token={order_token}' (length=97)
      'notify_url' => string 'https://4c76-116-72-42-49.in.ngrok.io/users/test.php' (length=56)
      'payment_methods' => null
  'order_note' => null
  'order_splits' => 
    array (size=0)
      empty
  'order_status' => string 'PAID' (length=4) (The order status -ACTIVE, PAID, EXPIRED.)
  'order_tags' => 
    array (size=1)
      'paymentType' => string 'thali' (length=5)
  'order_token' => string 'FqQ2ACKGwfqUGflMecr9' (length=20)
  'payment_link' => string 'https://payments-test.cashfree.com/order/#FqQ2ACKGwfqUGflMecr9' (length=62)
  'payments' => 
    array (size=1)
      'url' => string 'https://sandbox.cashfree.com/pg/orders/order_10325729GuG9iorbfO1tOGWVOMBByjQD5/payments' (length=87)
  'refunds' => 
    array (size=1)
      'url' => string 'https://sandbox.cashfree.com/pg/orders/order_10325729GuG9iorbfO1tOGWVOMBByjQD5/refunds' (length=86)
  'settlements' => 
    array (size=1)
      'url' => string 'https://sandbox.cashfree.com/pg/orders/order_10325729GuG9iorbfO1tOGWVOMBByjQD5/settlements' (length=90)

------------------/orders/order_id/payments/------------------
array (size=2)
  'code' => int 200
  'data' => 
    array (size=1)
      0 => 
        array (size=15)
          'auth_id' => null
          'authorization' => null
          'bank_reference' => string '13000' (length=5)
          'cf_payment_id' => int 885218110
          'entity' => string 'payment' (length=7)
          'is_captured' => boolean true
          'order_amount' => float 12
          'order_id' => string 'order_10325729GuG9iorbfO1tOGWVOMBByjQD5' (length=39)
          'payment_amount' => float 12
          'payment_currency' => string 'INR' (length=3)
          'payment_group' => string 'credit_card' (length=11)
          'payment_message' => string 'Transaction pending' (length=19)
          'payment_method' => 
            array (size=1)
              ...
          'payment_status' => string 'SUCCESS' (length=7)
          'payment_time' => string '2022-05-17T07:10:47+05:30' (length=25)

------------------notifyUrl------------------
array (
  'orderId' => 'order_10325729GuG9iorbfO1tOGWVOMBByjQD5',
  'orderAmount' => '12.00',
  'referenceId' => '885218110',
  'txStatus' => 'SUCCESS',
  'paymentMode' => 'CREDIT_CARD',
  'txMsg' => 'Transaction pending',
  'txTime' => '2022-05-17 07:10:47',
  'signature' => '7gCEY4JG2P6IyPr+1DKMorPUey/SiNq5oyeqnrSiD6o=',
)
source: https://docs.cashfree.com/docs/checkout#generate-signature
Parameter	Description
orderId	Order ID for which transaction has been processed.
Example, GZ-212
orderAmount	Bill amount of the order. Example, 256.00
referenceId	Cashfree generated unique transaction ID. Example, 140388038803
txStatus	Payment status for that order. Values can be: SUCCESS, FLAGGED, PENDING, FAILED, CANCELLED, USER_DROPPED.
paymentMode	Payment mode used by customers to make the payment. Example, DEBIT_CARD, PREPAID_CARD, MobiKwik.
txMsg	Message related to the transaction. Payment failure reason is included here.
txTime	Time of the transaction
signature	Response signature.

order state vs transaction state:
https://docs.cashfree.com/docs/transaction-lifecycle
*/
