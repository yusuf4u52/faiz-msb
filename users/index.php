<?php
include('connection.php');
session_start();

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">

<head>

  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

  <title>Welcome to Student Information Center:: Faiz ul Mawaid il Burhaniya</title>

  <link rel='stylesheet prefetch' href='//codepen.io/assets/reset/reset.css'>

  <link rel='stylesheet prefetch' href='//maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css'>

  <link rel='stylesheet prefetch' href='http://faizulmawaidilburhaniyah.com/fmb/templates/fmb/css/resize.css'>

  <link rel='stylesheet prefetch' href='http://faizulmawaidilburhaniyah.com/fmb/templates/fmb/css/template.css'>



</head>

<body>

  <div id="all">

    <div id="header">

      <div class="container" style="position: relative;">

        <div class="header-inner">

          <div id="logo">

            <a href="/users" title="Faiz-ul-Mawaid-il-Burhaniyah"><img src="http://faizulmawaidilburhaniyah.com/fmb/templates/fmb/images/logo.png" alt="Faiz-ul-Mawaid-il-Burhaniyah"></a>

            Poona Students</div>

          </div>



        </div>

        <!--<div class="mainmenu">

        </div>-->

        <div class="clr"></div>

      </div>



      <div class="container">

        <div id="contentarea">

          <!--START PHP CODE-->
        
          <form method="POST" action="start_thali.php">
            <input type="submit" name="start_thali" value="Start Thali"/>
            <input type="hidden" gregdate name="start_date" value="<?php echo date("Y-m-d") ?>"/>
         </form>

         <form method="POST" action="stop_thali.php">
            <input type="submit" name="stop_thali" value="Stop Thali"/>
            <input type="hidden" gregdate name="stop_date" value="<?php echo date("Y-m-d") ?>"/>
         </form>

         <form method="POST" action="start_transport.php">

           <input type="submit" name="start_transport" value="Start Transport"/>

         </form>

         <form method="POST" action="stop_transport.php">

           <input type="submit" name="stop_transport" value="Stop Transport"/>

         </form>

         <form method="POST" action="update_details.php">

           <input type="submit" name="update_details" value="Update Details"/>

         </form>





         <a href = "logout.php">Logout</a><br>
         <?php 
          if(in_array($_SESSION['email'], array('yusuf4u52@gmail.com','tzabuawala@gmail.com','bscalcuttawala@gmail.com')))
          {
            ?>
            <a href = "thalisearch.php">Thali Search</a><?php
          }
         ?>


         <br />

         <br />

         <br />

         <table align="center" cellpadding="0" bgcolor="#FFFFFF" width="800" border="0">

          <tr>

            <td>

              <p align="center">

<?php 



if (is_null($_SESSION['fromLogin'])) {//send them back

 header("Location: login.php");

} else {

  echo "Welcome " . $_SESSION['email'] . ".";



  if ($_SESSION['email'] == "admin") {

    $query="SELECT Thali, NAME, CONTACT, Active, Transporter, Full_Address, Thali_start_date, Thali_stop_date, Total_Pending FROM thalilist";

  } else {

    $query="SELECT Thali, NAME, CONTACT, Active, Transporter, Full_Address, Thali_start_date, Thali_stop_date, Total_Pending FROM thalilist where Email_id = '".$_SESSION['email']."'";

  }

  echo "

  <table align=\"center\" border=\"0\" width=\"100%\">

  <tr>

  <td><b>Thali No.</b></td><td><b>Name</b></td><td><b>Contact</b></td><td><b>Active</b></td><td><b>Trasnporter</b></td><td><b>Address</b></td><td><b>Start Date</b></td><td><b>Stop Date</b></td><td><b>Hub Pending</b></td></tr> ";	



  if ($stmt = mysqli_prepare($link, $query)) {



    /* execute statement */

    mysqli_stmt_execute($stmt);



    /* bind result variables */

    mysqli_stmt_bind_result($stmt, $thali, $name, $contact, $active, $transporter, $address, $startdate, $stopdate, $hubpending);



    /* fetch values */

    while (mysqli_stmt_fetch($stmt)) {

      echo "<tr><td>".$thali."</td><td>".$name."</td><td>".$contact."</td><td>".$active."</td><td>".$transporter."</td><td>".$address."</td><td hijridate>".$startdate."</td><td hijridate>".$stopdate."</td><td>".$hubpending."</td></tr>";

    }echo "</table>";



    /* close statement */

    mysqli_stmt_close($stmt);

  }



$_SESSION['thali'] = $thali;

$_SESSION['address'] = $address;

$_SESSION['name'] = $name;

$_SESSION['contact'] = $contact;



/* close connection */

mysqli_close($link);

}

?>

          </p>

          <td>

          </tr>

        </table>

        <!--END PHP CODE-->

      </div><!-- end contentarea -->

    </div>



    <div id="footer">

      <div id="footer-area" class="width">



        <div class="copyright">

          <p>© 2016 Faiz-ul-Mawaid-il-Burhaniyah - Poona Students - Site by: <a href="http://faizstudents.com/" target="_blank">Faize Students Khidmat Guzaars</a></p>

        </div>

      </div>

      <!-- end footer -->

    </div>

  </div>

  <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
  <script src="//cdnjs.cloudflare.com/ajax/libs/moment.js/2.11.1/moment.min.js"></script>
  <script src="javascript/moment-hijri.js"></script>
  <script src="javascript/index.js"></script>
</body>

</html>					