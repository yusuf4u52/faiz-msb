<?php
// Method: POST, PUT, GET etc
// Data: array("param" => "value") ==> index.php?param=value

function CallAPI($itsid)
{	
	$result = file_get_contents("http://13.82.146.207:8085/user?itsid=".$itsid);
    return json_decode($result,true);
}
?>