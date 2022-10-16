<?php
require_once "common.php";
require_once('connection.php');
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
