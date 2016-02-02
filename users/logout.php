<?php
session_start();
?>
<!DOCTYPE html>
<html>
<body>

<?php
// remove all session variables
session_unset(); 

// destroy the session 
session_destroy();

header('Location: https://www.google.com/accounts/Logout?continue=https://appengine.google.com/_ah/logout?continue=http://www.faizstudents.com/users/');

?>

</body>
</html>