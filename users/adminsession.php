<?php
  session_start();

if (!is_null($_SESSION['fromLogin']) && in_array($_SESSION['email'], array('husainpoonawala1995@gmail.com','nationalminerals52@gmail.com','murtaza52@gmail.com','yusuf4u52@gmail.com','tzabuawala@gmail.com','bscalcuttawala@gmail.com','murtaza.sh@gmail.com','mustafamnr@gmail.com', 'ismailsidhpuri@gmail.com'))) {
 
}
else {
  header("Location: login.php");
  exit; 
  //some learnings on PHP ;)
  //http://stackoverflow.com/q/6334033/148271
  //http://stackoverflow.com/q/3553698/148271
}
?>