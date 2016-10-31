<?php
include('connection.php');

if($_POST)
{
mysqli_query($link,"INSERT INTO daily_hisab_items (`date`, `items`,`quantity`,`amount`) VALUES ('" . $_POST['date1'] . "', '" . $_POST['item'] . "','" . $_POST['quantity'] . "','" . $_POST['amount'] . "')") or die(mysqli_error($link));

 header("Location: /users/_daily_hisab_entry.php");

}
?>