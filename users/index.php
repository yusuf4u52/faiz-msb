<?php

include('connection.php');

session_start();

if (!isset($_SESSION['fromLogin'])) {
 header("Location: login.php");
 exit;
}

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
// extract($data);
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
                <a class="navbar-brand font-bold" href="/users/">Poona Students Faiz</a>
            </div>

            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                <ul class="nav navbar-nav navbar-right">
                    <?php
                        if(in_array($_SESSION['email'], array('murtaza52@gmail.com','murtaza.sh@gmail.com','yusuf4u52@gmail.com','tzabuawala@gmail.com','bscalcuttawala@gmail.com','mustafamnr@gmail.com')))
                        {
                    ?>
                    <li><a href="pendingactions.php">Pending Actions</a></li>
                    <li><a href="thalisearch.php">Thaali Search</a></li>
                    <li><a href="stopMultipleThaalis.php">Stop Multiple Thaalis</a></li>
                    <li><a href="../admin/index.php/examples/faiz">Admin</a></li>
                    <li><a href="../admin/index.php/examples/receipts">Receipts</a></li>
                    <?php
                            }
                    ?>

                    <li><a href="update_details.php">Update details</a></li>
                    <li><a href="logout.php">Logout</a></li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container">
        <br />
        <br />

        <div class="row">
          <div class="col-xs-6 col-sm-3 col-md-2">

              <?php
                  if($values['Active'] == 0)
                  {
              ?>

              <form method="POST" action="start_thali.php" onsubmit='return confirm("Are you sure?");'>
                <input type="submit" name="start_thali" value="Start Thaali"  class="btn btn-success"/>
                <input type="hidden" class="gregdate" name="start_date" value="<?php echo date("Y-m-d") ?>"/>
              </form>

              <?php
                    }
                    else
                    {
              ?>
       
              <form method="POST" action="stop_thali.php" onsubmit='return confirm("Are you sure?");'>
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

              <form method="POST" action="start_transport.php" onsubmit='return confirm("Are you sure?");'>
                <input type="submit" name="start_transport" value="Request Transport"  class="btn btn-success"/>
                <input type="hidden" class="gregdate" name="start_date" value="<?php echo date("Y-m-d") ?>"/>
              </form>

              <?php
                }
                else
                {
              ?>

              <form method="POST" action="stop_transport.php" onsubmit='return confirm("Are you sure?");'>
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
                        <p class="list-group-item-text"><strong><?php echo $values['Total_Pending']; ?></strong></p>
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
                    <li class="list-group-item">
                        <h6 class="list-group-item-heading text-muted">Start Date</h6>
                        <p class="list-group-item-text hijridate"><?php echo $values['Thali_start_date']; ?></p>
                    </li>
                    <li class="list-group-item">
                        <h6 class="list-group-item-heading text-muted">Stop Date</h6>
                        <p class="list-group-item-text hijridate"><?php echo $values['Thali_stop_date']; ?></p>
                    </li>
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

    <script src="javascript/jquery-2.2.0.min.js"></script>
    <script src="javascript/bootstrap-3.3.6.min.js"></script>
    <script src="javascript/moment-2.11.1-min.js"></script>
    <script src="javascript/moment-hijri.js"></script>
    <script src="javascript/hijriDate.js"></script>
    <script src="javascript/index.js"></script>

  </body>
</html>