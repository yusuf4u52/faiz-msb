<?php
include('connection.php');
include('_authCheck.php');
require '../vendor/autoload.php'; 
require 'get_receipt_html.php';

$receiptTemplate = file_get_contents("receipt.html");
$sql = "select * from receipts ORDER BY Receipt_No ASC";
$result= mysqli_query($link,$sql);

$pdfContent = "";
while($values = mysqli_fetch_assoc($result))
{
    $pdfContent .=  getReceiptHtml($link,$receiptTemplate, $values);
    break;
}

$dompdf = new \Dompdf\Dompdf();
$dompdf->loadHtml($pdfContent);

// $dompdf->setPaper('A4', 'landscape');
$dompdf->setPaper(array(0,0,720,550));
$dompdf->render();
$dompdf->stream("",array("Attachment" => false));

// $dompdf->stream("receipts.pdf");
// $output = $dompdf->output();
// file_put_contents('Brochure.pdf', $output);
exit(0);