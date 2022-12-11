<?php
require_once('connection.php');
include('_authCheck.php');
require 'get_receipt_html.php';
require 'get_receipt_pdf.php';


$receiptTemplate = file_get_contents("receipt.html");
$sql = "";

if (!empty($_GET['thalino'])) {
    $sql = "select * from receipts WHERE Thali_No = ". real_escape_string($_GET['thalino']) . " ORDER BY Receipt_No ASC";
} else {
    $sql = "select * from receipts ORDER BY Receipt_No ASC";
}

$result= mysqli_query($link,$sql);

$pdfContent = "";
while($values = mysqli_fetch_assoc($result))
{
    $pdfContent .=  getReceiptHtml($link,$receiptTemplate, $values);
}

generate_pdf($pdfContent);

exit(0);
