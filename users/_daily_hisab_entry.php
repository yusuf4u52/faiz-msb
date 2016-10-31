<?php
include('connection.php');
include('adminsession.php');

$result=mysqli_query($link,"SELECT * FROM daily_hisab order by id DESC limit 1") or die(mysqli_error($link));
$values = mysqli_fetch_assoc($result);

$result1=mysqli_query($link,"SELECT * FROM daily_hisab_items where date='".$values['date']."'") or die(mysqli_error($link));

?>

<html>
<head>
<?php include('_head.php'); ?>
<script src="javascript/jquery-2.2.0.min.js"></script>
<script src="javascript/bootstrap-3.3.6.min.js"></script>
</head>
<body>
<?php include('_nav.php'); ?>
<div class="container">
<div class="col-lg-4">
<ul class="list-group">
  <li class="list-group-item">
    <span class="badge"><?php echo $values['date']; ?></span>
    Date :
  </li>
  <li class="list-group-item">
    <span class="badge"><?php echo $values['thalicount']; ?></span>
    Thali Count :
  </li>
  <li class="list-group-item">
    <span class="badge"><?php echo $values['dish_with_roti']; ?></span>
    Dish with Roti :
  </li>
  <li class="list-group-item">
    <span class="badge"><?php echo $values['dish_with_rice']; ?></span>
    Dish with Rice :
  </li>
</ul>
</div>

  <table class="table table-striped table-hover ">
  <thead>
    <tr>
      <th>Item</th>
      <th>Quantity</th>
      <th>Amount</th>
    </tr>
  </thead>
  <tbody>
  <?php
    while($values1 = mysqli_fetch_assoc($result1))
                    {
                    	?>
    <tr>
      <td><?php echo $values1['items']; ?></td>
      <td><?php echo $values1['quantity']; ?></td>
      <td><?php echo $values1['amount']; ?></td>
    </tr>
    <?php } ?>
  </tbody>
</table>
<button type="button" class="btn btn-primary" data-target="#adddish" data-toggle="modal">Add Dish</button>
<button type="button" class="btn btn-primary" data-target="#additems" data-toggle="modal">Add Items</button>
</div>


<div class="modal" id="adddish">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title">Add Dish</h4>
      </div>
      <div class="modal-body">
	
	<form class="form-horizontal" method="post" action="savedish.php">
	<fieldset>
    <div class="form-group">
      <label for="inputEmail" class="col-lg-3 control-label">Date</label>
      <div class="col-lg-6">
        <input type="date" class="form-control" name="date1" value="<?php echo date("Y-m-d") ?>">
      </div>
    </div>
    <div class="form-group">
      <label for="thalicount" class="col-lg-3 control-label">Thali Count</label>
      <div class="col-lg-6">
        <input type="number" class="form-control" name="thalicount">
      </div>
    </div>
    <div class="form-group">
      <label for="dishroti" class="col-lg-3 control-label">Dish with Roti</label>
      <div class="col-lg-6">
        <input type="text" class="form-control" name="dishroti">
      </div>
    </div>
    <div class="form-group">
      <label for="dishrice" class="col-lg-3 control-label">Dish with Rice</label>
      <div class="col-lg-6">
        <input type="text" class="form-control" name="dishrice">
      </div>
    </div>
    </fieldset>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary">Save changes</button>
      </div>
      </form>
    </div>
  </div>
</div>


<div class="modal" id="additems">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title">Add Items</h4>
      </div>
      <div class="modal-body">
	
	<form class="form-horizontal" method="post" action="saveitems.php">
	<fieldset>
    <div class="form-group">
      <div class="col-lg-6">
        <input type="hidden" class="form-control" name="date1" value="<?php echo $values['date'] ?>">
      </div>
    </div>
    <div class="form-group">
      <label for="item" class="col-lg-3 control-label">Item</label>
      <div class="col-lg-6">
        <input type="text" class="form-control" name="item">
      </div>
    </div>
    <div class="form-group">
      <label for="quantity" class="col-lg-3 control-label">Quantity</label>
      <div class="col-lg-6">
        <input type="text" class="form-control" name="quantity">
      </div>
    </div>
    <div class="form-group">
      <label for="amount" class="col-lg-3 control-label">Amount</label>
      <div class="col-lg-6">
        <input type="number" class="form-control" name="amount">
      </div>
    </div>
    </fieldset>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary">Save changes</button>
      </div>
      </form>
    </div>
  </div>
</div>



</body>
</html>


