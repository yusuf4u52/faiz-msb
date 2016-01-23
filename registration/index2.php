<?php
require_once('libraries/PHPMailerAutoload.php');
function send_mail($details)
{
    $message = "
    <html>
    <head>
    <title>New Thali Registration</title>
    </head>
    <body>
    <p>New Thali Details</p>
    <table border='1'>
    ";

    foreach ($details as $key => $value) {
      $message.= "<tr>
      <td style='padding: 5px;'>".$key."</td>
      <td style='padding: 5px;'>".$value."</td>
      </tr>";
    }

    $message.= "
    </table>
    </body>
    </html>
    ";
    
        $mail = new PHPMailer;
        $mail->setFrom('registration@faizstudents.com', 'Faiz Thali Registration');
        $mail->addAddress('mustafamnr@gmail.com', 'mustafamnr');
        $mail->addAddress('tzabuawala@gmail.com', 'taha');
        $mail->Subject = 'New Thali Registration';
        $mail->msgHTML($message);
        if (!$mail->send()) {
            echo "Mailer Error: " . $mail->ErrorInfo;
        }
}
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
      body { 
            background-image: url('assets/background.jpg');
            background-attachment: fixed;
        }
        .container {
            background-color: #FCFCE4;
            padding-top: 1em;
            padding-bottom: 1em;
        }
        .required
        {
          color: red;
        }

    </style>

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
  </head>

  <body>

    <div class="container drop-shadow">
      <div class="header" style="text-align: center; vertical-align: middle; font-weight:20px">
        <h2 class="text-muted"><strong>Thali Registration</strong></h2>
      </div>

      <?php if(!$_POST):?>
      <form method="post">
        <div class='col-xs-12'>
            <div class="form-group col-xs-4">
              <label for="firstname">First Name <a class="required">*</a></label>
              <input type="text" class="form-control" id="firstname" name="firstname" required>
            </div>
            <div class="form-group col-xs-4">
              <label for="fathername">Father's Name <a class="required">*</a></label>
              <input type="text" class="form-control" id="fathername" name="fathername" required>
            </div>
            <div class="form-group col-xs-4">
              <label for="lastname">Last Name <a class="required">*</a></label>
              <input type="text" class="form-control" id="lastname" name="lastname" required>
            </div>
            <div class="form-group col-xs-4">
              <label for="its">ITS Id <a class="required">*</a></label>
              <input type="text" class="form-control" id="its" name="its" required>
            </div>
            <div class="form-group col-xs-12">
              <label for="address">Address <a class="required">*</a></label>
              <!-- <input type="text" class="form-control" id="address1" name="address1" required>
              <input type="text" class="form-control" id="address2" name="address2" required style="margin-top : 5px">
              <input type="text" class="form-control" id="address3" name="address3" required style="margin-top : 5px"> -->

              <textarea class="form-control" rows="3" id="address" name="address" required></textarea>
              <p class="help-block">Please enter in this order-FLAT No, Floor No, Bldg No, SOCIETY Name, ROAD, Nearest LANDMARK</p>
            </div>
            <div class="form-group col-xs-6">
              <label for="mobile">Mobile Number <a class="required">*</a></label>
              <input type="text" class="form-control" id="mobile" name="mobile" maxlength="10" required>
            </div>
            <div class="form-group col-xs-6">
              <label for="email">Email Address <a class="required">*</a></label>
              <input type="email" class="form-control" id="Email" name="email" required>
            </div>
            <div class="form-group col-xs-6">
              <label for="watan">Watan <a class="required">*</a></label>
              <input type="text" class="form-control" id="watan" name="watan" required>
            </div>
            <div class="form-group col-xs-12">
              <label>Transport Required <a class="required">*</a> : </label>
              <label class="radio-inline">
                <input type="radio" name="transport" value="Yes" required>Yes
              </label>
              <label class="radio-inline">
                <input type="radio" name="transport" value="No" required>No
              </label>
            </div>
            <div class="form-group col-xs-12">
              <label>Occupation <a class="required">*</a> : </label>
              <label class="radio-inline">
                <input type="radio" name="occupation" value="Student" required>Student
              </label>
              <label class="radio-inline">
                <input type="radio" name="occupation" value="Working Professional" required>Working Professional
              </label>
            </div>
            <div class="form-group col-xs-12" style="text-align: center; vertical-align: middle; font-weight:20px">
              <button type="submit" class="btn btn-success">Submit Request</button>
            </div>
        </div>
      </form>
    <?php else:
      $fp = fopen('uploads/'.$_POST['its'].'.json', 'w');
      fwrite($fp, json_encode($_POST));
      fclose($fp);
      send_mail($_POST);
     ?>
        <div class='col-xs-12'>
          <div class='alert alert-success'>
          <strong>Your regitration is successful!</strong> Please download the form and bring the print out and a photocopy of your E-Jamaat card to our office to complete the process.
        </div>
          <div class="form-group col-xs-12" style="text-align: center; vertical-align: middle; font-weight:20px">
              <a href="pdf.php?its=<?php echo $_POST['its']; ?>" class="btn btn-success">Download Form</a>
            </div>
        </div>
    <?php endif; ?>
    </div> <!-- /container -->
    <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
</body></html>