<?php
include('connection.php');
include('adminsession.php');

if($_POST)
{
  
  $sql = "INSERT INTO account (`Date`, `Type`, `Amount`, `Month`) VALUES ('" . $_POST['sf_amount_date'] . "','" . $_POST['salary'] . "','" . $_POST['Amount'] . "','" . $_POST['Month'] . "')";
  mysqli_query($link, $sql) or die(mysqli_error($link));

if ($_POST['salary'] == 'Cash')
  	{
  $sql = "UPDATE hisab set Amount_for_Jaman_to_SF = Amount_for_Jaman_to_SF + '" . $_POST['Amount'] . "' WHERE Months = '" . $_POST['Month']."'";
  mysqli_query($link, $sql) or die(mysqli_error($link));
	}
	elseif ($_POST['salary'] == 'Zabihat')
	{
		$sql = "UPDATE hisab set Used = Used + '" . $_POST['Amount'] . "' WHERE Months = '" . $_POST['Month']."'";
  		mysqli_query($link, $sql) or die(mysqli_error($link));
	}
  else {
  	$sql = "UPDATE hisab set Fixed_Cost = Fixed_Cost + '" . $_POST['Amount'] . "' WHERE Months = '" . $_POST['Month']."'";
  	mysqli_query($link, $sql) or die(mysqli_error($link));
 		}

  echo "success";

}