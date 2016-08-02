<?php

include('connection.php');
include('adminsession.php');
require 'mailgun-php/vendor/autoload.php';
use Mailgun\Mailgun;


mysqli_query($link,"DELETE from thalilist WHERE Email_id = '".$_POST['email']."'") or die(mysqli_error($link));

$msgvar = 'Salam %name%,<br><br>Your thaali has not been activated as we are not currently able to deliver at your address. For any queries please mail us at <b>help@faizstudents.com.</b><br><br>Regards,<br>Faiz Team';

$msgvar = str_replace(array('%name%'), array($_POST['name']), $msgvar);

$mg = new Mailgun("key-e3d5092ee6f3ace895af4f6a6811e53a");
$domain = "mg.faizstudents.com";

# Now, compose and send your message.
$mg->sendMessage($domain, array('from'    => 'admin@faizstudents.com', 
                                'to'      =>  $_POST['email'], 
                                'cc'      => 'help@faizstudents.com',   
                                'subject' => "Student's Faiz - Thali Not Activated", 
                                'html'    => $msgvar));


header("Location: pendingactions.php");
?>