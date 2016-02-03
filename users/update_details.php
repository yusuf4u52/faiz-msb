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
                  <a class="navbar-brand" href="/users/">Poona Students Faiz</a>
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

    <script src="javascript/jquery-2.2.0.min.js"></script>
    <script src="javascript/bootstrap-3.3.6.min.js"></script>
  </body>
</html>