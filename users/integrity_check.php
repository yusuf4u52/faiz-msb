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
  echo $amount;

  $sql = mysqli_query($link,"SELECT SUM(`Paid`) from thalilist");
  $row = mysqli_fetch_row($sql);
  $paid = $row[0];
  echo $paid;

  if ($amount == $paid)
  echo "success";

  ?>
   </body>
</html>