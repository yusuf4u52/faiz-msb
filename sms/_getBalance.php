<?php
require '_credentials.php';
$balance = file_get_contents("http://sms.myn2p.com/api/balance.php?authkey=$smsauthkey&type=TEMPLATE");
echo trim($balance);
?>