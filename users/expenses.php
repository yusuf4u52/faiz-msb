<?php
include('connection.php');
include('adminsession.php');


error_reporting(0);

$current_month = mysqli_fetch_row(mysqli_query($link,"select `value` from `settings` where `key` = 'current_month'"));
$current_month = (int)$current_month[0];

$months = array('Moharram','Safar','RabiulAwwal','RabiulAkhar','JamadalAwwal','JamadalAkhar','Rajab','Shaban','Ramazan','Shawwal','Zilqad','Zilhaj');

foreach ($months as $key => $value) {

    if($key == $current_month - 1)
    {
      $query = "SELECT SUM(Amount) FROM receipts";
      $zabihat = "SELECT SUM(Zabihat) FROM thalilist";
    }
    else
    {
      $query = "SELECT SUM(Amount) FROM receipts_".$value;
      $zabihat = "SELECT SUM(Zabihat) FROM thalilist_".$value;;
    }

    $hub = mysqli_fetch_row(mysqli_query($link,$query));
    $hub1 = mysqli_fetch_row(mysqli_query($link,$zabihat));
    if(!empty($hub))
      mysqli_query($link, "UPDATE hisab set Hub_Received = '".$hub[0]."',Frm_Students = '".$hub1[0]."' WHERE Months = '".$value."'") or die(mysqli_error($link));

    if($key == $current_month - 1)
    {
      break;
    }
}
     
    $result = mysqli_query($link,"select * from hisab");

?>
<html>
<head>
<?php include('_head.php'); ?>
</head>
  <body>
<?php include('_nav.php'); ?>
<div class="modal" id="myModal">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">Enter the amount</h4>
      </div>
      <div class="modal-body">
        <div id="hisabform">
        <input type="number" name="Amount" placeholder="Amount"/>
        
        <select name="salary">
                            <option value='Cash'>Cash</option>
                            <option value='Zabihat'>Zabihat</option>
                            <option value='BB Salary'>BB Salary</option>
                            <option value='SF Salary'>SF Salary</option>
                            <option value='SF Transport'>SF Transport</option>
                            <option value='MB Transport'>MB Transport</option>
                            <option value='AZ Transport'>AZ Transport</option>
                            <option value='Miraj Salary'>Miraj Salary</option>
                            <option value='Light Bill'>Light Bill</option>
                            <option value='Rent'>Rent</option>
                            <option value='Aapa'>Aapa</option>
                            <option value='Others'>Others</option>
        </select>
        <input type="hidden" name="Month"/>
        <input type="text" class="gregdate" name="sf_amount_date" value="<?php echo date("Y-m-d") ?>"/>
      </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal" name="cancel">Close</button>
        <button type="button" class="btn btn-primary" name="save">Save changes</button>
      </div>
    </div>
  </div>
</div>

<!-- month wise expense -->
<?php 
foreach ($months as $month) {
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
<!-- month wise expense ends -->
     <div class="container">
<table class="table table-striped table-bordered table-hover table-responsive">

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
                    $yearly_total_savings = 0;
                    while($values = mysqli_fetch_assoc($result))
                    {
                      $yearly_total_savings += (int)$values['Total_Savings'];
                      $yearly_zabihat_savings += (int)$values['Remaining'];
                    ?>
                    <tr>
                    <td><?php echo $values['Months']; ?></td>
                    <td><?php echo $values['Hub_Received']; ?></td>
                    <td><?php echo $values['Amount_for_Jaman_to_SF']; ?></a></td>
                    <td><?php echo $values['Fixed_Cost']; ?></td>
                    <td class='success'><?php echo $values['Total_Savings']; ?></td>
                    <td><?php echo $values['Frm_MaulaTUS']; ?></td>
                    <td><?php echo $values['Frm_Students']; ?></td>
                    <td><?php echo $values['Used']; ?></td>
                    <td><?php echo $values['Remaining']; ?></td>
                    <td><a href="#" data-key="payhisab" data-month="<?php echo $values['Months']; ?>"><img src="images/add.png" style="width:20px;height:20px;"></a>&nbsp;
                        <a data-key="Monthview" data-month="<?php echo $values['Months']; ?>" data-toggle="modal" href="#sfbreakup-<?php echo $values['Months']; ?>"><img src="images/view.png" style="width:20px;height:20px;"></a></td>
                   
                  </tr>                 
                   <?php } ?>
                  <tr>
                    <td colspan='3'></td>
                    <td><strong>Cash In Hand</strong></td>
                    <td class='success'><strong><?php echo $yearly_total_savings; ?></strong></td>
                    <td colspan='2'></td>
                    <td><strong>Zabihat</strong></td>
                    <td><strong><?php echo $yearly_zabihat_savings; ?></strong></td>
                    <td colspan='1'></td>
                   
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
          url: '_payhisab.php',
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