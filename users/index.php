<?php

include('connection.php');
include('_authCheck.php');

$query="SELECT Thali, yearly_commitment, NAME, Dues, yearly_hub, CONTACT, Active, Transporter, Full_Address, Thali_start_date, Thali_stop_date, Total_Pending FROM thalilist where Email_id = '".$_SESSION['email']."'";

$values = mysqli_fetch_assoc(mysqli_query($link,$query));

$_SESSION['thali'] = $values['Thali'];
$_SESSION['address'] = $values['Full_Address'];
$_SESSION['name'] = $values['NAME'];
$_SESSION['contact'] = $values['CONTACT'];
$_SESSION['transporter'] = $values['Transporter'];

if(empty($values['Thali']))
{
  $some_email = $_SESSION['email'];
  session_unset();  
  session_destroy();

  $status = "Sorry! Either $some_email is not registered with us OR your thali is not active. Send and email to help@faizstudents.com";
  header("Location: login.php?status=$status");
}
else if($values['yearly_commitment'] == 1 && empty($values['yearly_hub']) && $values['Active'] == 1)
{
  header("Location: selectyearlyhub.php"); 
}
else if($values['yearly_commitment'] == 1 && !empty($values['yearly_hub']))
{
  $monthly_breakdown = (int)$values['Total_Pending']/8; 
}
?>
<!DOCTYPE html>

<!-- saved from url=(0029)http://bootswatch.com/flatly/ -->

<html lang="en">
    <head>
  <?php include('_head.php'); ?>
  </head>

  <body>

    <?php include('_nav.php'); ?>

    <div class="container">
        <br />
        <br />

        <div class="row">
          <div class="col-xs-6 col-sm-3 col-md-2">

              <?php
                  if($values['Active'] == 0)
                  {
              ?>

              <form method="POST" action="start_thali.php" onsubmit='return confirm("Are you sure?");' data-key="LazyLoad" class="hidden">
                <input type="submit" name="start_thali" value="Start Thaali"  class="btn btn-success"/>
                <input type="hidden" class="gregdate" name="start_date" value="<?php echo date("Y-m-d") ?>"/>
              </form>

              <?php
                    }
                    else
                    {
              ?>
       
              <form method="POST" action="stop_thali.php" onsubmit='return confirm("Are you sure?");' data-key="LazyLoad" class="hidden">
                <input type="submit" name="stop_thali" value="Stop Thaali"  class="btn btn-danger"/>
                <input type="hidden" class="gregdate" name="stop_date" value="<?php echo date("Y-m-d") ?>"/>
              </form>

              <?php } ?>

          </div>

          <div class="col-xs-6 col-sm-3 col-md-2">

              <?php
                  if($values['Transporter'] == 'Pick Up' && $values['Active'] == 1)
                  {
              ?>

              <form method="POST" action="start_transport.php" onsubmit='return confirm("Are you sure?");' data-key="LazyLoad" class="hidden">
                <input type="submit" name="start_transport" value="Request Transport"  class="btn btn-success"/>
                <input type="hidden" class="gregdate" name="start_date" value="<?php echo date("Y-m-d") ?>"/>
              </form>

              <?php
                }
                else if($values['Active'] == 1)
                {
              ?>

              <form method="POST" action="stop_transport.php" onsubmit='return confirm("Are you sure?");' data-key="LazyLoad" class="hidden">
                <input type="submit" name="stop_transport" value="Request Pickup"  class="btn btn-danger"/>
                <input type="hidden" class="gregdate" name="stop_date" value="<?php echo date("Y-m-d") ?>"/>
              </form>

              <?php
                }
              ?>
          </div>
        </div>

        <br />

        <div class="row">
            <div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
              <div class="panel panel-default">
                <div class="panel-heading" role="tab" id="headingOne">
                  <h4 class="panel-title">
                    <a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseOne" aria-expanded="false" aria-controls="collapseOne">
                      Thaali Details  <span class="text-muted" style="font-size: 12px; float: right;">(Click to Expand/Collapse)</span>
                    </a>
                  </h4>
                </div>
                <div id="collapseOne" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingOne">
                  <div class="panel-body">
                    <ul class="list-group col">
                      <li class="list-group-item">
                          <h6 class="list-group-item-head ing text-muted">Thaali Number</h6>
                          <p class="list-group-item-text"><strong><?php echo $values['Thali']; ?></strong></p>
                      </li>
                      <li class="list-group-item">
                          <h6 class="list-group-item-heading text-muted">Name</h6>
                          <p class="list-group-item-text"><strong><?php echo $values['NAME']; ?></strong></p>
                      </li>
                      <li class="list-group-item">
                          <h6 class="list-group-item-heading text-muted">Mobile Number</h6>
                          <p class="list-group-item-text"><strong><?php echo $values['CONTACT']; ?></strong></p>
                      </li>
                      <li class="list-group-item">
                          <h5 class="list-group-item-heading text-muted">Pending Hoob</h5>
                          <p class="list-group-item-text"><a href="hoobHistory.php"><strong><?php echo $values['Total_Pending']; ?></strong></a></p>
                      </li>
                      <li class="list-group-item">
                          <h6 class="list-group-item-heading text-muted">Is Active?</h6>
                          <p class="list-group-item-text"><strong><?php echo ($values['Active'] == '1') ? 'Yes' : 'No'; ?></strong></p>
                      </li>
                      <li class="list-group-item">
                          <h6 class="list-group-item-heading text-muted">Transporter</h6>
                          <p class="list-group-item-text"><?php echo $values['Transporter']; ?></p>
                      </li>
                      <li class="list-group-item">
                          <h6 class="list-group-item-heading text-muted">Address</h6>
                          <p class="list-group-item-text"><?php echo $values['Full_Address']; ?></p>
                      </li>

                      <?php
                        if($values['Active'] == 1)
                          {
                      ?>
                      <li class="list-group-item">
                          <h6 class="list-group-item-heading text-muted">Start Date</h6>
                          <p class="list-group-item-text hijridate"><?php echo $values['Thali_start_date']; ?></p>
                      </li>

                      <?php
                        }
                        else
                        {
                        ?>
                      <li class="list-group-item">
                          <h6 class="list-group-item-heading text-muted">Stop Date</h6>
                          <p class="list-group-item-text hijridate"><?php echo $values['Thali_stop_date']; ?></p>
                      </li>

                      <?php } ?>
                    </ul>  
                  </div>
                </div>
              </div>
              
              <!-- Break down -->
              <?php
                if(isset($monthly_breakdown)):
              ?>

                <div class="panel panel-default" style="margin-top: 20px;">
                  <div class="panel-heading" role="tab" id="headingTwo">
                    <h4 class="panel-title">
                      <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                        Hoob Breakdown  <span class="text-muted" style="font-size: 12px; float: right;">(Click to Expand/Collapse)</span>
                      </a>
                    </h4>
                  </div>
                  <div id="collapseTwo" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingTwo">
                    <div class="panel-body">
                      <h5 class="col-xs-12">The niyaaz amount will be payable throughout the year on the following 8 miqaats. You can either pay the whole amount in Lailat ul Qadr or pay it during the year.</h5>
                      <table class='table table-striped'>
                        <thead>
                          <tr>
                            <th>Date</th>
                            <th>Amount</th>
                          </tr>
                        </thead>
                        <tbody>
                          <tr>
                            <td>Lailatul Qadr (27th June 2016)</td>
                            <td><?php echo $monthly_breakdown; ?></td>
                          </tr>
                          <tr>
                            <td>Urs Syedi Abdulqadir Hakimuddin (AQ) (31st July 2016)</td>
                            <td><?php echo $monthly_breakdown; ?></td>
                          </tr>
                          <tr>
                            <td>Milad Of Syedna Taher Saifuddin (RA) (29th August 2016)</td>
                            <td><?php echo $monthly_breakdown; ?></td>
                          </tr>
                          <tr>
                            <td>Eid-e-Ghadeer-e-Khum (19th September 2016)</td>
                            <td><?php echo $monthly_breakdown; ?></td>
                          </tr>
                          <tr>
                            <td>Urs Syedna Hatim (RA) (17th October 2016)</td>
                            <td><?php echo $monthly_breakdown; ?></td>
                          </tr>
                          <tr>
                            <td>Chehlum Imam Husain (S.A) (20th November 2016)</td>
                            <td><?php echo $monthly_breakdown; ?></td>
                          </tr>
                          <tr>
                            <td>Milad Rasulullah (SAW) (11th December 2016)</td>
                            <td><?php echo $monthly_breakdown; ?></td>
                          </tr>
                          <tr>
                            <td>Milad Syedna Mohammed Burhanuddin (RA) (18th January 2017)</td>
                            <td><?php echo $monthly_breakdown; ?></td>
                          </tr>
                        </tbody>
                      </table>
                    </div>
                  </div>
                </div>

              <?php endif;?>
              <!-- Break down -->
            </div>
        </div>
    </div>

    <?php
      if(isset($_GET['status']))
      {
    ?>
        <script type="text/javascript">
            <?php
                if($_GET['status'] == 'Start Thali Successful') {
                    $message = $_GET['status'].'. '.'Your pending hoob : "'.$values['Total_Pending'].'"';
                } else {
                    $message = $_GET['status'];
                }
            ?>

            alert('<?php echo $message; ?>');
        </script>
    <?php } ?>

    <?php include('_bottomJS.php'); ?>

    <div align="center">
    <a href="mailto:help@faizstudents.com">help@faizstudents.com</a><br><br>
    </div>
  </body>
</html>