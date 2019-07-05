<?php
require_once 'connection.php';
include('adminsession.php');
require '_credentials.php';
// require_once 'mandrill/Mandrill.php'; //Not required with Composer
// print_r($_POST); exit;
/*
    BASIC LOGIC
    I plan to send email and sms to the user
    requirements:
        user_name       name of student
        ^user_amount    amount paid as Hub
        ^user_thali     thali no. of student
        ^user_receipt   receipt no. for payment IMPORTANT
        ^user_date      date of payment reception
        *email_body
        *email_subject
        email_to        student's email address
        *sms_body
        sms_to          student's mobile number
    
    * = hardcoded parameters
    ^ = received parameters in POST
    i have two options:
        1. call this script with already provided values
        2. fetch the data from database
        3. hybrid of the above
*/
$user_amount = strval(intval($_POST['receipt_amount'])+intval($_POST['zabihat']));
$user_thali = $_POST['receipt_thali'];
$user_receipt = $_POST['receipt_number'];
$user_date = $_POST['receipt_date'];
$sql = mysqli_query($link,"SELECT NAME, Email_ID, CONTACT from thalilist where Thali='".$user_thali."'");
$row = mysqli_fetch_row($sql);
$user_name = $row[0];
// $email_to = $row[1];
// $email_subject = "Hub Receipt";
// $email_body =   "Salaam,<br>".
//                 "<br>".
//                 "Mubarak for contributing Rs. $user_amount for hub towards Faiz ul Mawaid il Burhaniyah and gaining the sawaab of Itaam ut Taam. Moula nu ehsaan che ke apne jamarwa maa shaamil kare che. Khuda Moula (TUS) ne baaqi raakhe.<br>".
//                 "<br>".
//                 "(Name: $user_name, Thaali #: $user_thali, Receipt #: $user_receipt, Paid on: $user_date)";
$sms_to = $row[2];
$sms_body = "Mubarak for earning sawab by participating in Faiz Jaman. Moula nu ehsan chhe ke apne jamarwa ma shamil kare chhe. Hub $user_amount/Thali $user_thali/Receipt $user_receipt";
// try {
//     $mandrill = new Mandrill('BWDHEoe1pGlJ9yiH5xvUGw');
//     $message = array(
//         'html' => $email_body,
//         'subject' => $email_subject,
//         'from_email' => 'admin@faizstudents.com',
//         'to' => array(
//             array(
//                 'email' => "help@faizstudents.com"
//                  ),
//             array(
//                 'email' => $email_to
//                  )
//            )
//      );
//     $result = $mandrill->messages->send($message);
    /*
    var_dump($result);
    array (size=2)
      0 => 
        array (size=4)
          'email' => string 'murtraja@gmail.com' (length=18)
          'status' => string 'sent' (length=4)
          '_id' => string '5f375cb379434190b13552cd203323d0' (length=32)
          'reject_reason' => null
      1 => 
        array (size=4)
          'email' => string 'murtaza52@gmail.com' (length=19)
          'status' => string 'sent' (length=4)
          '_id' => string '4d0dece31483492f81d9317348b5e029' (length=32)
          'reject_reason' => null
    */
    $sms_body = urlencode($sms_body);
    $result = file_get_contents("https://sms1.almasaarr.com/sendhttp.php?authkey=$smsauthkey&mobiles=$sms_to&message=$sms_body&sender=FAIZST&route=Template");
} catch(Mandrill_Error $e) {
    echo 'A mandrill error occurred: ' . get_class($e) . ' - ' . $e->getMessage();
    throw $e;
}
?>