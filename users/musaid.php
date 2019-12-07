<?php
include('_authCheck.php');
if ($_POST) { 
	if(!empty($_POST['date']) && !empty($_POST['rs']) && !empty($_POST['comment'])) {
		echo "1sst";
    	mysqli_query($link,"INSERT INTO `hub_commitment` (`thali`, `comments`, `commit_date`, `rs`) VALUES ('".$_POST['Thali']."', '".$_POST['comment']."', '".$_POST['date']."', '".$_POST['rs']."')") or die(mysqli_error($link));
	} else if(!empty($_POST['date'] && !empty($_POST['rs']))) {
		echo "2ndt";
		mysqli_query($link,"INSERT INTO `hub_commitment` (`thali`, `commit_date`, `rs`) VALUES ('".$_POST['Thali']."', '".$_POST['date']."', '".$_POST['rs']."')") or die(mysqli_error($link));
	} else if(!empty($_POST['comment'])) {
		echo "3rd";
		mysqli_query($link,"INSERT INTO `hub_commitment` (`thali`, `comments`) VALUES ('".$_POST['Thali']."', '".$_POST['comment']."')") or die(mysqli_error($link));
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
		      <th scope="col">Commited Date/RS</th>
		      <th scope="col">Comments</th>
		      <th scope="col">Action</th>
		    </tr>
		  </thead>
		  <tbody>
				<?php
				$result=mysqli_query($link,"SELECT Thali, Name, contact, yearly_hub, total_pending, WhatsApp FROM thalilist where total_pending > 0 and musaid='".$_SESSION['email']."'");

		      while($values = mysqli_fetch_assoc($result))
		      {
		      	$commit=mysqli_query($link,"SELECT concat(commit_date, ' / ', rs) FROM hub_commitment where rs !=0 and thali='".$values['Thali']."'");
		      	 	$all_data = mysqli_fetch_all($commit);
				    $all_dates=array_column($all_data,0);
				$comments=mysqli_query($link,"SELECT comments FROM hub_commitment where comments is not null and thali='".$values['Thali']."'");
		      	 	$all = mysqli_fetch_all($comments);
				    $all_comments=array_column($all,0);
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
			      <td><?php echo "<pre>".implode(",\n",$all_dates)."</pre>"; ?><input type="text" name="date" class="datepicker" autocomplete="off"><input type="number" name="rs"></td>
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