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
            <h1 class="col-xs-12">Niyaaz takhmeen for the year of Shehrullah 1437 - Shabaan 1438.</h1>
            <h4 class="col-xs-12">Please select the total niyaaz amount that you will contribute for the full year.</h4>
        </div>
          <a class="row" href='selectyearlyhub_action.php?option=1'><button type="button" class="col-xs-12 col-sm-10 col-md-6 col-lg-4 btn btn-primary" style='margin:5px'>21,000/-</button></a>
          <a class="row" href='selectyearlyhub_action.php?option=2'><button type="button" class="col-xs-12 col-sm-10 col-md-6 col-lg-4 btn btn-primary" style='margin:5px'>24,000/-</button></a>
          <a class="row" href='selectyearlyhub_action.php?option=3'><button type="button" class="col-xs-12 col-sm-10 col-md-6 col-lg-4 btn btn-primary" style='margin:5px'>27,000/-</button></a>
          <a class="row" href='selectyearlyhub_action.php?option=4'><button type="button" class="col-xs-12 col-sm-10 col-md-6 col-lg-4 btn btn-primary" style='margin:5px'>53,000/-</button></a>
    </div>

    <?php include('_bottomJS.php'); ?>

    <div align="center">
    <a href="mailto:help@faizstudents.com">help@faizstudents.com</a><br><br>
    </div>
  </body>
</html>