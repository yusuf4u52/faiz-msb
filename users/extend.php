<?php

include('connection.php');
include('_authCheck.php');

function addDayswithdate($date,$days){
    $date = strtotime("+".$days." days", strtotime($date));
    return  date("Y-m-d", $date);
}

$next_ext_date = addDayswithdate($_POST['miqaat'],$_POST['no_of_days']);
$values[] = "extension_miqaat = '".addslashes($_POST['miqaat'])."'";
$values[] = "extension_days = '".addslashes($_POST['no_of_days'])."'";
$values[] = "next_extension_date = '".$next_ext_date."'";
$values[] = "extension_count = extension_count + 1";

mysqli_query($link,"UPDATE thalilist set ".implode(',', $values)." WHERE Email_id = '".$_SESSION['email']."'") or die(mysqli_error($link));

header("Location: index.php");
?>