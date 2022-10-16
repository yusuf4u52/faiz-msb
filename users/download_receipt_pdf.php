<?php
require_once('connection.php');
require 'get_receipt_html.php';
require 'get_receipt_pdf.php';

if($_GET) {
    /*
    instead of order_id, one could've used receipt no as well to download the receipt
    but the usage of order_id prevents other non-authenticated users to browse other people's
    receipts as guessing the order_id is not possible, whereas guessing receipt number is very easy.
    */
    if(!isset($_GET['order_id'])) {
        die("Please supply order_id param");
    }
    $orderId = $_GET['order_id'];
    $sql = "SELECT r.* FROM `order_details` od inner join receipts r on od.receipt_no=r.Receipt_No where od.gw_order_id='$orderId'";
    $result= mysqli_query($link,$sql);
    $row = mysqli_fetch_assoc($result);
    if(!$row) {
        die("Couldn't find the receipt details for this order");
    }
    $receiptTemplate = file_get_contents("receipt.html");
    $htmlContent =  getReceiptHtml($link,$receiptTemplate, $row);

    generate_pdf($htmlContent);
} else {
    die ("Wrong protocol");
}
