<?php
include('connection.php');
require 'mailgun-php/vendor/autoload.php';
use Mailgun\Mailgun;

error_reporting(0);

if (filesize('startthali.txt') != 0)
{
$msgvar = "Start Thali\n";

$myfile = fopen("startthali.txt", "r+") or die("Unable to open file!");
$readfile = fread($myfile,filesize("startthali.txt"));
// Remove Duplicate 
$msgvar .= implode("\n",array_unique(explode("\n", $readfile)));
ftruncate($myfile, 0);
fclose($myfile);
}

if (filesize('stopthali.txt') != 0)
{
$msgvar .= "\nStop Thali\n";

$myfile = fopen("stopthali.txt", "r+") or die("Unable to open file!");
$readfile = fread($myfile,filesize("stopthali.txt"));
// Remove Duplicate 
$msgvar .= implode("\n",array_unique(explode("\n", $readfile)));
ftruncate($myfile, 0);
fclose($myfile);
}

if (filesize('starttransport.txt') != 0)
{
$msgvar .= "\nStart Transport\n";

$myfile = fopen("starttransport.txt", "r+") or die("Unable to open file!");
$readfile = fread($myfile,filesize("starttransport.txt"));
// Remove Duplicate 
$msgvar .= implode("\n",array_unique(explode("\n", $readfile)));
ftruncate($myfile, 0);
fclose($myfile);
}

if (filesize('stoptransport.txt') != 0)
{
$msgvar .= "\nStop Transport\n";

$myfile = fopen("stoptransport.txt", "r+") or die("Unable to open file!");
$readfile = fread($myfile,filesize("stoptransport.txt"));
// Remove Duplicate 
$msgvar .= implode("\n",array_unique(explode("\n", $readfile)));
ftruncate($myfile, 0);
fclose($myfile);
}

if (filesize('updatedetails.txt') != 0)
{
$msgvar .= "\nUpdate Details\n";

$myfile = fopen("updatedetails.txt", "r+") or die("Unable to open file!");
$readfile = fread($myfile,filesize("updatedetails.txt"));
// Remove Duplicate 
$msgvar .= implode("\n",array_unique(explode("\n", $readfile)));
ftruncate($myfile, 0);
fclose($myfile);
}

if (filesize('newregistration.txt') != 0)
{
$msgvar .= "\nNew registration\n";

$myfile = fopen("newregistration.txt", "r+") or die("Unable to open file!");
$readfile = fread($myfile,filesize("newregistration.txt"));
// Remove Duplicate 
$msgvar .= implode("\n",array_unique(explode("\n", $readfile)));
ftruncate($myfile, 0);
fclose($myfile);
}

$result = mysqli_query($link,"SELECT * FROM thalilist WHERE Active='1' ");
$count=mysqli_num_rows($result);

$msgvar .= "\n Count \n $count ";


$myfile = fopen("requestarchive.txt", "a") or die("Unable to open file!");
$txt= date('d/m/Y')."\n".$msgvar."\n";
fwrite($myfile, $txt);
fclose($myfile);

$msgvar = str_replace("\n", "<br>", $msgvar);

$mg = new Mailgun("key-e3d5092ee6f3ace895af4f6a6811e53a");
$domain = "mg.faizstudents.com";

$mg->sendMessage($domain, array('from'    => 'admin@faizstudents.com', 
                                'to'      => 'mustukotaliya53@gmail.com,bscalcuttawala@gmail.com', 
                                'cc'      => 'help@faizstudents.com',   
                                'subject' => 'Start Stop update '.date('d/m/Y'),
                                'html'    => $msgvar));

?>	