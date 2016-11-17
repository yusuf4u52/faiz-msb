<?php
include('connection.php');
include('adminsession.php');

if($_POST)
{
  
  $sql = "INSERT INTO account (`Date`, `Type`, `Amount`, `Month`, `Remarks`) VALUES ('" . $_POST['sf_amount_date'] . "','" . $_POST['salary'] . "','" . $_POST['Amount'] . "','" . $_POST['Month'] . "','" . $_POST['desc'] . "')";
  mysqli_query($link, $sql) or die(mysqli_error($link));

if ($_POST['salary'] == 'Cash')
  	{
    $sql = "INSERT INTO sf_hisab (`date`, `items`, `quantity`, `amount`,`type`) VALUES ('" . $_POST['sf_amount_date'] . "','Cash','Cash','" . $_POST['Amount'] . "','Cr')";
    mysqli_query($link, $sql) or die(mysqli_error($link));
  	}
  echo "success";

}