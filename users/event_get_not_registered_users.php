<?php
include('connection.php');
include('adminsession.php');

$eventid=$_GET['eventid'];
$event = mysqli_fetch_assoc(mysqli_query($link,"SELECT * FROM events where id=$eventid"));

?>
<!DOCTYPE html>
<html>
<head>
	<title>Not Registered</title>
	<?php include('_head.php'); ?>
	<?php include('_bottomJS.php'); ?>
</head>
<body>
	<?php include('_nav.php'); ?>

	<!-- Modal Window to add friends -->

	<div class="container">
		<h3><?php echo $event['name'].' - '.$event['venue']; ?></h3>
		<table class="table table-hover">
		  <thead>
		    <tr>
		      <th scope="col">Thali</th>
		      <th scope="col">ITS</th>
		      <th scope="col">Name</th>
		      <th scope="col">Mobile</th>
		    </tr>
		  </thead>
		  <tbody>
				<?php
				$result=mysqli_query($link,"SELECT * FROM thalilist where id not in (select thaliid from event_response where eventid=$eventid) and Active in (0,1) and Thali is not null");
		      while($values = mysqli_fetch_assoc($result))
		      {
		    ?>
		    <tr>
		      <td><?php echo $values['Thali']; ?></td>
		      <td><?php echo $values['ITS_No']; ?></td>
		      <td><?php echo $values['NAME']; ?></td>
		      <td><?php echo $values['CONTACT']; ?></td>
		    </tr>
		    <?php } ?>
		  </tbody>
		</table>
	</div>
</body>
</html>