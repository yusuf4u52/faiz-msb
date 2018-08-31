<?php
$values = mysqli_fetch_assoc($result);
?>
<div class="panel panel-default">
  <div aria-labelledby="headingOne">
    <div class="panel-body">
      <ul class="list-group col">
        <li class="list-group-item">
          <a href="#" data-key="payhoob" data-thali="<?php echo $values['Thali']; ?>">Pay Hoob</a> | 
          <?php
        if($values['Active'] == '1') {?>
          <a href="#" data-key="stopthaali" data-thali="<?php echo $values['Thali']; ?>" data-active="0">Stop Thaali</a> | 
          <?php }else{ ?>
          <a href="#" data-key="stopthaali" data-thali="<?php echo $values['Thali']; ?>" data-active="1">Start Thaali</a> | 
          <?php } 
          if($values['Active'] != '2') {?>
          <a href="#" data-key="stoppermanant" data-thali="<?php echo $values['Thali']; ?>">Stop Permanant</a>
        <?php } ?>
        </li>
        <li class="list-group-item">
            <h6 class="list-group-item-head ing text-muted">Thaali Number</h6>
            <p class="list-group-item-text"><strong><?php echo $values['Thali']; ?></strong></p>
        </li>
        <li class="list-group-item">
            <h6 class="list-group-item-head ing text-muted">Name</h6>
            <p class="list-group-item-text"><strong><?php echo $values['NAME']; ?></strong></p>
        </li>
        <li class="list-group-item">
            <h6 class="list-group-item-head ing text-muted">Mobile No</h6>
            <p class="list-group-item-text"><strong><?php echo $values['CONTACT']; ?></strong></p>
        </li>
        <li class="list-group-item">
            <h6 class="list-group-item-head ing text-muted">Active</h6>
            <p class="list-group-item-text"><strong><?php echo ($values['Active'] == '1') ? 'Yes' : 'No'; ?></strong></p>
        </li>
        <li class="list-group-item">
            <h6 class="list-group-item-head ing text-muted">Transporter</h6>
            <p class="list-group-item-text"><strong><?php echo $values['Transporter']; ?></strong></p>
        </li>
        <li class="list-group-item">
            <h6 class="list-group-item-head ing text-muted">Address</h6>
            <p class="list-group-item-text"><strong><?php echo $values['Full_Address']; ?></strong></p>
        </li>

        <li class="list-group-item">
            <h6 class="list-group-item-head ing text-muted">Start Date</h6>
            <p class="list-group-item-text"><strong class="hijridate"><?php echo $values['Thali_start_date']; ?></strong></p>
        </li>

        <li class="list-group-item">
            <h6 class="list-group-item-head ing text-muted">Stop Date</h6>
            <p class="list-group-item-text"><strong class="hijridate"><?php echo $values['Thali_stop_date']; ?></strong></p>
        </li>

        <li class="list-group-item">
            <h6 class="list-group-item-head ing text-muted">Hub Pending</h6>
            <p class="list-group-item-text"><strong><?php echo $values['Total_Pending']; ?></strong></p>
        </li>
        <li class="list-group-item">
          <table class="table table-striped table-hover">
          <tr>
          <td><b>Receipt No</b></td>
          <td><b>Amount</b></td>
          <td><b>Date</b></td>
          </tr>
          <?php
          $query = "SELECT r.* FROM receipts r, thalilist t WHERE r.userid = t.id and t.Thali ='".$values['Thali']."' ORDER BY Date ASC";
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
        </li>
      </ul>  
    </div>
  </div>
  </div>