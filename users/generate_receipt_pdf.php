<?php
include('connection.php');
include('_authCheck.php');
require 'get_receipt_html.php';
require 'get_receipt_pdf.php';


$receiptTemplate = file_get_contents("receipt.html");
$sql = "select * from receipts ORDER BY Receipt_No ASC";
$result= mysqli_query($link,$sql);

$pdfContent = "";
while($values = mysqli_fetch_assoc($result))
{
    $pdfContent .=  getReceiptHtml($link,$receiptTemplate, $values);
}

generate_pdf($pdfContent);

exit(0);
