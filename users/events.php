<?php
include('_authCheck.php');
include('connection.php');

function isResponseReceived($eventid)
{
	include('connection.php');
	$sql = "select * from event_response where eventid='".$eventid."' and thaliid = '".$_SESSION['thaliid']."'";
	$result= mysqli_query($link,$sql);
	if (mysqli_num_rows($result) > 0)
		return true;
	else
		return false;
}
?>
<!DOCTYPE html>
<html>
<head>
	<title>Event Registration</title>
	<?php include('_head.php'); ?>
	<?php include('_bottomJS.php'); ?>
</head>
<body>
	<?php include('_nav.php'); ?>
	<div class="container">
		<table class="table table-hover">
		  <thead>
		    <tr>
		      <th scope="col">Event Name</th>
		      <th scope="col">Date/Venue/Time</th>
		      <th scope="col">Confirmation</th>
		    </tr>
		  </thead>
		  <tbody>
				<?php
				$result=mysqli_query($link,"SELECT * FROM events");
		      while($values = mysqli_fetch_assoc($result))
		      {
		    ?>
		    <tr>
		      <th scope="row"><?php echo $values['name']; ?></th>
		      <td><?php echo $values['venue']; ?></td>
		      <td>Will You Attend?
				<button type="button" <?php echo isResponseReceived($values['id']) ? 'disabled' : ''; ?> data-eventid="<?php echo $values['id']; ?>" data-thaliid="<?php echo $_SESSION['thaliid']; ?>" data-response="yes" class="btn btn-info btn-sm">Yes</button>
				<button type="button" <?php echo isResponseReceived($values['id']) ? 'disabled' : ''; ?>  data-eventid="<?php echo $values['id']; ?>" data-thaliid="<?php echo $_SESSION['thaliid']; ?>" data-response="no" class="btn btn-info btn-sm">No</button>
		      </td>
		    </tr>
		    <?php } ?>
		  </tbody>
		</table>
	</div>
</body>
<script>
$(document).ready(function(){
    $("button").click(function(){
    	$("button").attr("disabled", true);
        $.post("event_response.php",
        {
          Response: $(this).data("response"),
          Thaliid: $(this).data("thaliid"),
          Eventid: $(this).data("eventid")
        },
        function(data,status){
            alert("Response Submitted Successfully");
        });
    });
});
</script>
</html>