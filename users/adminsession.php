<?php
  session_start();

if (!is_null($_SESSION['fromLogin']) && in_array($_SESSION['email'], array('mesaifee52@gmail.com','husainpoonawala1995@gmail.com','nationalminerals52@gmail.com','murtaza52@gmail.com','yusuf4u52@gmail.com','tzabuawala@gmail.com','hzfshakir199@gmail.com','murtaza.sh@gmail.com','mustafamnr@gmail.com', 'ismailsidhpuri@gmail.com'))) {
 
} elseif (!empty($_POST['mobile'])) {
	// set email based on mobile number
  $sql = mysqli_query($link,"SELECT * from users where mobile='".$_POST('mobile')."'");
  $row = mysqli_fetch_row($sql);
  $_SESSION['email'] = $row['email'];
}
else {
  header("Location: login.php");
  exit; 
}
?>
