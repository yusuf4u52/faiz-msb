<?php

// Method: POST, PUT, GET etc
// Data: array("param" => "value") ==> index.php?param=value
function CallAPI($itsid,$header,$its_url)
{	
	$opts = array(
	  'http'=>array(
	    'method'=>"GET",
	    'header'=>$header
	  )
	);
	$context = stream_context_create($opts);
	// Open the file using the HTTP headers set above
	$result = file_get_contents($its_url.$itsid, false, $context);
	return json_decode($result,true);
}
?>