<?php

// Start the session
include('connection.php');
session_start();
if (is_null($_SESSION['fromLogin'])) {

 //send them back
   header("Location: login.php");
}

if (isset($_POST['submit']))
    {  
$result = mysqli_query($link,"UPDATE thalilist set NAME='" . $_POST["name"] . "',CONTACT='" . $_POST["contact"] . "',Full_Address='" . $_POST["address"] . "' WHERE Email_id = '".$_SESSION['email']."'");

$myfile = fopen("updatedetails.txt", "a") or die("Unable to open file!");
$txt="".$_SESSION['thali']." - ".$_POST['name']." - ".$_POST['contact']." - ".$_POST['address']." \n";
fwrite($myfile, $txt);
fclose($myfile);
 
        header('Location: index.php');       
    }

if (isset($_POST['cancel']))	{
	
	        header('Location: index.php');       
}
?>

<html>
<head>
<title>Update Details</title>
<link rel="stylesheet" type="text/css" href="styles.css" />
</head>
<body>
<form name="update_details" method="post" action="">
<div class="message"><?php if($message!="") { echo $message; } ?></div>
<table border="0" cellpadding="10" cellspacing="1" width="500" align="center">
<tr class="tableheader">
<td align="center" colspan="2">Update Details Form</td>
</tr>
<tr class="tablerow">
<td align="right">Name</td>
<td><input type="text" name="name" size="35" value="<?php echo $_SESSION['name'];?>"></td>
</tr>
<tr class="tablerow">
<td align="right">Contact</td>
<td><input type="contact" name="contact" size="35" value="<?php echo $_SESSION['contact'];?>"></td>
</tr>
<tr class="tablerow">
<td align="right">Address</td>
<td><textarea name="address" rows="4" cols="37"><?php echo $_SESSION['address']; ?></textarea></td>
</tr>
<tr class="tableheader">
<td align="center" colspan="2"><input type="submit" name="submit" value="Update"><input type="submit" name="cancel" value="Cancel"></td>
</tr>
</table>
</form>
</body></html>