<?php
    $data = file_get_contents ('uploads/'.$_GET['its'].'.json');
    $userdata = json_decode($data, TRUE);

    // echo "<pre>";
    // print_r($userdata);
    // echo "</pre>";
?>
<!DOCTYPE html>
<!-- saved from url=(0050)http://getbootstrap.com/examples/jumbotron-narrow/ -->
<html lang="en"><head><meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="http://getbootstrap.com/favicon.ico">

    <title>Thali registration form</title>

    <!-- Bootstrap core CSS -->
    <link href="assets/bootstrap.min.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="assets/jumbotron-narrow.css" rel="stylesheet">

    <!-- Just for debugging purposes. Don't actually copy these 2 lines! -->
    <!--[if lt IE 9]><script src="../../assets/js/ie8-responsive-file-warning.js"></script><![endif]-->
    <style type="text/css">
    .container
    {
      outline: 1px solid black;
    }
    </style>

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
  </head>

  <body>

    <div class="container">
      <div style="text-align: center; vertical-align: middle; font-weight:20px; margin-bottom:3em;">
        <h3 class="text-muted"><strong>Thali Registration</strong></h3>
      </div>

      <form method="get">
        <div class='col-xs-12'>
            <div class="form-group col-xs-4">
              <label for="firstname">First Name</label>
              <br><?php echo $userdata['firstname']; ?>
            </div>
            <div class="form-group col-xs-4" style="">
              <label for="fathername">Father's Name</label>
              <br><?php echo $userdata['fathername']; ?>
            </div>
            <div class="form-group col-xs-4" style="">
              <label for="lastname">Last Name</label>
              <br><?php echo $userdata['lastname']; ?>
            </div>
            <div class="form-group col-xs-4">
              <label for="its">ITS Id</label>
              <br><?php echo $userdata['its']; ?>
            </div>
            <div class="form-group col-xs-12" style="height:80px">
              <label for="address">Address</label>
              <br><?php echo $userdata['address']; ?>
            </div>
            <div class="form-group col-xs-6">
              <label for="mobile">Mobile Number</label>
              <br><?php echo $userdata['mobile']; ?>
            </div>
            <div class="form-group col-xs-6">
              <label for="email">Email Address</label>
              <br><?php echo $userdata['email']; ?>
            </div>
            <div class="form-group col-xs-6">
              <label for="watan">Watan</label>
              <br><?php echo $userdata['watan']; ?>
            </div>
            <div class="form-group col-xs-12">
              <label>Transport Required : </label>
              <br><?php echo $userdata['transport']; ?>
            </div>
            <div class="form-group col-xs-12">
              <label>Occupation : </label>
              <br><?php echo $userdata['occupation']; ?>
            </div>
			<!-- <hr style="width: 100%; color: black; height: 1px; background-color:black;" /> -->
			<div class="form-group col-xs-12"  style="text-align: center; vertical-align: middle; font-weight:20px; outline: 1px solid black;">
              <strong>For Office use only<strong> 
            </div>
			<!-- <hr style="width: 100%; color: black; height: 1px; background-color:black;" /> -->
			<div class="form-group col-xs-6">
              <label>Thali no assigned</label>
              <br><br>
			  <br>-----------------------------
      </div>
      <div class="form-group col-xs-6" style="text-align:right">
              <label>Transporter assigned</label>
              <br><br>
			  <br>-----------------------------
      </div>
        </div>
      </form>
    </div> <!-- /container -->
    <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
</body></html>