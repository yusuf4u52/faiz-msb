<?php
error_reporting(0);
$connect = mysql_connect("mysql.hostinger.in","u380653844_faiz","password"); 
mysql_select_db("u380653844_sms",$connect); //select the table
$query = "SELECT * FROM  `contact` WHERE  `amount` > 0 AND `active` = 1 AND 'number' <> ''";

if($_POST)
{
	
	$res = mysql_query($query);
	while($data = mysql_fetch_assoc($res))
	{
		//$dataset = $data;
		extract($data);
		extract($_POST);
		$message = stripslashes($message);
		$name = explode(" ",$data['name']);
		$name = $name[0];
		$message = str_replace(array("<THALINO>","<NAME>","<AMOUNT>"),array($thali_no,$name,$amount),$message);
		//echo $message."<br>";
		$message = urlencode($message);
		$result = file_get_contents("http://sms.myn2p.com/sendhttp.php?user=mustafamnr&password=mnr80211&mobiles=$number&message=$message&sender=FAIZST&route=Template");
//$result = file_get_contents("http://sms.almasaarr.com/sendsms.php?username=mustafamnr&password=mnr80211&sender=FAIZST&mobile=$number&message=$message&type=1");


		echo $result."<br>";
	}
}
else if($_GET['truncate'])
{
	mysql_query("truncate table `contact`");
} 
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd"> 
<html xmlns="http://www.w3.org/1999/xhtml"> 
<head> 
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" /> 
<title>Send SMS</title> 


<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.4.2/jquery.min.js" type="text/javascript"></script>
<script src="jquery.jqEasyCharCounter.min.js" type="text/javascript"></script>
<script type="text/javascript">
	$(document).ready(function(){
		
		$('.countable2').jqEasyCounter({
			'maxChars': 1000,
			'maxCharsWarning': 145
		});
		
});
</script>
<style>
th
{
	font-weight:bold;
}
</style>
</head> 

<body> 

<form action="" method="post" enctype="multipart/form-data" name="form1" id="form1">

<textarea name="message" style="height:150px; width:400px" class="countable2" id="message"></textarea>
<select id="holder">
	<option value="<THALINO>">Thali Number</option>
	<option value="<NAME>">Name</option>
	<option value="<AMOUNT>">Amount</option>
</select>
<input type="button" name="add" value="Add" onClick='document.getElementById("message").value += document.getElementById("holder").value;'>
 <input type="submit" name="msg" value="Send Message" onclick="return confirm('Are you sure?')">
 <input type="button" name="msg" value="Import" onclick="window.location='import.php'">

</form> 
<?php
	$res = mysql_query($query);
	$count = mysql_num_rows($res);
?>
<table border="1">
	<tr>
	<td colspan="5"><?php echo $count;?> Records - <a href="?truncate=true">Truncate</a></td>
	</tr>
	<tr> 
	<th>Thali No</th>
	<th>Name</th>
	<th>Amount</th>
	<th>Month</th>
	<th>Number</th>
	</tr>
	<?php
	while($data = mysql_fetch_assoc($res))
	{
	?>
	<tr>
	<td><?php echo $data['thali_no'];?></td>
	<td><?php echo $data['name'];?></td>
	<td><?php echo $data['amount'];?></td>
	<td>Zilkad</td>
	<td><?php echo $data['number'];?></td>
	</tr>
	<?php
	}
	?>
</table>
</body> 
</html> 
	