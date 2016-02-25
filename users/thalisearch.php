<?php
include('connection.php');
include('adminsession.php');

if($_GET)
{
    $query="SELECT Thali, NAME, CONTACT, Active, Transporter, Full_Address, Thali_start_date, Thali_stop_date, Total_Pending FROM thalilist";

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
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />

        <meta charset="utf-8" />

        <title>Faiz ul Mawaid il Burhaniyah (Poona Students)</title>

        <meta name="viewport" content="width=device-width, initial-scale=1" />

        <meta http-equiv="X-UA-Compatible" content="IE=edge" />

        <link rel="stylesheet" href="./src/bootstrap.css" media="screen" />

        <link rel="stylesheet" href="./src/custom.min.css" />

        <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->

        <!--[if lt IE 9]>

        <script src="javascript/html5shiv-3.7.0.min.js"></script>

        <script src="javascript/respond-1.4.2.min.js"></script>

        <![endif]-->
    </head>

  <body>

  <nav class="navbar navbar-default">
      <div class="container-fluid">
          <div class="navbar-header">
              <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                  <span class="sr-only">Toggle navigation</span>
                  <span class="icon-bar"></span>
                  <span class="icon-bar"></span>
                  <span class="icon-bar"></span>
              </button>
              <a class="navbar-brand font-bold" href="/users/">FMB (Poona Students)</a>
          </div>

          <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
              <ul class="nav navbar-nav navbar-right">
                  <li><a href="logout.php">Logout</a></li>
              </ul>
          </div>
      </div>
  </nav>

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
              <table class="table table-striped table-hover ">

                <thead>

                  <tr>
                    <th>Pay Hoob</th>
                    <th>Stop Thaali</th>
                    <th>Thali No</th>
                    <th>Name</th>
                    <th>Mobile No</th>
                    <th>Active</th>
                    <th>Transporter</th>
                    <th>Address</th>
                    <th>Start Date</th>
                    <th>Stop Date</th>
                    <th>Hub pending</th>
                  </tr>
                </thead>

                <tbody>
                  <?php
                    while($values = mysqli_fetch_assoc($result))
                    {
                  ?>
                  <tr>
                    <td><a href="#" data-key="payhoob" data-thali="<?php echo $values['Thali']; ?>">Pay Hoob</a></td>
                    <td><?php if($values['Active'] == '1'): ?><a href="#" data-key="stopthaali" data-thali="<?php echo $values['Thali']; ?>">Stop Thaali</a><?php endif;?></td>
                    <td><?php echo $values['Thali']; ?></td>
                    <td><?php echo $values['NAME']; ?></td>
                    <td><?php echo $values['CONTACT']; ?></td>
                    <td><?php echo ($values['Active'] == '1') ? 'Yes' : 'No'; ?></td>
                    <td><?php echo $values['Transporter']; ?></td>
                    <td><?php echo $values['Full_Address']; ?></td>
                    <td class="hijridate"><?php echo $values['Thali_start_date']; ?></td>
                    <td class="hijridate"><?php echo $values['Thali_stop_date']; ?></td>
                    <td><?php echo $values['Total_Pending']; ?></td>
                  </tr>
                  <?php } ?>
                </tbody>
              </table> 
            </div>
          </div>
          </div>
<?php endif; ?>
        </div>

      </div>

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
        receiptForm.hide();
      });


      $('[data-key="stopthaali"]').click(function() {
        stopThali_admin($(this).attr('data-thali'), $('[name="receipt_date"]').val(), function(data){
          if(data==='success') {
            window.location.href = window.location.href;
          }
        });
      });
    });
  </script>

</body></html>