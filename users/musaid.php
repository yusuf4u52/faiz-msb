<?php
include('_authCheck.php');
if ($_POST) { 
	if(!empty($_POST['comment']) || !empty($_POST['date'])) {
    	mysqli_query($link,"INSERT INTO `hub_commitment` (`thali`, `comments`, `commit_date`) VALUES ('".$_POST['Thali']."', '".$_POST['comment']."', '".$_POST['date']."')") or die(mysqli_error($link));
	}
header("Location: musaid.php");
exit;
}
                          
?>
<!DOCTYPE html>
<html>
<head>
	<title>Musaid Home</title>
	<?php include('_head.php'); ?>
	<?php include('_bottomJS.php'); ?>
	<script>
	  $( function() {
	    $( ".datepicker" ).datepicker({ dateFormat: 'yy-mm-dd' });
	  } );
  	</script>
</head>
<body>
	<?php include('_nav.php'); ?>
	<div class="container">
		<table class="table table-hover">
		  <thead>
		    <tr>
		      <th scope="col">Thali#</th>
		      <th scope="col">Name</th>
		      <th scope="col">Contact</th>
		      <th scope="col">Total Hub</th>
		      <th scope="col">Pending</th>
		      <th scope="col">Action</th>
		      <th scope="col">Commited Date</th>
		      <th scope="col">Comments</th>
		      <th scope="col">Action</th>
		    </tr>
		  </thead>
		  <tbody>
				<?php
				$result=mysqli_query($link,"SELECT Thali, Name, contact, yearly_hub, total_pending, WhatsApp FROM thalilist where total_pending > 0 and musaid='".$_SESSION['email']."'");

		      while($values = mysqli_fetch_assoc($result))
		      {
		      	$last_comments=mysqli_query($link,"SELECT * FROM hub_commitment where thali='".$values['Thali']."'");
		      	 	$all_data = mysqli_fetch_all($last_comments);
				    $all_comments=array_column($all_data,2);

		    ?>
		    <form method="post">
			    <tr>
			      <input type='hidden' value='<?php echo $values['Thali']; ?>' name='Thali'>
			      <td><?php echo $values['Thali']; ?></td>
			      <td><?php echo $values['Name']; ?></td>
			      <td><?php echo $values['contact']; ?></td>
			      <td><?php echo $values['yearly_hub']; ?></td>
			      <td><?php echo $values['total_pending']; ?></td>
			      <td><a target="_blank" href="https://wa.me/91<?php echo explode(" ", $values['WhatsApp'])[1]; ?>?text=Salaam Bhai, Tamari FMB ni hub pending che. Tame kivar tak ada karso?">WhatsApp</a></td>
			      <td><input type="text" name="date" class="datepicker" autocomplete="off"></td>
			      <td><?php echo "<pre>".implode(",\n",$all_comments)."</pre>"; ?><textarea name="comment" class="form-control" rows="3"></textarea></td>
			      <td><input type='submit' value="Save"></td>
			    </tr>
			</form>
		    <?php } ?>
		  </tbody>
		</table>
	</div>
</body>
</html>