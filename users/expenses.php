<?php
include('connection.php');
// include('adminsession.php');


error_reporting(0);

    $mh_hub = mysqli_fetch_row(mysqli_query($link,"SELECT SUM(Paid) FROM thalilist_Moharram"));
    mysqli_query($link, "UPDATE hisab set Hub_Received = '".$mh_hub[0]."' WHERE Months = 'Moharram'");
    $mh_zabihat = mysqli_fetch_row(mysqli_query($link,"SELECT SUM(Zabihat) FROM thalilist_Moharram"));
    mysqli_query($link, "UPDATE hisab set Frm_Students = '".$mh_zabihat[0]."'  WHERE Months = 'Moharram'");

    $sf_hub = mysqli_fetch_row(mysqli_query($link,"SELECT SUM(Paid) FROM thalilist_Safar"));
    mysqli_query($link, "UPDATE hisab set Hub_Received = '".$sf_hub[0]."' WHERE Months = 'Safar'");
    $sf_zabihat = mysqli_fetch_row(mysqli_query($link,"SELECT SUM(Zabihat) FROM thalilist_Safar"));
    mysqli_query($link, "UPDATE hisab set Frm_Students = '".$sf_zabihat[0]."' WHERE Months = 'Safar'"); 

    $ra1_hub = mysqli_fetch_row(mysqli_query($link,"SELECT SUM(Paid) FROM thalilist_RabiulAwwal"));
    mysqli_query($link, "UPDATE hisab set Hub_Received = '".$ra1_hub[0]."' WHERE Months = 'RabiulAwwal'");
    $ra1_zabihat = mysqli_fetch_row(mysqli_query($link,"SELECT SUM(Zabihat) FROM thalilist_RabiulAwwal"));
    mysqli_query($link, "UPDATE hisab set Frm_Students = '".$ra1_zabihat[0]."' WHERE Months = 'RabiulAwwal'");

    $ra2_hub = mysqli_fetch_row(mysqli_query($link,"SELECT SUM(Paid) FROM thalilist_RabiulAkhar"));
    mysqli_query($link, "UPDATE hisab set Hub_Received = '".$ra2_hub[0]."' WHERE Months = 'RabiulAkhar'");
    $ra2_zabihat = mysqli_fetch_row(mysqli_query($link,"SELECT SUM(Zabihat) FROM thalilist_RabiulAkhar"));
    mysqli_query($link, "UPDATE hisab set Frm_Students = '".$ra2_zabihat[0]."' WHERE Months = 'RabiulAkhar'");

    $ja1_hub = mysqli_fetch_row(mysqli_query($link,"SELECT SUM(Paid) FROM thalilist_JamadalAwwal"));
    mysqli_query($link, "UPDATE hisab set Hub_Received = '".$ja1_hub[0]."' WHERE Months = 'JamadalAwwal'");
    $ja1_zabihat = mysqli_fetch_row(mysqli_query($link,"SELECT SUM(Zabihat) FROM thalilist_JamadalAwwal"));
    mysqli_query($link, "UPDATE hisab set Frm_Students = '".$ja1_zabihat[0]."' WHERE Months = 'JamadalAwwal'");

    $ja2_hub = mysqli_fetch_row(mysqli_query($link,"SELECT SUM(Paid) FROM thalilist_JamadalAkhar"));
    mysqli_query($link, "UPDATE hisab set Hub_Received = '".$ja2_hub[0]."' WHERE Months = 'JamadalAkhar'");
    $ja2_zabihat = mysqli_fetch_row(mysqli_query($link,"SELECT SUM(Zabihat) FROM thalilist_JamadalAkhar"));
    mysqli_query($link, "UPDATE hisab set Frm_Students = '".$ja2_zabihat[0]."' WHERE Months = 'JamadalAkhar'");

    $rjb_hub = mysqli_fetch_row(mysqli_query($link,"SELECT SUM(Paid) FROM thalilist_Rajab"));
    mysqli_query($link, "UPDATE hisab set Hub_Received = '".$rjb_hub[0]."' WHERE Months = 'Rajab'");
    $rjb_zabihat = mysqli_fetch_row(mysqli_query($link,"SELECT SUM(Zabihat) FROM thalilist_Rajab"));
    mysqli_query($link, "UPDATE hisab set Frm_Students = '".$rjb_zabihat[0]."' WHERE Months = 'Rajab'");   

    $shb_hub = mysqli_fetch_row(mysqli_query($link,"SELECT SUM(Paid) FROM thalilist_Shaban"));
    mysqli_query($link, "UPDATE hisab set Hub_Received = '".$shb_hub[0]."' WHERE Months = 'Shaban'");
    $shb_zabihat = mysqli_fetch_row(mysqli_query($link,"SELECT SUM(Zabihat) FROM thalilist_Shaban"));
    mysqli_query($link, "UPDATE hisab set Frm_Students = '".$shb_zabihat[0]."' WHERE Months = 'Shaban'");

    $rmz_hub = mysqli_fetch_row(mysqli_query($link,"SELECT SUM(Paid) FROM thalilist_Ramazan"));
    mysqli_query($link, "UPDATE hisab set Hub_Received = '".$rmz_hub[0]."' WHERE Months = 'Ramazan'");
    $rmz_zabihat = mysqli_fetch_row(mysqli_query($link,"SELECT SUM(Zabihat) FROM thalilist_Ramazan"));
    mysqli_query($link, "UPDATE hisab set Frm_Students = '".$rmz_zabihat[0]."' WHERE Months = 'Ramazan'");

    $shw_hub = mysqli_fetch_row(mysqli_query($link,"SELECT SUM(Paid) FROM thalilist_Shawwal"));
    mysqli_query($link, "UPDATE hisab set Hub_Received = '".$shw_hub[0]."' WHERE Months = 'Shawwal'");
    $shw_zabihat = mysqli_fetch_row(mysqli_query($link,"SELECT SUM(Zabihat) FROM thalilist_Shawwal"));
    mysqli_query($link, "UPDATE hisab set Frm_Students = '".$shw_zabihat[0]."' WHERE Months = 'Shawwal'");

    $zq_hub = mysqli_fetch_row(mysqli_query($link,"SELECT SUM(Paid) FROM thalilist_Zilqad"));
    mysqli_query($link, "UPDATE hisab set Hub_Received = '".$zq_hub[0]."' WHERE Months = 'Zilqad'");
    $zq_zabihat = mysqli_fetch_row(mysqli_query($link,"SELECT SUM(Zabihat) FROM thalilist_Zilqad"));
    mysqli_query($link, "UPDATE hisab set Frm_Students = '".$zq_zabihat[0]."' WHERE Months = 'Zilqad'");

    $zh_hub = mysqli_fetch_row(mysqli_query($link,"SELECT SUM(Paid) FROM thalilist_Zilhaj"));
    mysqli_query($link, "UPDATE hisab set Hub_Received = '".$zh_hub[0]."' WHERE Months = 'Zilhaj'");
    $zh_zabihat = mysqli_fetch_row(mysqli_query($link,"SELECT SUM(Zabihat) FROM thalilist_Zilhaj"));
    mysqli_query($link, "UPDATE hisab set Frm_Students = '".$zh_zabihat[0]."' WHERE Months = 'Zilhaj'");

    $result = mysqli_query($link,"select * from hisab");


    $sf_breakup = mysqli_query($link, "SELECT * FROM account") or die(mysqli_error($link));

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
        <h4 class="modal-title">Enter the amount given to SF</h4>
      </div>
      <div class="modal-body">
        <div id="hisabform">
        <input type="number" name="Amount" placeholder="Amount to SF"/>
        <input type="text" class="gregdate" name="sf_amount_date" value="<?php echo date("Y-m-d") ?>"/>
        <input type="hidden" name="Month"/>
      </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal" name="cancel">Close</button>
        <button type="button" class="btn btn-primary" name="save">Save changes</button>
      </div>
    </div>
  </div>
</div>


<div class="modal" id="sfbreakup">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">Amount given to SF</h4>
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
     <div class="container">
<table class="table table-striped table-hover table-responsive">

                <thead>

                  <tr>
                    <th>Months</th>
                    <th>Hub Received</th>
                    <th>Amount Given</th>
                    <th>Fixed Cost</th>
                    <th>Total Savings</th>
                    <th>Zabihat Maula(TUS)</th>
                    <th>Zabihat Students</th>
                    <th>Used</th>
                    <th>Remaining</th>
                  </tr>
                </thead>

                <tbody>

                    <?php
                    while($values = mysqli_fetch_assoc($result))
                    {
                    ?>
                    <tr>
                    <td><?php echo $values['Months']; ?></td>
                    <td><?php echo $values['Hub_Received']; ?></td>
                    <td><a data-toggle="modal" href="#sfbreakup"><?php echo $values['Amount_for_Jaman_to_SF']; ?></a>&nbsp;<a href="#" data-key="payhisab" data-month="<?php echo $values['Months']; ?>"><img src="images/add.png" style="width:20px;height:20px;"></a></td>
                    <td><?php echo $values['Fixed_Cost']; ?></td>
                    <td><?php echo $values['Total_Savings']; ?></td>
                    <td><?php echo $values['Frm_MaulaTUS']; ?></td>
                    <td><?php echo $values['Frm_Students']; ?></td>
                    <td><?php echo $values['Used']; ?></td>
                    <td><?php echo $values['Remaining']; ?></td>
                  </tr>                 
                   <?php } ?>
              
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
        $('input[type!="button"]', hisabform).each(function() {
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