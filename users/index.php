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

<html lang="en"><head><meta http-equiv="Content-Type" content="text/html; charset=UTF-8">

    <meta charset="utf-8">

    <title>Faiz ul Mawaid il Burhaniyah (Poona Students)</title>

    <meta name="viewport" content="width=device-width, initial-scale=1">

    <meta http-equiv="X-UA-Compatible" content="IE=edge">

    <link rel="stylesheet" href="./src/bootstrap.css" media="screen">

    <link rel="stylesheet" href="./src/custom.min.css">



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

                   <?php
          if(in_array($_SESSION['email'], array('murtaza.sh@gmail.com','yusuf4u52@gmail.com','tzabuawala@gmail.com','bscalcuttawala@gmail.com','mustafamnr@gmail.com')))
          {
            ?>

            <li><a href = "pendingactions.php">Pending Actions</a></li>
            <li><a href = "thalisearch.php">Thali Search</a></li>
            <li><a href = "../admin/index.php/examples/faiz">Admin</a></li>
            <?php

          }

         ?>
            <li><a href = "update_details.php">Update details</a></li>
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

              <h2 id="forms">Thali Details</h2>

            </div>

          </div>


          <div  class="col-lg-12">
         

          <?php
          if($values['Active'] == 0)
          {
          ?>
          <form method="POST" action="start_thali.php" onsubmit='return confirm("Are you sure?");'>
            <input type="submit" name="start_thali" value="Start Thali"  class="btn btn-success"/>
            <input type="hidden" class='gregdate' name="start_date" value="<?php echo date("Y-m-d") ?>"/>
         </form>
         <?php
        }
        else
        {
         ?>
       
         <form method="POST" action="stop_thali.php" onsubmit='return confirm("Are you sure?");'>
            <input type="submit" name="stop_thali" value="Stop Thali"  class="btn btn-danger"/>
            <input type="hidden" class='gregdate' name="stop_date" value="<?php echo date("Y-m-d") ?>"/>
         </form>

         <?php } ?>

         <br>
         <?php
          if($values['Transporter'] == 'Pick Up')
          {
          ?>
         <form method="POST" action="start_transport.php" onsubmit='return confirm("Are you sure?");'>
          <input type="submit" name="start_transport" value="Request Transport"  class="btn btn-success"/>
          <input type="hidden" class='gregdate' name="start_date" value="<?php echo date("Y-m-d") ?>"/>
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
         <br>
          </div>



        <div class="row">

          <div class="col-lg-12">

            <div class="well bs-component">
              <table class="table table-striped table-hover ">
                <thead>
                  <tr>
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
                  <tr>
                    <td><?php echo $values['Thali']; ?></td>
                    <td><?php echo $values['NAME']; ?></td>
                    <td><?php echo $values['CONTACT']; ?></td>
                    <td><?php echo ($values['Active'] == '1') ? 'Yes' : 'No'; ?></td>
                    <td><?php echo $values['Transporter']; ?></td>
                    <td><?php echo $values['Full_Address']; ?></td>
                    <td class='hijridate'><?php echo $values['Thali_start_date']; ?></td>
                    <td class='hijridate'><?php echo $values['Thali_stop_date']; ?></td>
                    <td><?php echo $values['Total_Pending']; ?></td>
                  </tr>

                </tbody>

              </table>

            </div>

          </div>
         
        </div>

      </div>

    </div>

          <?php
      if(isset($_GET['status']))
      {
      ?>
      <script type="text/javascript">
      <?php
      if($_GET['status'] == 'Start Thali Successful')
      {
        $message = $_GET['status'].'. '.'Your pending hub : "'.$values['Total_Pending'].'"'; 
      }
      else
      {
        $message = $_GET['status'];
      }
      ?>
      alert('<?php echo $message; ?>');
      </script>

            <?php } ?>
      <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
  <script src="//cdnjs.cloudflare.com/ajax/libs/moment.js/2.11.1/moment.min.js"></script>
     <script src="javascript/moment-hijri.js"></script>
  <script src="javascript/index.js"></script>

</body></html>