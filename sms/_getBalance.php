<?php
require '_credentials.php';
$balance = file_get_contents("https://sms1.almasaarr.com/api/balance.php?authkey=$smsauthkey&type=TEMPLATE");
echo trim($balance);
?>