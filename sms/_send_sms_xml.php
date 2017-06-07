<?php 
//assuming _credentials.php is already included by the file which is including this file
// this function sends the SMS, everything is hardcoded, the return value is the value returned
// from the XML api call
function send_sms_to_records($conn, $message) {
	require '_credentials.php';
	$send_url = "http://sms.myn2p.com/api/postsms.php";
	//$conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
	//$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	$message_raw = $message;
	$qAmount = "total_pending";
	$qThali = "Thali";
	$qName = "NAME";
	$qContact = "CONTACT";
	$qGender = "Gender";
	//$query = "SELECT $qThali, $qName, $qContact, $qAmount from $tablename where ($qContact is not null and $qAmount>0) or Thali=306";
	$query = "SELECT $qThali, $qName, $qContact, $qAmount, $qGender from $tablename where $qAmount>0 and $qThali is not null and $qContact is not null";
	echo $query;
	$stmt = $conn->prepare($query);
	$stmt->execute();

	// set the resulting array to associative
	$result = $stmt->fetchAll(PDO::FETCH_ASSOC);
	print_r(sizeOf($result));
	echo "<hr>";
	$message_node = new SimpleXMLElement('<MESSAGE/>');
	$message_node->addChild('AUTHKEY', $smsauthkey);
	$message_node->addChild("SENDER", 'FAIZST');
	foreach($result as $record)
	{
	    //extract($record);
	    $number = $record[$qContact];
	    $gender = $record[$qGender];
	    $suffix = "bhai";
	    if($gender == "Female") {
	    	$suffix = "ben";
	    }
	    $thali = $record[$qThali];
	    $name = $record[$qName];
	    $names = explode(" ", $name, 3);
	    $name = $names[0];
	    if (strlen($name)<=3)
	    {
	        //this is not a name, but some title, therefore,
	        $name = $name.$names[1];
	    }
	    $amount = $record[$qAmount];
	    $message_formatted = str_replace(array("<TN>","<NAME>","<AMO>", "<SUF>"),array($thali,$name,$amount, $suffix),$message_raw);
	    echo $message_formatted;
	    $sms_node = $message_node->addChild("SMS");
	    $sms_node->addAttribute("TEXT", $message_formatted);
	    $address_node = $sms_node->addChild("ADDRESS");
	    $address_node->addAttribute("TO", $number); 
	}
	$as_xml = $message_node -> asXML();
	$as_xml = explode("\n", $as_xml, 2)[1];
	echo "<xmp>".$as_xml."</xmp>";

	//now post this code to validate and display result
	$data = array('data' => $as_xml);

	// use key 'http' even if you send the request to https://...
	$options = array(
	    'http' => array(
	        'header'  => "Content-type: application/x-www-form-urlencoded\r\n",
	        'method'  => 'POST',
	        'content' => http_build_query($data)
	    )
	);
	$context  = stream_context_create($options);
	//$result = file_get_contents($send_url, false, $context);
	if ($result === FALSE) { /* Handle error */ echo "error in validating the xml api";}
	// sample result 376667677537333438353234
	// executing time was around 3 seconds
	var_dump($result);
	echo "<hr/>";
	print_r($result);

	return $result;
}

?>