<?php
function sendEmail($to, $subject, $msg, $attachment, $attachmentObj = null, $addTransporter = false)
{
	require '../vendor/autoload.php';
	require '../sms/_credentials.php';

	$email = new \SendGrid\Mail\Mail();
	$email->setFrom("no-reply@faizstudents.com", "FMB (MSB)");
	$email->setSubject($subject);
	$email->addTo($to);

	if ($addTransporter) {
		$email->addTo("mohammedizzy@msbinstitute.com");
		$email->addTo("yusuf4u52@gmail.com");
		$email->addTo("punemasool@msbinstitute.com");
	}

	$email->addContent(
		"text/html",
		$msg
	);

	if ($attachmentObj) {
		foreach ($attachmentObj as $value) {
			$email->addAttachment($value);
		}
	}

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
		echo 'Caught exception: ' . $e->getMessage() . "\n";
	}
}
