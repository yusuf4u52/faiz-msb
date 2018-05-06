<?php
include('_authCheck.php');
include('connection.php');

if ($_POST)
    {  
      $_POST['address'] = str_replace("'", "", $_POST['address']);
      mysqli_query($link,"UPDATE thalilist set 
                                      CONTACT='" . $_POST["contact"] . "',
                                      fathersNo='" . $_POST["fathercontact"] . "',
                                      fathersITS='" . $_POST["fatherits"] . "',
                                      Full_Address='" . $_POST["address"] . "',
                                      WATAN='" . $_POST["watan"] . "',
                                      ITS_No='" . $_POST["its"] . "',
                                      markaz='".$_POST["markaz"]."',
                                      WhatsApp='" . $_POST["whatsapp"] . "'
                                      WHERE Email_id = '".$_SESSION['email']."'") or die(mysqli_error($link));
                          
if ($_POST['address'] != $_SESSION['old_address'])
{
mysqli_query($link,"UPDATE thalilist set Transporter='Transporter' where Email_id = '".$_SESSION['email']."'");
mysqli_query($link,"update change_table set processed = 1 where Thali = '" . $_SESSION['thali'] . "' and `Operation` in ('Update Thali') and processed = 0") or die(mysqli_error($link));
mysqli_query($link,"INSERT INTO change_table (`Thali`, `Operation`, `Date`) VALUES ('" . $_SESSION['thali'] . "', 'Update Address','" . $_POST['date1'] . "')") or die(mysqli_error($link));
}

        unset($_SESSION['old_address']);                 
        header('Location: index.php');       
    }
    else
    {
    	$query="SELECT * FROM thalilist where Email_id = '".$_SESSION['email']."'";

 
     $data = mysqli_fetch_assoc(mysqli_query($link,$query));

     // print_r($data); exit;

     extract($data);
     $_SESSION['old_address'] = $Full_Address;
    }

?>
<!DOCTYPE html>

<!-- saved from url=(0029)http://bootswatch.com/flatly/ -->

<html lang="en">
  <head>
  <?php include('_head.php'); ?>
  <?php include('_bottomJS.php'); ?>
  </head>

  <body>

      <?php include('_nav.php'); ?>
    <div class="container">

      <!-- Forms

      ================================================== -->

        <div class="row">

          <div class="col-lg-12">

            <div class="page-header">

              <h2 id="forms">Update info</h2>
              <h4 id="forms">Make Sure you fill out all the required field to get to the Home Page</h4>

            </div>

          </div>



        <div class="row">

          <div class="col-lg-6">

            <div class="well bs-component">

              <form class="form-horizontal" method="post">

                <fieldset>


                   <div class="form-group">

                    <label for="inputName" class="col-lg-2 control-label">Name</label>

                    <div class="col-lg-10">

                      <input type="text" class="form-control" id="inputName" placeholder="Name" required='required'  name="name" value='<?php echo $NAME;?>' disabled>

                    </div>

                  </div>

                   <div class="form-group">

                    <label for="inputIts" class="col-lg-2 control-label">ITS Id</label>

                    <div class="col-lg-10">

                      <input type="text" pattern="[0-9]{8}" class="form-control" id="inputIts" placeholder="its" required='required'  name="its" value='<?php echo $ITS_No;?>' title="Enter correct ITS ID">

                    </div>

                  </div>

                  <div class="form-group">

                    <label for="inputWatan" class="col-lg-2 control-label">Watan</label>

                    <div class="col-lg-10">

                      <input type="text" class="form-control" id="inputWatan" placeholder="watan" name="watan" value='<?php echo $WATAN;?>' disabled>

                    </div>

                  </div>

                  <div class="form-group">
                    <label for="inputContact" class="col-lg-2 control-label">Mobile No.</label>
                    <div class="col-lg-10">
                      <input type="text" pattern="[0-9]{10}" class="form-control" id="inputContact" placeholder="Contact" required='required' name="contact" value='<?php echo $CONTACT;?>' title="Enter 10 digits">
                      <input type="hidden" class="gregdate" name="date1" value="<?php echo date("Y-m-d") ?>"/>
                    </div>
                  </div>
                  <div class="form-group">
                    <label for="inputContact" class="col-lg-2 control-label">Fathers ITS</label>
                    <div class="col-lg-10">
                      <input type="text" class="form-control" id="inputContact" required='required' name="fatherits" value='<?php echo $fathersITS;?>'>
                    </div>
                  </div>
                  <div class="form-group">
                    <label for="inputContact" class="col-lg-2 control-label">Fathers No.</label>
                    <div class="col-lg-10">
                      <input type="text" class="form-control" id="inputContact" required='required' name="fathercontact" value='<?php echo $fathersNo;?>'>
                    </div>
                  </div>

                  <div class="form-group">

                    <label for="inputwhatsapp" class="col-lg-2 control-label">WhatsApp No.</label>

                    <div class="col-lg-10">

                      <input type="text" class="form-control" id="inputwhatsapp" placeholder="WhatsApp" required='required' name="whatsapp" value='<?php echo $WhatsApp;?>'>

                    </div>

                  </div>

                  <div class="form-group">
                    <label for="inputwhatsapp" class="col-lg-2 control-label">Ramadan Markaz</label>
                    <div class="col-lg-10">
                      <select class="form-control" id="markaz" name="markaz" required>
                        <option disabled selected value> -- select an option -- </option>
                        <option value="Shabbir Society">Shabbir Society</option>
                        <option value="Husainy Baug">Husainy Baug</option>
                        <option value="Bharmal">Bharmal</option>
                        <option value="City">City</option>
                        <option value="Fakhri Hills">Fakhri Hills</option>
                        <option value="Fatima Nagar">Fatima Nagar</option>
                        <option value="Saif Society">Saif Society</option>
                        <option value="Burhani Colony">Burhani Colony</option>
                        <option value="Mitha Nagar">Mitha Nagar</option>
                        <option value="Salunke Vihar">Salunke Vihar</option>
                        <option value="Kalimi Masjid">Kalimi Masjid</option>
                        <option value="Undri">Undri</option>
                        <option value="(not present in the list)">(not present in the list)</option>
                      </select>
                    </div>
                  </div>

                  <div class="form-group">

                    <label for="inputAddress" class="col-lg-2 control-label">Address</label>

                    <div class="col-lg-10">
                      <textarea class="form-control" id="inputAddress" name="address"><?php echo $Full_Address;?></textarea>

                    </div>

                  </div>


                  <div class="form-group">

                    <div class="col-lg-10 col-lg-offset-2">

                      <button type="submit" class="btn btn-primary" name='submit'>Submit</button>

                    </div>

                  </div>

                </fieldset>

              </form>

            </div>

          </div>
         
        </div>

      </div>

    </div>

<!-- Modal -->
<div id="myModal" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Update info</h4>
      </div>
      <div class="modal-body">
        <p>Make Sure you fill out all the required field to get to the Home Page</p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>

  </div>
</div>
<!-- Message model ends-->
<?php if(isset($_GET['update_pending_info'])) {?>
  <script type="text/javascript">
    $('#myModal').modal('show');
  </script>
<?php } ?>
  </body>
</html>