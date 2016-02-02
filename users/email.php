<?php
include('connection.php');
error_reporting(0);

$msgvar = "Start Thali\n";

$myfile = fopen("startthali.txt", "r+") or die("Unable to open file!");
$msgvar .= fread($myfile,filesize("startthali.txt"));
ftruncate($myfile, 0);
fclose($myfile);

$msgvar .= "\nStop Thali\n";

$myfile = fopen("stopthali.txt", "r+") or die("Unable to open file!");
$msgvar .= fread($myfile,filesize("stopthali.txt"));
ftruncate($myfile, 0);
fclose($myfile);

$msgvar .= "\nStart Transport\n";

$myfile = fopen("starttransport.txt", "r+") or die("Unable to open file!");
$msgvar .= fread($myfile,filesize("starttransport.txt"));
ftruncate($myfile, 0);
fclose($myfile);

$msgvar .= "\nStop Transport\n";

$myfile = fopen("stoptransport.txt", "r+") or die("Unable to open file!");
$msgvar .= fread($myfile,filesize("stoptransport.txt"));
ftruncate($myfile, 0);
fclose($myfile);

$msgvar .= "\nUpdate Details\n";

$myfile = fopen("updatedetails.txt", "r+") or die("Unable to open file!");
$msgvar .= fread($myfile,filesize("updatedetails.txt"));
ftruncate($myfile, 0);
fclose($myfile);

$msgvar .= "\nNew registration\n";

$myfile = fopen("newregistration.txt", "r+") or die("Unable to open file!");
$msgvar .= fread($myfile,filesize("newregistration.txt"));
ftruncate($myfile, 0);
fclose($myfile);

$result = mysqli_query($link,"SELECT * FROM thalilist WHERE Active='1' ");
$count=mysqli_num_rows($result);

$msgvar .= "\n Count \n $count ";

$myfile = fopen("requestarchive.txt", "a") or die("Unable to open file!");
$txt= date('d/m/Y')."\n".$msgvar."\n";
fwrite($myfile, $txt);
fclose($myfile);

require_once 'mandrill/Mandrill.php'; //Not required with Composer
$msgvar = str_replace("\n", "<br>", $msgvar);
try {
    $mandrill = new Mandrill('BWDHEoe1pGlJ9yiH5xvUGw');
    $message = array(
        'html' => "<p>$msgvar</p>",
        'subject' => 'Start Stop update '.date('d/m/Y'),
        'from_email' => 'admin@faizstudents.com',
        'to' => array(
            array(
                'email' => 'help@faizstudents.com',
                 )
            array(
                'email' => 'bscalcuttawala@gmail.com',    
                 )
           )
     );

    $result = $mandrill->messages->send($message);
} catch(Mandrill_Error $e) {
    echo 'A mandrill error occurred: ' . get_class($e) . ' - ' . $e->getMessage();
    throw $e;
}

?>	