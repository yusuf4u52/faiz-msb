<?php
include('../users/connection.php');
include('../users/adminsession.php')

$query = file_get_contents("month_change.sql");

/* execute multi query */
if (mysqli_multi_query($link, $query))
     echo "Success";
else 
     echo "Fail";
?>