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

<?php 
foreach ($months as $key => $month) {
  		$sf_breakup = mysqli_query($link, "SELECT * FROM account where Month = '".$month."'") or die(mysqli_error($link));
?>
<div class="modal" id="sfbreakup-<?php echo $month; ?>">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">Expense Breakdown</h4>
      </div>
      <div class="modal-body">
        <table class="table table-striped table-hover table-responsive">

                <thead>

                  <tr>
                    <th>Date</th>
                    <th>Type</th>
                    <th>Amount</th>
                    <th>Remarks</th>
                    <th>Month</th>
                  </tr>
                </thead>

                <tbody>

                    <?php
                    while($valuesnew = mysqli_fetch_assoc($sf_breakup))
                    {
                    ?>
                    <tr>
                    <td><?php echo $valuesnew['Date']; ?></td>
                    <td><?php echo $valuesnew['Type']; ?></td>
                    <td><?php echo $valuesnew['Amount']; ?></td>
                    <td><?php echo $valuesnew['Remarks']; ?></td>
                    <td><?php echo $valuesnew['Month']; ?></td>
                  </tr>                 
                   <?php } ?>
              
                </tbody>
              </table> 


      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>
<?php } ?>





<div class="modal" id="myModal">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">Enter the amount</h4>
      </div>
      <div class="modal-body">
        <div id="hisabform">
        <input class="form-control" type="text" class="gregdate" name="sf_amount_date" value="<?php echo date("Y-m-d") ?>"/><br>
        <input class="form-control" type="number" name="Amount" placeholder="Amount"/><br>
        <select class="form-control" name="salary">
                            <option value='Cash'>Cash</option>
                            <option value='Zabihat'>Zabihat</option>
                            <option value='BB Salary'>BB Salary</option>
                            <option value='SF Salary'>SF Salary</option>
                            <option value='BurhanBhai Tr'>BurhanBhai Tr</option>
                            <option value='HaiderBhai Tr'>HaiderBhai Tr</option>
                            <option value='AzharBhai Tr'>AzharBhai Tr</option>
                            <option value='AzizBhai Tr'>AzizBhai Tr</option>
                            <option value='NasirBhai Tr'>NasirBhai Tr</option>
                            <option value='Miraj Salary'>Miraj Salary</option>
                            <option value='Light Bill'>Light Bill</option>
                            <option value='Rent'>Rent</option>
                            <option value='Aapa'>Aapa</option>
                            <option value='Others'>Others</option>
        </select><br>
        <input type="hidden" name="Month"/>
        <input class="form-control" type="text" placeholder="Remarks" name="desc"/><br>
      </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal" name="cancel">Close</button>
        <button type="button" class="btn btn-primary" name="save">Save changes</button>
      </div>
    </div>
  </div>
</div>




<div class="container">
<table class="table table-striped table-hover table-responsive table-bordered">
  <thead>
    <tr>
        <th>Months</th>
        <th>Hub Received</th>
        <th>Amount Given</th>
        <th>Fixed Cost</th>
        <th class='success'>Total Savings</th>
        <th>Actions</th>
    </tr>
  </thead>

  <tbody>
  	
  	<?php
    $yearly_total_savings = 32000;
  	foreach ($months as $key => $value) {
  	  $key == $key + 1;
	  $result = mysqli_query($link,"SELECT SUM(Amount) as Amount FROM receipts where Date like '%-$key-%'");
	  $hub_received = mysqli_fetch_assoc($result);

	  $result1 = mysqli_query($link,"SELECT SUM(Amount) as Amount FROM account where Month = '".$value."' AND Type = 'Cash'");
	  $cash_paid = mysqli_fetch_assoc($result1);

	  $result2 = mysqli_query($link,"SELECT SUM(Amount) as Amount FROM account where Month = '".$value."' AND Type != 'Cash'");
	  $fixed_cost = mysqli_fetch_assoc($result2);
	  $yearly_total_savings += $hub_received['Amount'] - $cash_paid['Amount'] - $fixed_cost['Amount'];
	
    ?>
    <tr>
    <td><?php echo $value; ?></td>
	<td><?php echo $hub_received['Amount']; ?></td>
	<td><?php echo $cash_paid['Amount']; ?></td>
	<td><?php echo $fixed_cost['Amount']; ?></td>
	<td class="success"><?php echo $hub_received['Amount'] - $cash_paid['Amount'] - $fixed_cost['Amount']; ?></td>
	<td><a href="#" data-key="payhisab" data-month="<?php echo $value; ?>"><img src="images/add.png" style="width:20px;height:20px;"></a>&nbsp;
        <a data-key="Monthview" data-month="<?php echo $value; ?>" data-toggle="modal" href="#sfbreakup-<?php echo $value; ?>"><img src="images/view.png" style="width:20px;height:20px;"></a></td>	</tr>
	<?php } ?>
	<tr>
    <td colspan='3'></td>
    <td><strong>Cash In Hand</strong></td>
    <td class='success'><strong><?php echo $yearly_total_savings; ?></strong></td>
    <td colspan='1'></td>
    </tr>    	
  </tbody>
</table>

<table class="table table-striped table-hover table-responsive table-bordered">
  <thead>
    <tr>
		<th>Zabihat Maula(TUS)</th>
        <th>Zabihat Students</th>
		<th>Used</th>
		<th>Remaining</th>
    </tr>
  </thead>

  <tbody>
  	
  	<?php
    
	  $result = mysqli_query($link,"SELECT SUM(Zabihat) as Amount FROM thalilist");
	  $zab_students = mysqli_fetch_assoc($result);

	  $result1 = mysqli_query($link,"SELECT SUM(Amount) as Amount FROM account where Type = 'Zabihat'");
	  $zab_used = mysqli_fetch_assoc($result1);


    ?>
    <tr>
    <td>32000</td>
	<td><?php echo $zab_students['Amount']; ?></td>
	<td><?php echo $zab_used['Amount']; ?></td>
	<td><?php echo 32000 + $zab_students['Amount'] - $zab_used['Amount'] ; ?></td>
	</tr>
  </tbody>
</table>


</div>

<script src="javascript/jquery-2.2.0.min.js"></script>
    <script src="javascript/bootstrap-3.3.6.min.js"></script>
    <script src="javascript/moment-2.11.1-min.js"></script>
    <script src="javascript/moment-hijri.js"></script>
    <script src="javascript/hijriDate.js"></script>
    <script src="javascript/index.js"></script>
    <script src="./src/custom.js"></script>
<script>
$(function(){
      $(function(){
      var hisabform = $('#myModal');
      hisabform.hide();
      $('[data-key="payhisab"]').click(function() {
        $('[name="Month"]', hisabform).val($(this).attr('data-month'));
        hisabform.show();
      });
      $('[name="save"]').click(function() {
        var data = '';
        $('input[type!="button"],select', hisabform).each(function() {
          data = data + $(this).attr('name') + '=' + $(this).val() + '&';
        });
        $.ajax({
          method: 'post',
          url: '_payhisab_new.php',
          async: 'false',
          data: data,
          success: function(data) {
            if(data == 'success') {
              hisabform.hide();
              window.location.href = window.location.href; //reload
            // } else if(data == 'DuplicateReceiptNo') {
            //   alert('Receipt number already exists in database');
            }
            else {
              alert('Update failed. Please do not add receipt again unless you check system values properly');
            }
          },
          error: function() {
            alert('Try again');
          }
        });
      });

      $('[name="cancel"]').click(function() {
        hisabform.hide();
      });


      
      });
    });
  </script>
</body>
</html>