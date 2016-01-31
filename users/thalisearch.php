<?php
include('connection.php');
include('adminsession.php');

if($_POST)
{
    $query="SELECT Thali, NAME, CONTACT, Active, Transporter, Full_Address, Thali_start_date, Thali_stop_date, Total_Pending FROM thalilist";

    if(!empty($_POST['thalino']))
    {
      $query.= " WHERE Thali = '".addslashes($_POST['thalino'])."'";
    }
    else if(!empty($_POST['mobile']))
    {
      $query.= " WHERE CONTACT = '".addslashes($_POST['mobile'])."'";
    }
    else if(!empty($_POST['its']))
    {
      $query.= " WHERE ITS_No = '".addslashes($_POST['its'])."'";
    }
    else if(!empty($_POST['general']))
    {
      $query.= " WHERE Email_ID LIKE '%".addslashes($_POST['general'])."%' or NAME LIKE '%".addslashes($_POST['general'])."%'";
    }

    $result = mysqli_query($link,$query);
    
}
    
?>
<!DOCTYPE html>

<!-- saved from url=(0029)http://bootswatch.com/flatly/ -->

<html lang="en"><head><meta http-equiv="Content-Type" content="text/html; charset=UTF-8">

    <meta charset="utf-8">

    <title>Faiz ul Mawaid il Burhaniyah (Poona Students)</title>

    <meta name="viewport" content="width=device-width, initial-scale=1">

    <meta http-equiv="X-UA-Compatible" content="IE=edge">

    <link rel="stylesheet" href="./src/bootstrap.css" media="screen">

    <link rel="stylesheet" href="./src/custom.min.css">
    <link href="//cdnjs.cloudflare.com/ajax/libs/bootstrap-modal/2.2.6/css/bootstrap-modal.min.css"/>



    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->

    <!--[if lt IE 9]>

      <script src="../bower_components/html5shiv/dist/html5shiv.js"></script>

      <script src="../bower_components/respond/dest/respond.min.js"></script>

    <![endif]-->

  </head>

  <body>

    <div class="navbar navbar-default navbar-fixed-top">

      <div class="container">

        <div class="navbar-header">

          <a class="navbar-brand">Faiz Students</a>

        </div>

        <ul class="nav navbar-nav navbar-right">
            <li><a href="index.php">Home</a></li>
            <li><a href="logout.php">Logout</a></li>
          </ul>

      </div>

    </div>
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

              <form class="form-horizontal" method="post">

                <fieldset>


                   <div class="form-group">

                    <label for="inputThalino" class="col-lg-2 control-label">Thali No</label>

                    <div class="col-lg-10">

                      <input type="text" class="form-control" id="inputThalino" placeholder="Thali No"  name="thalino">

                    </div>

                  </div>

                  <div class="form-group">

                    <label for="inputIts" class="col-lg-2 control-label">Its No</label>

                    <div class="col-lg-10">

                      <input type="text" class="form-control" id="inputIts" placeholder="Its No" name="its">

                    </div>

                  </div>



                  <div class="form-group">

                    <label for="inputMobile" class="col-lg-2 control-label">Mobile No</label>

                    <div class="col-lg-10">

                      <input type="text" class="form-control" id="inputMobile" placeholder="Mobile No"   name="mobile">

                    </div>

                  </div>



                  <div class="form-group">

                    <label for="inputGeneral" class="col-lg-2 control-label">Email / Name</label>

                    <div class="col-lg-10">

                      <input type="text" class="form-control" id="inputGeneral" placeholder="Email / Name"    name="general">

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
            if($_POST):
              ?>
           <div class="col-lg-12">



          <div class="col-lg-12">

            <div class="page-header">

              <h2 id="tables">Thali Info</h2>

            </div>

            <div class="bs-component">

      <div id="receiptForm">
        <input type="number" name="receipt_number" placeholder="Receipt #"/>
        <input type="number" name="receipt_amount" placeholder="Receipt Amount"/>
        <input type="hidden" class='gregdate' name="receipt_date" value="<?php echo date("Y-m-d") ?>"/>
        <input type="hidden" name="receipt_thali"/>
        <input type="button" name="cancel" value="cancel" />
        <input type="button" name="save" value="save"/>
      </div>
              <table class="table table-striped table-hover ">

                <thead>

                  <tr>
                    <th>Pay Hoob</th>
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
                    <td><?php echo $values['Thali']; ?></td>
                    <td><?php echo $values['NAME']; ?></td>
                    <td><?php echo $values['CONTACT']; ?></td>
                    <td><?php echo ($values['Active'] == '1') ? 'Yes' : 'No'; ?></td>
                    <td><?php echo $values['Transporter']; ?></td>
                    <td><?php echo $values['Full_Address']; ?></td>
                    <td><?php echo $values['Thali_start_date']; ?></td>
                    <td><?php echo $values['Thali_stop_date']; ?></td>
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

    <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
    <script src="./src/bootstrap.min.js"></script>

    <script src="./src/custom.js"></script>
    <script type="//cdnjs.cloudflare.com/ajax/libs/bootstrap-modal/2.2.6/js/bootstrap-modal.min.js"></script>
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
        alert('Oops! Something went wrong.');
      }
    });
  });

  $('[name="cancel"]').click(function() {
    receiptForm.hide();
  });
});
</script>

</body></html>