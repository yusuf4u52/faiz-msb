<?php
include('../users/connection.php');
require '../users/mailgun-php/vendor/autoload.php';
use Mailgun\Mailgun;
if (mysqli_connect_errno())
  {
  echo "Failed to connect to MySQL: " . mysqli_connect_error();
  }
  $msg = false;
if($_POST)
{
  $raw_data = $_POST;
  function sanitize($v)
  {
    return addslashes($v);
  }
  $data = array_map("sanitize",$raw_data);
  extract($data);
$transport = ($transport == 'Yes') ? 'Transporter' : 'Pick Up';
$occupation = ($occupation == 'Student') ? 'Student' : 'Working';
$sql = "INSERT INTO thalilist (
                                        `NAME`,
                                        `CONTACT`,
                                        `ITS_No`,
                                        `Full_Address`,
                                        `Email_ID`,
                                        `WATAN`,
                                        `Transporter`,
                                        `Occupation`
                                       ,`Gender`
                                       ,`Area`
                                       ,`WhatsApp`
                                       ,`College`
                                       ,`Field`
                                       ,`Permanent_Residence`
                                        )
                            VALUES (
                                    '$firstname $fathername $lastname',
                                    '$mobile',
                                    '$its',
                                    '$address',
                                    '$email',
                                    '$watan',
                                    '$transport',
                                    '$occupation'
                                    ,'$gender'
                                    ,'$area'
                                    ,'$whatsapp'
                                    ,'$college'
                                    ,'$field'
                                    ,'$permanent_residence'
                                    )";
  $msg = true;
  mysqli_query($link,$sql) or die(mysqli_error($link));
  mysqli_close($link);

$msgvar = "Salaam ".$firstname.",<br><br>New Registration form for Faiz ul Mawaid il Burhaniyah Thali has been successfully submitted.<br>
<b>Please visit faiz to get the thali activated.</b><br>
For any concerns mail help@faizstudents.com";

$mg = new Mailgun("key-e3d5092ee6f3ace895af4f6a6811e53a");
$domain = "mg.faizstudents.com";

$mg->sendMessage($domain, array('from'    => 'admin@faizstudents.com', 
                                'to'      =>  $email, 
                                'cc'      => 'help@faizstudents.com',   
                                'subject' => 'New Registration Successful, Visit Faiz to activate the thali',
                                'html'    => $msgvar));

}
?>
<!DOCTYPE html>
<html lang="en"><head><meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="/users/images/icon.png">

    <title>Thali registration form</title>

    <!-- Bootstrap core CSS -->
    <link href="assets/bootstrap.min.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="assets/jumbotron-narrow.css" rel="stylesheet">

    <!-- Just for debugging purposes. Don't actually copy these 2 lines! -->
    <!--[if lt IE 9]><script src="../../assets/js/ie8-responsive-file-warning.js"></script><![endif]-->
    <style type="text/css">
      body { 
            /*background-image: url('assets/background.jpg');*/
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
  </head>

  <body>

    <div class="container drop-shadow">
      <?php if($msg):?>
      
      <!--   <strong>Registration Successful!</strong> Please visit faiz to activate your thali. -->
        <script type="text/javascript">
      alert('Data Submitted, Visit faiz to activate thali');
      </script>
    <?php endif; ?>

      <div class="header" style="text-align: center; vertical-align: middle; font-weight:20px">
        <h2 class="text-muted"><strong>Thali Registration</strong></h2>
      </div>

      <form method="post">
        <div class='col-xs-12'>
            <div class="form-group col-xs-4">
              <label for="its">ITS Id <a class="required">*</a></label>
              <input type="text" class="form-control" id="its" name="its" pattern="[0-9]{8}" required>
            </div>
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
            <div class="form-group col-xs-12">
              <label>Gender <a class="required">*</a> : </label>
              <label class="radio-inline">
                <input type="radio" name="gender" value="Male" required />Male
              </label>
              <label class="radio-inline">
                <input type="radio" name="gender" value="Female" required />Female
              </label>
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
              <label for="area">Area <a class="required">*</a></label>
              <select class="form-control" id="area" name="area" required>
                <option disabled selected value> -- select an option -- </option>
                <option value="Bhagyoday Nagar">Bhagyoday Nagar</option>
                <option value="Bhawani Peth">Bhawani Peth</option>
                <option value="Camp">Camp</option>
                <option value="City">City</option>
                <option value="Fakhri Hills">Fakhri Hills</option>
                <option value="Fatima Nagar">Fatima Nagar</option>
                <option value="Ghorpadi">Ghorpadi</option>
                <option value="Kondhwa">Kondhwa</option>
                <option value="Kondhwa Budruk">Kondhwa Budruk</option>
                <option value="Kothrud">Kothrud</option>
                <option value="Market Yard">Market Yard</option>
                <option value="Mitha Nagar">Mitha Nagar</option>
                <option value="NIBM">NIBM</option>
                <option value="Salunke Vihar">Salunke Vihar</option>
                <option value="Tilak Nagar">Tilak Nagar</option>
                <option value="Undri">Undri</option>
                <option value="Wanawadi">Wanawadi</option>
                <option value="(not present in the list)">(not present in the list)</option>
              </select>
            </div>
            <div class="form-group col-xs-6">
              <label for="mobile">Mobile Number <a class="required">*</a></label>
              <input type="text" class="form-control" id="mobile" name="mobile" pattern="[0-9]{10}" required>
            </div>
            <div class="form-group col-xs-6">
              <label for="whatsapp">WhatsApp Number <a class="required">*</a></label>
              <input type="text" class="form-control" id="whatsapp" name="whatsapp" pattern="0{2}[0-9]{8,20}" required placeholder="00[CountryCode][MobileNumber]">
            </div>
            <div class="form-group col-xs-6">
              <label for="email">Email Address <a class="required">*</a></label>(only Gmail)
              <input type="email" class="form-control" id="Email" name="email" pattern="^[_a-z0-9-]+(\.[_a-z0-9-]+)*@gmail.com$" required>
            </div>
            <div class="form-group col-xs-6">
              <label for="watan">Watan <a class="required">*</a></label>
              <input type="text" class="form-control" id="watan" name="watan" required>
            </div>
            <div class="form-group col-xs-6">
              <label for="permanent_residence">Permanent Residence</label>
              <input type="text" class="form-control" id="permanent_residence" name="permanent_residence">
              <p class="help-block">If different from Watan e.g. Kuwait, Dubai, Mumbai, Surat etc</p>
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
            <div class="form-group col-xs-6">
              <label for="college">Full College/Company Name <a class="required">*</a></label>
              <input type="text" class="form-control" id="college" name="college" required>
            </div>
            <div class="form-group col-xs-6">
              <label for="field">Field/Stream of Study <a class="required">*</a></label>
              <input type="text" class="form-control" id="field" name="field" required>
            </div>
            <div class="form-group col-xs-12" style="text-align: center; vertical-align: middle; font-weight:20px">
              <button type="submit" class="btn btn-success">Submit Request</button>
            </div>
        </div>
      </form>
    </div> <!-- /container -->
    <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
</body></html>