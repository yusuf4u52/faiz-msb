<?php

include('connection.php');

session_start();

include('_authCheck.php');

$query="SELECT Thali, NAME, CONTACT, Active, Transporter, Full_Address, Thali_start_date, Thali_stop_date, Total_Pending FROM thalilist where Email_id = '".$_SESSION['email']."'";

$values = mysqli_fetch_assoc(mysqli_query($link,$query));

$_SESSION['thali'] = $values['Thali'];
$_SESSION['address'] = $values['Full_Address'];
$_SESSION['name'] = $values['NAME'];
$_SESSION['contact'] = $values['CONTACT'];
$_SESSION['transporter'] = $values['Transporter'];

if(empty($values['Thali']))
{
  session_unset();  
  session_destroy();

  $status = "Ooops! Something went wrong. Send and email to help@faizstudents.com";
  header("Location: login.php?status=$status");
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
                  if($values['Transporter'] == 'Pick Up')
                  {
              ?>

              <form method="POST" action="start_transport.php" onsubmit='return confirm("Are you sure?");' data-key="LazyLoad" class="hidden">
                <input type="submit" name="start_transport" value="Request Transport"  class="btn btn-success"/>
              </form>

              <?php
                }
                else
                {
              ?>

              <form method="POST" action="stop_transport.php" onsubmit='return confirm("Are you sure?");' data-key="LazyLoad" class="hidden">
                <input type="submit" name="stop_transport" value="Stop Transport"  class="btn btn-danger"/>
              </form>

              <?php
                }
              ?>
          </div>
        </div>

        <br />

        <div class="row">
            <h1 class="col-xs-12">Thaali Details</h1>
        </div>

        <br />

        <div class="row">
            <div class="col-xs-12 col-sm-10 col-md-6 col-lg-4">
                <ul class="list-group col">
                    <li class="list-group-item">
                        <h6 class="list-group-item-heading text-muted">Thaali Number</h6>
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

    <?php
      if(isset($_GET['status']))
      {
    ?>
        <script type="text/javascript">
            <?php
                if($_GET['status'] == 'Start Thali Successful') {
                    $message = $_GET['status'].'. '.'Your pending hub : "'.$values['Total_Pending'].'"';
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