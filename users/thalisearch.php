<?php
include('connection.php');
include('adminsession.php');

if($_GET)
{
    $query="SELECT Thali, NAME, CONTACT, Active, Transporter, Full_Address, Thali_start_date, Thali_stop_date, (Previous_Due + Dues + yearly_hub + Zabihat + Reg_Fee + TranspFee - Paid) AS Total_Pending FROM thalilist";

    if(!empty($_GET['thalino']))
    {
      $query.= " WHERE Thali = '".addslashes($_GET['thalino'])."'";
    }
    else if(!empty($_GET['general']))
    {
      $query.= " WHERE 
                Email_ID LIKE '%".addslashes($_GET['general'])."%'
                or NAME LIKE '%".addslashes($_GET['general'])."%'
                or CONTACT LIKE '%".addslashes($_GET['general'])."%'
                or ITS_No LIKE '%".addslashes($_GET['general'])."%'
                ";
    }

    $result = mysqli_query($link,$query);

    
}
    
?>
<!DOCTYPE html>

<!-- saved from url=(0029)http://bootswatch.com/flatly/ -->

<html lang="en">
  <head><?php include('_head.php'); ?></head>
  <body>
    <?php include('_nav.php'); ?>
    <div class="container">

      <!-- Forms

      ================================================== -->

        <div class="row">

          <div class="col-lg-12">

            <div class="page-header">

              <h2 id="forms">Thali Search</h2>

            </div>

          </div>



        <div class="row">

          <div class="col-lg-6">

            <div class="well bs-component">

              <form class="form-horizontal">

                <fieldset>


                   <div class="form-group">

                    <label for="inputThalino" class="col-lg-2 control-label">Thali No</label>

                    <div class="col-lg-10">

                      <input type="text" class="form-control" id="inputThalino" placeholder="Thali No"  name="thalino">

                    </div>

                  </div>

                  <div class="form-group">

                    <label for="inputGeneral" class="col-lg-2 control-label">Contact/ ITS no / Email / Name</label>

                    <div class="col-lg-10">

                      <input type="text" class="form-control" id="inputGeneral" placeholder="Contact/ ITS no / Email / Name" name="general">

                    </div>

                  </div>



                  <div class="form-group">

                    <div class="col-lg-10 col-lg-offset-2">

                      <button type="submit" class="btn btn-primary">Submit</button>

                    </div>

                  </div>

                </fieldset>

              </form>

            </div>

          </div>
          <?php
            if($_GET):
              ?>
           <div class="col-lg-12">



          <div class="col-lg-12">

            <div class="page-header">

              <h2 id="tables">Thali Info</h2>

            </div>

            <div class="bs-component">

            <?php 
            $sql = mysqli_query($link,"SELECT MAX(`Receipt_No`) from receipts");
            $row = mysqli_fetch_row($sql);
            $plusone = $row[0] + 1;
            ?> 

      <div id="receiptForm">
        <input type="number" name="receipt_number" value="<?php echo $plusone ?>"/>
        <input type="number" name="zabihat" value="0"/>
        <input type="number" name="receipt_amount" placeholder="Receipt Amount"/>
        <input type="hidden" class="gregdate" name="receipt_date" value="<?php echo date("Y-m-d") ?>"/>
        <input type="hidden" name="receipt_thali"/>
        <input type="button" name="cancel" value="cancel" />
        <input type="button" name="save" value="save"/>
      </div>
             <?php 
             if(mysqli_num_rows($result) > 1)
                include('_thalisearch_multiple.php');
              else if(mysqli_num_rows($result) == 1)
                include('_thalisearch_single.php');
              else
                echo "No records found";
             ?>
              
            </div>
          </div>
          </div>
<?php endif; ?>
        </div>

      </div>

    </div>
  <?php include('_bottomJS.php'); ?>
  <script>
    $(function(){
      var receiptForm = $('#receiptForm');
      receiptForm.hide();
      $('[data-key="payhoob"]').click(function() {
        $('[name="receipt_thali"]', receiptForm).val($(this).attr('data-thali'));
        receiptForm.show();
      });
      $('[name="save"]').click(function() {
        var data = '';
        $('input[type!="button"]', receiptForm).each(function() {
          data = data + $(this).attr('name') + '=' + $(this).val() + '&';
        });
        $.ajax({
          method: 'post',
          url: '_payhoob.php',
          async: 'false',
          data: data,
          success: function(data) {
            if(data == 'success') {
              alert('Hoob sucessfully updated.');
              receiptForm.hide();
              location.reload();
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
        receiptForm.hide();
      });


      $('[data-key="stopthaali"]').click(function() {
        stopThali_admin($(this).attr('data-thali'), $('[name="receipt_date"]').val(), $(this).attr('data-active'),false,false, function(data){
          if(data==='success') {
            location.reload();
          }
        });
      });

      $('[data-key="stoppermanant"]').click(function() {
        $.post("stop_permanant.php",
        {
          Thaliid: $(this).data("thali"),
          date: $('[name="receipt_date"]').val()
        },
        function(data,status){
            alert("Thali Stopped Successfully and Number released to be re-used");
            location.reload();
        });
      });

      <?php if($_GET): ?>
        window.location = '#tables';
      <?php endif; ?>
    });
  </script>

</body></html>