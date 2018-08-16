<?php
error_reporting(0);
include('_authCheck.php');
include('connection.php');

function getMiqaats($start_date)
{
    $_miqaats = array(
                    '2017-06-16' => 'Lailatul Qadr (16th June 2017)',
                    '2017-07-21' => 'Urs Syedi Abdulqadir Hakimuddin (AQ) (21st July 2017)',
                    '2017-08-19' => 'Milad Of Syedna Taher Saifuddin (RA) (19th August 2017)',
                    '2017-09-09' => 'Eid-e-Ghadeer-e-Khum (9th September 2017)',
                    '2017-10-06' => 'Urs Syedna Hatim (RA) (6th October 2017)',
                    '2017-11-09' => 'Chehlum Imam Husain (S.A) (9th November 2017)',
                    '2017-11-30' => 'Milad Rasulullah (SAW) (30th November 2017)',
                    '2018-01-07' => 'Milad Syedna Mohammed Burhanuddin (RA) (7th January 2018)',
                    '2018-02-01' => '16 Jumadil Awwal (1st February 2018)',
                    '2018-03-03' => '16 Jumadil Akhar (3rd March 2018)',
                    '2018-04-01' => '16 Rajab (1st April 2018)',
                    '2018-05-01' => '16 Shabaan (1st May 2018)'
                    );
    $return_array = array();
    $i = 0;
    foreach ($_miqaats as $date => $value) {
      if($start_date <=  $date && $i < 8)
      {
         $return_array[$date] = $value;
         $i++;
      }
    }
    return $return_array;
}

$query="SELECT * FROM thalilist LEFT JOIN transporters on thalilist.Transporter = transporters.Name where Email_id = '".$_SESSION['email']."'";

$values = mysqli_fetch_assoc(mysqli_query($link,$query));

$_SESSION['thaliid'] = $values['id'];
$_SESSION['thali'] = $values['Thali'];

// Redirect users to update details page
if (empty($values['ITS_No']) || empty($values['fathersNo']) || empty($values['fathersITS']) || empty($values['CONTACT']) || empty($values['WhatsApp']) || empty($values['Full_Address'])) { 
    header("Location: update_details.php?update_pending_info"); 
}

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
  $reciepts_query_result_total = mysqli_fetch_assoc(mysqli_query($link,"SELECT sum(`Amount`) as total FROM `receipts` where Thali_No = '".$_SESSION['thali']."'"));
  $total_amount_paid = $reciepts_query_result_total['total'];
  $thaliactivedate_query = mysqli_fetch_assoc(mysqli_query($link,"SELECT DATE(datetime) as datetime FROM `change_table` where Thali = '".$_SESSION['thali']."' AND operation = 'Start Thali' AND id > 3596 ORDER BY id limit 1"));
  $thaliactivedate = $thaliactivedate_query['datetime'];
  //$_miqaats = getMiqaats($thaliactivedate);

  $sql = mysqli_query($link,"select miqat_date,miqat_description from sms_date");

  while($record = mysqli_fetch_assoc($sql))
    {
      $_miqaats[$record['miqat_date']] = $record['miqat_description'];
    } 


  $values['Total_Pending'] = $values['Previous_Due'] + $values['Dues'] + $values['yearly_hub'] + $values['Zabihat'] + $values['Reg_Fee'] + $values['TranspFee'] - $values['Paid'];
  
  $installment = (int)($values['Total_Pending'] + $values['Paid'])/count($_miqaats);
  $todays_date = date("Y-m-d");
  $miqaat_gone = 0;
  
  $miqaats = array();
  $miqaats_past = array();
  foreach ($_miqaats as $mdate => $miqaat) {
    
    if($mdate < $todays_date)
    {
      $miqaats_past[$mdate] = $miqaat;
    }
    else
    {

      $month_installment = $installment;
      $miqaats[] = array(
                        $mdate,$miqaat,ceil($month_installment)
                        );
    }
  }

 
 $hub_baki = ((count($miqaats_past) - $miqaat_gone) * $installment) - $total_amount_paid;

 $miqaats[0][2] += $hub_baki;

 if ($miqaats[0][2] > 0) {
 $miqaats[0][2] = round($miqaats[0][2],-2);
 }
 $next_install = $miqaats[0][2];
 mysqli_query($link,"UPDATE thalilist set next_install ='$next_install' WHERE Email_id = '".$_SESSION['email']."'") or die(mysqli_error($link));
 mysqli_query($link,"UPDATE thalilist set prev_install_pending ='$hub_baki' WHERE Email_id = '".$_SESSION['email']."'") or die(mysqli_error($link));
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
                if(($values['Previous_Due'] - $values['Paid'])  <= 3000) {
                  if($values['Active'] == 0)
                  {
                    if($values['hardstop'] == 1)
                    {
                      ?>
                <input type="button" onclick="alert('<?php echo "You are not allowed to start your thali: ".$values['hardstop_comment'] ?>')" name="start_thali" value="Start Thaali"  class="btn btn-success"/>
               <?php

                    }
                    else
                    {
              ?>

              <form method="POST" action="start_thali.php" onsubmit='return confirm("Are you sure?");' data-key="LazyLoad" class="hidden">
                <input type="submit" name="start_thali" value="Start Thaali"  class="btn btn-success"/>
                <input type="hidden" class="gregdate" name="start_date" value="<?php echo date("Y-m-d") ?>"/>
              </form>

              <?php
                    }
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
                }} else {
              ?>
               <script type="text/javascript">
                  alert('You have pending hub of <?php echo $values['Previous_Due']; ?> and so will not see Start thali button. Contact us at help@faizstudents.com');
               </script>
              <?php }
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
                          <p class="list-group-item-text">
                          <?php 
                              echo "".$values['Transporter']." | ".$values['Mobile']."" ;
                          ?>
                          </p>
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
                          <p class="list-group-item-text hijridate"><?php echo $values['Thali_Start_Date']; ?></p>
                      </li>

                      <?php
                        }
                        else
                        {
                        ?>
                      <li class="list-group-item">
                          <h6 class="list-group-item-heading text-muted">Stop Date</h6>
                          <p class="list-group-item-text hijridate"><?php echo $values['Thali_Stop_Date']; ?></p>
                      </li>

                      <?php } ?>
                    </ul>  
                  </div>
                </div>
              </div>
              
              <!-- Break down -->
              <?php
                if(isset($installment)):
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
                      <h5 class="col-xs-12">The niyaaz amount will be payable throughout the year on the following 3 miqaats. If possible do contribute the whole amount in Lailat ul Qadr</h5>
                      <table class='table table-striped'>
                        <thead>
                          <tr>
                            <th>Date</th>
                            <th>Amount</th>
                            <th>Extension</th>
                          </tr>
                        </thead>
                        <tbody>
                          <?php foreach ($miqaats_past as $miqaat) {
                          ?>
                          <tr>
                            <td><?php echo $miqaat; ?></td>
                            <td>--</td>
                            <td>--</td>
                          </tr>
                         <?php } ?>

                          <?php
                          $i = true;
                          foreach ($miqaats as $miqaat) {
                          ?>
                          <tr>
                            <td><?php echo $miqaat[1];

                            if($values['extension_miqaat'] == $miqaat[0])
                            {
                                echo '<a style="color:red">(Extended to :'.date('d M Y',strtotime($values['next_extension_date'])).')<a>';
                            }

                            ?></td>

                            <?php if ($miqaat[2] < 0) { ?>
                            <td>0</td>
                            <?php }else{ ?>
                            <td><?php echo $miqaat[2]; ?></td>  
                            <?php } ?>

                            <td><?php
                                if($i && $values['extension_miqaat'] != $miqaat[0] && (int)$miqaat[2] > 0 && $values['extension_count'] < 3)
                                {
                                  ?>
                                   <form class="form-horizontal" method="post" action="extend.php">
                                    <select name='no_of_days'>
                                      <option value="1">1 Day</option>
                                      <option value="2">2 Day</option>
                                      <option value="3">3 Day</option>
                                      <option value="4">4 Day</option>
                                      <option value="5">5 Day</option>
                                      <option value="6">6 Day</option>
                                      <option value="7">7 Day</option>
                                      <option value="8">8 Day</option>
                                      <option value="9">9 Day</option>
                                      <option value="10">10 Day</option>
                                    </select>
                                    <input type='hidden' name='miqaat' value='<?php echo $miqaat[0]; ?>'>
                                    <input type='submit' class='button' value='extend'>
                                  </form>
                                  <?php
                                }
                                else{
                                  echo "--";
                                } 
                                ?>
                            </td>

                          </tr>
                         <?php
                            $i = false;
                                }
                       ?>
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
