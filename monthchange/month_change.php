<?php
include('../users/connection.php');
include('../users/adminsession.php');

$query = file_get_contents("month_change.sql");
$months = array('Moharram','Safar','RabiulAwwal','RabiulAkhar','JamadalAwwal','JamadalAkhar','Rajab','Shaban','Ramazan','Shawwal','Zilqad','Zilhaj');
$current_month = mysqli_fetch_row(mysqli_query($link,"select `value` from `settings` where `key` = 'current_month'"));
$current_month = $months[(int)$current_month[0] - 1];

$query = str_replace('%month%', $current_month, $query);

/* execute multi query */
if (mysqli_multi_query($link, $query))
     echo "Success";
else 
     echo "Fail";
?>