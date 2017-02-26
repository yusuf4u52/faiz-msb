<?php
/*
salaam <NAME>, your thali #<THALINO> has outstanding amount of Rs. <AMOUNT>. please pay

it takes around 5 seconds to send telegram messages for 10 people
therefore in one second 2 people receive the message
the above observations were taken for murtazafaizstudent.pythonanywhere.com domain
for sms.myn2p, the delay will be more
*/
require '_credentials.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $records_raw = $_REQUEST['records'];
    $records = json_decode($records_raw, true);
    $message_raw = $_REQUEST['message'];
    //var_dump($records);
    // now begin by changing placeholders
    $params = array();
    foreach($records as $record)
    {
        //extract($record);
        $number = $record['contact'];
        $thali = $record['thali'];
        $name = $record['name'];
        $names = explode(" ", $name, 3);
        $name = $names[0].$names[1];
        $amount = $record['amount'];
        $message_formatted = str_replace(array("<THALI>","<NAME>","<AMOUNT>"),array($thali,$name,$amount),$message_raw);
        $message = urlencode($message_formatted);
        $param = "user=mustafamnr&password=$smspassword&mobiles=$number&message=$message&sender=FAIZST&route=Template";
        array_push($params,$param);
    }
    $data = array('result' => "success", 'params' => $params);
    echo json_encode($data);
}
?>
