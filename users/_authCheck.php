<?php
if (!isset($_SESSION['fromLogin'])) {
 header("Location: login.php");
 exit;
}
?>