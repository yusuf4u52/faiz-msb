<?php
require '_credentials.php';
$balance = file_get_contents("http://sms1.almasaarr.com/api/balance.php?authkey=$smsauthkey&type=TEMPLATE");
echo trim($balance);
?>