  <html>
 <head>
  <title>Hub sanity test</title>
 </head>
 <body>

  <?php
  include('connection.php');

  $sql = mysqli_query($link,"SELECT SUM(`Amount`) from receipts");
  $row = mysqli_fetch_row($sql);
  $amount = $row[0];
  echo "Amount in Receipts ".$amount."";
  ?>
  <br>
  <?php
  $sql = mysqli_query($link,"SELECT SUM(`Paid`) from thalilist");
  $row = mysqli_fetch_row($sql);
  $paid = $row[0];
  echo "Amount in Thalilist ".$paid."\n";
  ?>
  <br>
  <?php
  if ($amount == $paid)
  echo "Both matches so we are good";
  else
  echo "Something is wrong as numbers above dont match up";
  ?>
  <br>
  <?php

  $sql = mysqli_query($link,"select l.Receipt_No + 1 as start, min(fr.Receipt_No) - 1 as stop from receipts as l left outer join receipts as r on l.Receipt_No = r.Receipt_No - 1 left outer join receipts as fr on l.Receipt_No < fr.Receipt_No where r.Receipt_No is null and fr.Receipt_No is not null group by l.Receipt_No, r.Receipt_No;");
  $row = mysqli_fetch_array($sql);
  // $pendingReceipt = $row[1];
  // echo "Pending Receipts ".$pendingReceipt."";
  echo "Missing Receipts are - ";
  print_r($row);



 

  ?>
   </body>
</html>