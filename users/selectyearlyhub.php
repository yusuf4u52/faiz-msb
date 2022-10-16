<?php
require_once('connection.php');
include('_authCheck.php');

if (isset($_GET['message'])) {
?>
  <script type="text/javascript">
    alert('<?php echo "Please talk to your musaid or please call us on numbers listed here https://www.faizstudents.com/#contactUs"; ?>');
  </script>
<?php
}
$query = "SELECT yearly_hub FROM thalilist where Email_id = '" . $_SESSION['email'] . "'";

$values = mysqli_fetch_assoc(mysqli_query($link, $query));

if (!empty($values['next_year_hub'])) {
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
      <h1 class="col-xs-12">FMB takhmeen for full year from this Shehrullah(2nd April 2022) to Shabaan(21st March 2023).</h1>
      <h4 class="col-xs-12">Please select the total niyaaz amount that you will contribute for the this year.</h4>
    </div>
    <div class="row"><a href='selectyearlyhub_action.php?option=1' class="col-xs-12 col-sm-10 col-md-6 col-lg-4 btn btn-primary" style='margin:5px'>30,000/-</a></div>
    <div class="row"><a href='selectyearlyhub_action.php?option=2' class="col-xs-12 col-sm-10 col-md-6 col-lg-4 btn btn-primary" style='margin:5px'>32,000/-</a></div>
    <div class="row"><a href='selectyearlyhub_action.php?option=3' class="col-xs-12 col-sm-10 col-md-6 col-lg-4 btn btn-primary" style='margin:5px'>35,000/-</a></div>
    <div class="row"><a href='selectyearlyhub_action.php?option=4' class="col-xs-12 col-sm-10 col-md-6 col-lg-4 btn btn-primary" style='margin:5px'>40,000/-</a></div>

    <!-- <div class="row">
      <h1 class="col-xs-12">Only for sherullah.</h1>
    </div>
    <div class="row"><a href='selectyearlyhub_action.php?option=5' class="col-xs-12 col-sm-10 col-md-6 col-lg-4 btn btn-primary" style='margin:5px'>5,300/-</a></div> -->

    <div class="row">
      <hr>
      <div class="form-group">
        <form method="post" action="selectyearlyhub_action.php">
          <label for="inputEmail" class="col-lg control-label">Other ( > 30,000/-)</label>
          <div class="col-lg">
            <input type="number" class="form-control" name="other_takhmeen" />
          </div>
          <br>
          <button type="submit" class="btn btn-primary">Save changes</button>
        </form>
      </div>
    </div>


  </div>

  <?php include('_bottomJS.php'); ?>

  <div align="center">
    <a href="mailto:help@faizstudents.com">help@faizstudents.com</a><br><br>
  </div>
</body>

</html>