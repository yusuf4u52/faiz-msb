<?php
require_once "utils.php";
require_once "../sms/_credentials.php";
require_once "../users/common.php";

if($_SERVER['REQUEST_METHOD'] === 'POST') {
    
    $input = json_decode( file_get_contents( 'php://input' ) );
    printVariable("Input:", $input);

    $message = $input->message;
    
    $chatId = getChatId($message);
    printVariable("Chat Id:", $chatId);
    
    $mobile = getMobile($chatId);
    if($mobile === false) {
        handleAuthentication($message);
        exit();
    }
    handleMessage($message, $mobile);
}

function handleAuthentication($message) {
    $chatId = getChatId($message);
    $contact = $message->contact;
    if($contact) {
        receivePhoneNumber($chatId, $contact);
        return;
    }
    sendPhoneNumberRequest($chatId);
}

function handleMessage($message, $mobile) {
    $chatId = getChatId($message);
    $userInput = $message->text;
    $userInputArgs = explode(" ", $userInput);
    $countInputArgs = sizeof($userInputArgs);
    if($countInputArgs === 3 || $countInputArgs === 4) {
        $word = $userInputArgs[0];
        if(!isValidNumber($word)) {
            sendInvalidNumberMessage($chatId, $word);
            return;
        }
        $thali = $word;
        $word = $userInputArgs[1];
        if(!isValidNumber($word)) {
            sendInvalidNumberMessage($chatId, $word);
            return;
        }
        $amount = $word;

        $word = strtolower($userInputArgs[2]);
        if(!isValidReceiptType($word)) {
            sendInvalidReceiptTypeMessage($chatId, $word);
            return;
        }
        $receipt_type = $word;

        $postParams = array(
            "receipt_thali" =>  $thali,
            "receipt_amount" => $amount,
            "mobile" => $mobile,
            "payment" => ucfirst($receipt_type), # 'Cash' or 'Bank'
        );
        if($receipt_type == 'bank') {
            if ($countInputArgs !== 4) {
                sendTextMessage($chatId, "Please provide transaction id also. <thali> <amount> bank <tran id>");
                return;
            }
            $postParams["transaction_id"] = $userInputArgs[3];
        }
        $response = getServerReply($postParams);
        sendTextMessage($chatId, $response);
    } elseif (sizeof($userInputArgs) === 1) {
        $word = $userInputArgs[0];
        if(!isValidNumber($word)) {
            sendInvalidNumberMessage($chatId, $word);
            return;
        }
        $thali = $word;
        $result = getThaliDetailsFromServer($thali);
        if(array_key_exists('error', $result)) {
            $error = $result['error'];
            sendTextMessage($chatId, $error);
            return;
        }
        $name               = $result['NAME'];
        $mobile_no          = $result['CONTACT'];
        $active             = $result['Active'];
        $transporter        = $result['Transporter'];
        $address            = $result['Full_Address'];
        $prev_year_pending  = $result['Previous_Due'];
        $cur_year_takhmeen  = $result['yearly_hub'];
        $paid               = $result['Paid'];
        $pending            = $result['Total_Pending'];
        $content = <<<CONTENT
<b>Thali No.:</b> $thali

<b>Name:</b> $name

<b>Mob No.:</b> $mobile_no

<b>Status:</b> $active

<b>Transporter:</b> $transporter

<b>Address:</b> <tg-spoiler>$address</tg-spoiler>

<b>Prev year pending:</b> ₹$prev_year_pending

<b>Cur year takhmeen:</b> ₹$cur_year_takhmeen

<b>Paid:</b> ₹$paid

<b>Total pending:</b> ₹$pending

CONTENT;
        sendTextMessage($chatId, $content, false, true);
    } else {
        sendTextMessage($chatId, "Invalid number of arguments received. Should be either 3 or 4.");
    }
}
