<?php
include('_authCheck.php');
include('connection.php');
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
        <div class="col-lg-12">
          <table class="table table-striped table-hover">
          <tr>
          <td><b>Receipt No</b></td>
          <td><b>Amount</b></td>
          <td><b>Date</b></td>
          </tr>
          <?php
          $query_tables = "SHOW TABLES";
          $result_tables = mysqli_query($link,$query_tables);
          $query = "";
          echo $query;
          while($row = $result_tables->fetch_array(MYSQLI_NUM)){ 
            if (strpos($row[0], 'receipts_') !== false) {
              $query .= "SELECT r.* FROM ".$row[0]." r, thalilist t WHERE r.Thali_No = t.Thali and t.Email_ID ='".$_SESSION['email']."' UNION ";
            }
          }
          $query .= "SELECT r.* FROM receipts r, thalilist t WHERE r.Thali_No = t.Thali and t.Email_ID ='".$_SESSION['email']."' ORDER BY Date DESC";
          $result = mysqli_query($link,$query);
          while($row = mysqli_fetch_assoc($result)){ 
          foreach($row AS $key => $value) { $row[$key] = stripslashes($value); } 
            echo "<tr>";  
            echo "<td>" . nl2br( $row['Receipt_No']) . "</td>";  
            echo "<td>" . nl2br( $row['Amount']) . "</td>";  
            echo "<td class=\"hijridate\">" . nl2br( $row['Date']) . "</td>";  
            echo "</tr>"; 
          } 
          ?>
          </table>
        </div>
      </div>
    </div>
    <?php include('_bottomJS.php'); ?>
  </body>
</html>

