<?php
// Method: POST, PUT, GET etc
// Data: array("param" => "value") ==> index.php?param=value

function CallAPI($itsid)
{	
	$opts = array(
	  'http'=>array(
	    'method'=>"GET",
	    'header'=>"Authorization: Basic ZmFpei1zdGF0aWM6ZkAhelN0YXRpYw=="
	  )
	);
	$context = stream_context_create($opts);
	// Open the file using the HTTP headers set above
	$result = file_get_contents("https://www.talimalquran.com/faiz-static/its?itsId=".$itsId, false, $context);

	$details = array(
	  'its_id'=> strval($json[itsId]),
	  'name'=> strval($json[name]),
	  'jamaat'=> strval($json[jamaat])
	);
	// for testing
	//echo $details[its_id];
	//echo $details[name];
	//echo $details[jamaat];

	return $details;
}
?>
