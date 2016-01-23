<?php  
error_reporting(0);
//connect to the database 
$connect = mysql_connect("mysql.hostinger.in","u380653844_faiz","password"); 
mysql_select_db("u380653844_sms",$connect); //select the table
// 

if ($_FILES['csv']['size'] > 0) { 

	//get the csv file 
	$file = $_FILES['csv']['tmp_name']; 
	$handle = fopen($file,"r"); 
	 
	//loop through the csv file and insert into database 
	$i = 0;
	 while ($data = fgetcsv($handle,1000,",","'")){ 

		if($i == 0){
			$i++;
			continue;
		}
		
		if ($data[0]) { 
			mysql_query("INSERT INTO contact (`thali_no`, `name`, `number`,`amount`, `active`) VALUES 
				( 
					'".addslashes($data[0])."',
					'".addslashes($data[1])."',
					'".addslashes($data[2])."',
					'".addslashes($data[3])."',
					'1'
				) 
			"); 
		} 
	} 
	// 

	//redirect 
	header('Location: import.php?success=1'); die; 

} 

?> 

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd"> 
<html xmlns="http://www.w3.org/1999/xhtml"> 
<head> 
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" /> 
<title>Import a CSV File with PHP & MySQL</title> 
</head> 

<body> 

<?php if (!empty($_GET['success'])) { echo "<b>Your file has been imported.</b><br><br>"; } //generic success notice ?> 

<form action="" method="post" enctype="multipart/form-data" name="form1" id="form1"> 
  Choose your file: <br /> 
  <input name="csv" type="file" id="csv" /> 
 <input type="submit" name="Submit" value="Submit" /> 
<a href="sms_sample.csv">Download Sample</a>
  <br><br><input type="button" name="Submit" value="Send SMS" onclick="window.location='index.php'" /> 
</form> 

</body> 
</html> 