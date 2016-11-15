<?php
include('connection.php');
include('adminsession.php');
error_reporting(0);

$months = array(
                    '09' => 'Ramazan',
                    '10' => 'Shawwal',
                    '11' => 'Zilqad',
                    '12' => 'Zilhaj',
                    '01' => 'Moharram',
                    '02' => 'Safar',
                    '03' => 'RabiulAwwal',
                    '04' => 'RabiulAkhar',
                    '05' => 'JamadalAwwal',
                    '06' => 'JamadalAkhar',
                    '07' => 'Rajab',
                    '08' => 'Shaban'
                    );


?>

<html>
<head>
<?php include('_head.php'); ?>
</head>
  <body>
<?php include('_nav.php'); ?>
<div class="container">
<table class="table table-striped table-hover table-responsive table-bordered">
  <thead>
    <tr>
        <th>Months</th>
        <th>Hub Received</th>
        <th>Amount Given</th>
        <th>Fixed Cost</th>
        <th class='success'>Total Savings</th>
        <th>Zabihat Maula(TUS)</th>
        <th>Zabihat Students</th>
        <th>Used</th>
        <th>Remaining</th>
        <th>Actions</th>
    </tr>
  </thead>

  <tbody>
  	
  	<?php
    
  	foreach ($months as $key => $value) {
  	  $key == $key + 1;
	  $result = mysqli_query($link,"SELECT SUM(Amount) as Amount FROM receipts where Date like '%-$key-%'");
	  $hub_received = mysqli_fetch_assoc($result);

	  $result1 = mysqli_query($link,"SELECT SUM(Amount) as Amount FROM account where Date like '%-$key-%' AND Type = 'Cash'");
	  $cash_paid = mysqli_fetch_assoc($result1);

	  $result2 = mysqli_query($link,"SELECT SUM(Amount) as Amount FROM account where Date like '%-$key-%' AND Type != 'Cash'");
	  $fixed_cost = mysqli_fetch_assoc($result2);


	
    ?>
    <tr>
    <td><?php echo $value; ?></td>
	<td><?php echo $hub_received['Amount']; ?></td>
	<td><?php echo $cash_paid['Amount']; ?></td>
	<td><?php echo $fixed_cost['Amount']; ?></td>
	<td><?php echo $hub_received['Amount'] - $cash_paid['Amount'] - $fixed_cost['Amount']; ?></td>
	</tr>
	<?php } ?>
  </tbody>
</table>
</div>
</body>
</html>