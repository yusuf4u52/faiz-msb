<?php

include('connection.php');
include('adminsession.php');
require_once 'mandrill/Mandrill.php'; //Not required with Composer
// print_r($_POST); exit;
$values[] = "Thali = '".addslashes($_POST['thalino'])."'";

if(isset($_POST['transporter']))
{
	$values[] = "Transporter = '".addslashes($_POST['transporter'])."'";	
} 

mysqli_query($link,"UPDATE thalilist set ".implode(',', $values)." WHERE Email_id = '".$_POST['email']."'");

$msgvar = 'Salam %name%,<br><br>Your thali has been activated and your thali no is : <b>%thali%</b>.<br>You would now be able to log in to <b>www.faizstudents.com --> Update details</b> and view your information using your gmail id.<br>You also have option to Start/Stop thali and update your Details. For any queries please mail us at <b>help@faizstudents.com.</b><br><br>Regards,<br>Faiz Team';

$msgvar = str_replace(array('%thali%','%name%'), array($_POST['thalino'],$_POST['name']), $msgvar);

$myfile = fopen("newregistration.txt", "a") or die("Unable to open file!");
$txt= $_POST['thalino']." - ".$_POST['name']."\n";
fwrite($myfile, $txt);
fclose($myfile);

try {
    $mandrill = new Mandrill('BWDHEoe1pGlJ9yiH5xvUGw');
    $message = array(
        'html' => $msgvar,
        'subject' => "Student's Faiz - Thali activated",
        'from_email' => 'help@faizstudents.com',
        'to' => array(
            array(
                'email' => $_POST['email']
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