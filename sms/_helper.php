<?php
require_once("_credentials.php");
require_once("../users/connection.php");

function helper_getTotalPending($user_thali)
{
  global $link;
  $query = "SELECT Total_Pending FROM thalilist where Thali='$user_thali'";
  $result = mysqli_query($link, $query) or die(mysqli_error($link));
  if ($result) {
    $row = mysqli_fetch_array($result);
    return $row['Total_Pending'];
  }
  return "no result";
}

function helper_getFirstNameWithSuffix($name)
{
  $firstNameWithSuffix = $name;
  $names = preg_split("/\s+/", $name);
  if (sizeof($names) >= 2) {
    $firstNameWithSuffix = $names[0] . " " . $names[1];
  }
  return $firstNameWithSuffix;
}
