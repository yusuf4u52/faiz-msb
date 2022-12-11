<?php
require_once('connection.php');
include('_authCheck.php');
require 'get_receipt_html.php';
require 'get_receipt_pdf.php';


$receiptTemplate = file_get_contents("receipt.html");
$sql = "";

if (!empty($_GET['receiptno'])) {
    $sql = "select * from receipts WHERE Receipt_No  = ". mysqli_real_escape_string($link,$_GET['receiptno']) . " AND Thali_No in (select Thali from thalilist where Email_ID = \"" . $_SESSION['email'] ."\") ORDER BY Receipt_No ASC";
} else {
    exit(1);
}

$result= mysqli_query($link,$sql);

$rowcount = mysqli_num_rows($result);

if($rowcount < 1) exit(1);

$pdfContent = "";
while($values = mysqli_fetch_assoc($result))
{
    $pdfContent .=  getReceiptHtml($link,$receiptTemplate, $values);
}

generate_pdf($pdfContent, "receipt_". mysqli_real_escape_string($link,$_GET['receiptno']) . ".pdf" );

exit(0);
