<?php

include('connection.php');

session_start();




if (is_null($_SESSION['fromLogin'])) {



 //send them back

   header("Location: login.php");

}

else {

$result = mysqli_query($link,"SELECT * from thalilist WHERE Active='1' AND Email_id = '".$_SESSION['email']."'");

$count=mysqli_num_rows($result);
$status = 'Already Active';


if ($count == 0) {

mysqli_query($link,"UPDATE thalilist set Active='1' WHERE Email_id = '".$_SESSION['email']."'");
mysqli_query($link,"UPDATE thalilist set Thali_start_date='" . $_POST['start_date'] . "' WHERE Email_id = '".$_SESSION['email']."'");

$capture = mb_substr($_POST['start_date'], -2);

$result1 = mysqli_query($link,"SELECT * from thalilist WHERE Dues=0 AND Email_id = '".$_SESSION['email']."'");
$count1=mysqli_num_rows($result1);

		if ($count1 == 1) {

			if ($capture >= 1 && $capture <= 10)
			{
				mysqli_query($link,"UPDATE thalilist set Dues='1800' WHERE Email_id = '".$_SESSION['email']."'");
				mysqli_query($link,"UPDATE thalilist set TranspFee='250' WHERE Transporter != 'Pick Up' AND Email_id = '".$_SESSION['email']."'");
			}
			elseif ($capture >= 11 && $capture <= 20)
			{
				mysqli_query($link,"UPDATE thalilist set Dues='1200' WHERE Email_id = '".$_SESSION['email']."'");
				mysqli_query($link,"UPDATE thalilist set TranspFee='180' WHERE Transporter != 'Pick Up' AND Email_id = '".$_SESSION['email']."'");
			}
			else
			{	
				mysqli_query($link,"UPDATE thalilist set Dues='600' WHERE Email_id = '".$_SESSION['email']."'");
				mysqli_query($link,"UPDATE thalilist set TranspFee='90' WHERE Transporter != 'Pick Up' AND Email_id = '".$_SESSION['email']."'");
			}

						}




mysqli_query($link,"INSERT INTO change_table (`Thali`, `Operation`, `Date`) VALUES ('" . $_SESSION['thali'] . "', 'Start Thali','" . $_POST['start_date'] . "')");

$myfile = fopen("startthali.txt", "a") or die("Unable to open file!");

$txt="".$_SESSION['thali']." - ".$_SESSION['name']." - ".$_SESSION['contact']." - ".$_SESSION['address']."\n";

fwrite($myfile, $txt);

fclose($myfile);
$status = 'Start Thali Successful';

 }

header("Location: index.php?status=$status");

}

?>