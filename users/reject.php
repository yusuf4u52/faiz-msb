<?php

include('connection.php');
include('adminsession.php');
require_once 'mandrill/Mandrill.php'; //Not required with Composer
// print_r($_POST); exit;


mysqli_query($link,"DELETE from thalilist WHERE Email_id = '".$_POST['email']."'");

$msgvar = 'Salam %name%,<br><br>Your thaali has not been activated as we are not currently able to deliver at your address. For any queries please mail us at <b>help@faizstudents.com.</b><br><br>Regards,<br>Faiz Team';

$msgvar = str_replace(array('%name%'), array($_POST['name']), $msgvar);

try {
    $mandrill = new Mandrill('BWDHEoe1pGlJ9yiH5xvUGw');
    $message = array(
        'html' => $msgvar,
        'subject' => "Student's Faiz - Thali activated",
        'from_email' => 'admin@faizstudents.com',
        'to' => array(
            array(
                'email' => $_POST['email']
                 ),
            array(
                'email' => 'help@faizstudents.com'
                 )
           )
     );

    $result = $mandrill->messages->send($message);
} catch(Mandrill_Error $e) {
    echo 'A mandrill error occurred: ' . get_class($e) . ' - ' . $e->getMessage();
    throw $e;
}

header("Location: pendingactions.php");
?>