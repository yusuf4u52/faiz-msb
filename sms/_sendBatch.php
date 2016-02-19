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
    $post_url = "http://sms.myn2p.com/api/postsms.php";
    $message_node = new SimpleXMLElement('<MESSAGE/>');
    $message_node->addChild('AUTHKEY', $smsauthkey);
    $message_node->addChild("SENDER", 'FAIZST');
    foreach($records as $record)
    {
        //extract($record);
        $number = $record['contact'];
        $thali = $record['thali'];
        $name = $record['name'];
        $names = explode(" ", $name, 3);
        $name = $names[0];
        if (strlen($name)<=3)
        {
            //this is not a name, but some title, therefore,
            $name = $name + $names[1];
        }
        $amount = $record['amount'];
        $message_formatted = str_replace(array("<THALI>","<NAME>","<AMOUNT>"),array($thali,$name,$amount),$message_raw);
        $sms_node = $message_node->addChild("SMS");
        $sms_node->addAttribute("TEXT", $message_formatted);
        $address_node = $sms_node->addChild("ADDRESS");
        $address_node->addAttribute("TO", $number); 
    }
    $as_xml = $message_node -> asXML();
    $as_xml = explode("\n", $as_xml, 2)[1];
    $xml = urlencode($as_xml);
    //echo $xml;
    //the code to actually send it and getting the response goes here:
    $response = file_get_contents($post_url."?data=".$xml);
    echo $response;
}
// so i tested this using just two sms, one destined to myself and
// the other destined to yusuf bhai, who acknowledged the receipt
// of the message. however i frowned upon the output given to me by
// sms.myn2p.com, it was not user friendly at all
// 3662736f4356363536303330
// so i am required to "split" the response into chunks of 12 characters
// will do that later
?>