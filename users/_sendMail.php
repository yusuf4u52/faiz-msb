<?php

function sendEmail($to, $subject, $msg, $attachment) {
	require '../vendor/autoload.php'; 
	require '../sms/_credentials.php';

	$email = new \SendGrid\Mail\Mail(); 
	$email->setFrom("no-reply@faizstudents.com", "FMB (Poona Students)");
	$email->setSubject($subject);
	$email->addTo($to);
	$email->addCc("help@faizstudents.com");
	$email->addContent(
	    "text/html", $msg
	);

	if ($attachment != null) {
		$attach = new \SendGrid\Mail\Attachment();
	    $attach->setContent(base64_encode($attachment));
	    $attach->setType("application/text");
	    $attach->setFilename("backup.sql");
	    $attach->setDisposition("attachment");
	    $attach->setContentId("Database Backup");
	    $email->addAttachment($attach);
	}

	$sendgrid = new \SendGrid($SENDGRID_API_KEY);
	try {
	    $sendgrid->send($email);
	} catch (Exception $e) {
	    echo 'Caught exception: '. $e->getMessage() ."\n";
	}
}

?>