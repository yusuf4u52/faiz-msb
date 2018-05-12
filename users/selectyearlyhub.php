<?php
include('connection.php');
include('_authCheck.php');

$query="SELECT yearly_hub FROM thalilist where Email_id = '".$_SESSION['email']."'";

$values = mysqli_fetch_assoc(mysqli_query($link,$query));

if(!empty($values['yearly_hub']))
{
  header("Location: index.php"); 
}

?>
<!DOCTYPE html>
<html lang="en">
    <head>
  <?php include('_head.php'); ?>
  </head>

  <body>

    <?php include('_nav.php'); ?>

    <div class="container">
        <div class="row">
            <h1 class="col-xs-12">Niyaaz takhmeen for full year from Shehrullah to Shabaan.</h1>
            <h4 class="col-xs-12">Please select the total niyaaz amount that you will contribute for the this year.</h4>
        </div>
        <div class="row"><a href='selectyearlyhub_action.php?option=1' class="col-xs-12 col-sm-10 col-md-6 col-lg-4 btn btn-primary" style='margin:5px'>21,000/-</a></div>
        <div class="row"><a href='selectyearlyhub_action.php?option=2' class="col-xs-12 col-sm-10 col-md-6 col-lg-4 btn btn-primary" style='margin:5px'>22,000/-</a></div>
        <div class="row"><a href='selectyearlyhub_action.php?option=3' class="col-xs-12 col-sm-10 col-md-6 col-lg-4 btn btn-primary" style='margin:5px'>24,000/-</a></div>
        <div class="row"><a href='selectyearlyhub_action.php?option=4' class="col-xs-12 col-sm-10 col-md-6 col-lg-4 btn btn-primary" style='margin:5px'>27,000/-</a></div>
        <div class="row"><a href='selectyearlyhub_action.php?option=5' class="col-xs-12 col-sm-10 col-md-6 col-lg-4 btn btn-primary" style='margin:5px'>53,000/-</a></div>
        <div class="row"><a href='#' id="otherOptionAnchor" class="col-xs-12 col-sm-10 col-md-6 col-lg-4 btn btn-primary" style='margin:5px'>Other</a></div>
        <div class="row" id="contactNumbers" style="display:none">
          <p>Please contact one of the members</p>
          <address class="col-6">
            <strong>Mustafa bhai Saifee</strong>
            <br>mesaifee52@gmail.com
            <br>
            <strong>7028045252</strong>
          </address>
          <address class="col-6">
            <strong>Mustafa Shk Hatim bhai Manawarwala</strong>
            <br>mustafamnr@gmail.com
            <br>
            <strong>9049378652</strong>
          </address>
          <address class="col-6">
            <strong>Yusuf Husain bhai Rampurwala</strong>
            <br>yusuf4u52@gmail.com
            <br>
            <strong>9503054797</strong>
          </address>
        </div>
    </div>

    <?php include('_bottomJS.php'); ?>
    <script>
    $(function() {
      $('#otherOptionAnchor').click(function(e){
        e.preventDefault();
        $('#contactNumbers').fadeIn(1000);
        window.location.hash = 'contactNumbers';
      })
    })
    </script>

    <div align="center">
    <a href="mailto:help@faizstudents.com">help@faizstudents.com</a><br><br>
    </div>
  </body>
</html>