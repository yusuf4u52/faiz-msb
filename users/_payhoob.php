<?php
require_once('connection.php');
include('adminsession.php');
include('../sms/_helper.php');
require_once('_payhoob_helper.php');

if ($_POST) {
  //validate payment type is provided
  if (empty($_POST['payment'])) {
    echo "Provide payment type (Bank or Cash)";
    exit();
  }

  //validate if payment is by bank then transaction ID is also provided.
  if ($_POST['payment'] == 'Bank' && empty($_POST['transaction_id'])) {
    echo "Provide payment transaction ID of the transfer";
    exit();
  }

  //validate receipt amount provided.
  if (is_null($_POST['receipt_amount'])) {
    echo "Provide receipt amount";
    exit();
  }

  if ($_POST['payment'] == 'Cash') {
    $_POST['transaction_id'] = null;
  }

  $receiptNumber = createReceipt($_POST['receipt_thali'], $_POST['receipt_amount'], $_POST['payment'], $_SESSION['email'], $_POST['transaction_id']);
  if ($receiptNumber) {
    echo "Success\n";
  }
  $userThali = $_POST['receipt_thali'];
  $userAmount = $_POST['receipt_amount'];
  $sql = mysqli_query($link, "SELECT NAME, CONTACT from thalilist where Thali='" . $userThali . "'");
  $row = mysqli_fetch_row($sql);
  $userName = helper_getFirstNameWithSuffix($row[0]);
  $smsTo = $row[1];
  $userPending = helper_getTotalPending($userThali);
  // use \n in double quoted strings for new line character
  $smsBody = "Mubarak *$userName* for contributing Rs. *$userAmount* (R.No. *$receiptNumber*) in FMB. Moula TUS nu ehsan che ke apne jamarwa ma shamil kare che.\n"
    . "Thali#: *$userThali*\n"
    . "Pending: *$userPending*";
  sendWhatsapp($smsBody, $smsTo);
  echo $smsBody;
}
