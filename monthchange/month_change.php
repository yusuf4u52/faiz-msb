<?php
include('../users/connection.php');
include('../users/adminsession.php');
if($_POST) {
$query = file_get_contents("month_change.sql");
$query = str_replace('%month%', $_POST['year'], $query);
/* execute multi query */
if (mysqli_multi_query($link, $query))
     echo "Success";
else 
     echo "Fail";
}
?>
<!DOCTYPE html>
<html>
<head>
	<title>Create a new sheet</title>
</head>
<body>
<form method="POST">
<select name="year">
	<?php
	for ($i=1438;$i<=1450;$i++) { ?>
		<option value="<?php echo $i; ?>"><?php echo $i; ?></option>
	<?php } ?>
</select>
<input type="submit" value="Submit">
</form>
</body>
</html>