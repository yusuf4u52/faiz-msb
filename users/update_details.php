<?php

// Start the session
include('connection.php');

session_start();
if (is_null($_SESSION['fromLogin'])) {
   header("Location: login.php");
}

if ($_POST)
    {  
$result = mysqli_query($link,"UPDATE thalilist set 
                                      NAME='" . $_POST["name"] . "',
                                      CONTACT='" . $_POST["contact"] . "',
                                      Full_Address='" . $_POST["address"] . "',
                                      WATAN='" . $_POST["watan"] . "',
                                      ITS_No='" . $_POST["its"] . "'
                                      WHERE Email_id = '".$_SESSION['email']."'");

$myfile = fopen("updatedetails.txt", "a") or die("Unable to open file!");
$txt= $_SESSION['thali']." - ".$_POST['name']." - ".$_POST['contact']." - ".$_POST['address']." \n";
fwrite($myfile, $txt);
fclose($myfile);
 
        header('Location: index.php');       
    }
    else
    {
    	$query="SELECT Thali, NAME, CONTACT,ITS_No, WATAN, Active, Transporter, Full_Address, Thali_start_date, Thali_stop_date, Total_Pending FROM thalilist where Email_id = '".$_SESSION['email']."'";

 
     $data = mysqli_fetch_assoc(mysqli_query($link,$query));

     // print_r($data); exit;

     extract($data);
    }

?>
<!DOCTYPE html>

<!-- saved from url=(0029)http://bootswatch.com/flatly/ -->

<html lang="en"><head><meta http-equiv="Content-Type" content="text/html; charset=UTF-8">

    <meta charset="utf-8">

    <title>Bootswatch: Flatly</title>

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

              <h2 id="forms">Update info</h2>

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

                      <input type="text" class="form-control" id="inputName" placeholder="Name" required='required'  name="name" value='<?php echo $NAME;?>'>

                    </div>

                  </div>

                   <div class="form-group">

                    <label for="inputIts" class="col-lg-2 control-label">ITS Id</label>

                    <div class="col-lg-10">

                      <input type="text" class="form-control" id="inputIts" placeholder="its" required='required'  name="its" value='<?php echo $ITS_No;?>'>

                    </div>

                  </div>

                  <div class="form-group">

                    <label for="inputWatan" class="col-lg-2 control-label">Watan</label>

                    <div class="col-lg-10">

                      <input type="text" class="form-control" id="inputWatan" placeholder="watan" required='required'  name="watan" value='<?php echo $WATAN;?>'>

                    </div>

                  </div>

                  <div class="form-group">

                    <label for="inputContact" class="col-lg-2 control-label">Contact</label>

                    <div class="col-lg-10">

                      <input type="text" class="form-control" id="inputContact" placeholder="Contact" required='required' name="contact" value='<?php echo $CONTACT;?>'>

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

    <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>

</body></html>