<?php
include('_authCheck.php');
// role must be greater than musaid to see this page.

?>
<!DOCTYPE html>
<html>
<head>
	<title>Musaid Home</title>
	<?php include('_head.php'); ?>
	<?php include('_bottomJS.php'); ?>
	<script>
	  $( function() {
	    $( ".datepicker" ).datepicker({ dateFormat: 'dd/mm/yy' });
	  } );
  	</script>
</head>
<body>
	<?php include('_nav.php'); ?>

	<!-- Modal Window to add friends -->
	<div class="modal" id="modal">
	  <div class="modal-dialog" role="document">
	    <div class="modal-content">
	      <form method="post" action="event_add_friend.php">
	      <div class="modal-header">
	        <h5 class="modal-title">Add a friend</h5>
	        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
	          <span aria-hidden="true">&times;</span>
	        </button>
	      </div>
	      <div class="modal-body">
			  <fieldset>
			    <div class="form-group">
			      <label>ITS</label>
			      <input type="text" class="form-control" name="its" required placeholder="Enter ITS" pattern="[0-9]{8}">
			    </div>
			    <div class="form-group">
			      <label>Full Name</label>
			      <input type="text" class="form-control" name="name" required placeholder="Enter Full Name">
			    </div>
			    <div class="form-group">
			      <label>Mobile</label>
			      <input type="text" class="form-control" name="mobile" required placeholder="Enter Mobile" pattern="[0-9]{10}">
			    </div>
			    <input type="hidden" name="reference_id" id="add_friend_refid">
			    <input type="hidden" name="eventid" id="add_friend_eventid">
			  </fieldset>
	      </div>
	      <div class="modal-footer">
	        <button type="submit" class="btn btn-primary">Save changes</button>
	        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
	      </div>
	      </form>
	    </div>
	  </div>
	</div>

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
		    </tr>
		  </thead>
		  <tbody>
				<?php
				$result=mysqli_query($link,"SELECT Thali, Name, contact, yearly_hub, total_pending FROM thalilist where musaid='".$_SESSION['email']."'");
		      while($values = mysqli_fetch_assoc($result))
		      {
		    ?>
		    <tr>
		      <td><?php echo $values['Thali']; ?></td>
		      <td><?php echo $values['Name']; ?></td>
		      <td><?php echo $values['contact']; ?></td>
		      <td><?php echo $values['yearly_hub']; ?></td>
		      <td><?php echo $values['total_pending']; ?></td>
		      <td><a target="_blank" href="https://wa.me/91<?php echo $values['contact']; ?>?text=">WhatsApp</a></td>
		      <td><input type="text" class="datepicker"></td>
		    </tr>
		    <?php } ?>
		  </tbody>
		</table>
	</div>
</body>
<script>
$(document).ready(function(){
    $(".btn-response").click(function(){
    	$(".action-" + $(this).data("eventid")).attr("disabled", true);
    	$.ajaxSetup({
		    beforeSend: function(xhr) {
		        xhr.setRequestHeader('User-Agent', 'Googlebot/2.1 (+http://www.google.com/bot.html)');
		    }
		});
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

    $(".add_friend").click(function(){
    	$('#add_friend_refid').val($(this).data('thaliid'));
    	$('#add_friend_eventid').val($(this).data('eventid'));
    	$("#modal").modal();
    });
});
</script>
</html>