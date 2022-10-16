<?php

require_once "../users/_credentials.php";
require_once "../users/common.php";
require_once "../users/connection.php";

function printVariable($text, $variable) {
    error_log($text);
    error_log(var_export($variable, true));
}

function getChatId($message) {
    return $message->chat->id;
}

function sendMessage($params) {
    global $bot_token;
    $API_URL = 'https://api.telegram.org/bot'.$bot_token.'/';
    $sendMessageUrl = $API_URL.'sendMessage?'.http_build_query($params);
    error_log('sendMessageUrl:'.$sendMessageUrl);
    $response = doGet($sendMessageUrl, array());
    if(!$response || $response['code'] !== 200) {
        $error = error_get_last();
        printVariable("sendMessage error", $error);
        // error_log($error['message']);
    }
    printVariable("sendMessage response", $response);
}

function sendTextMessage($chatId, $text, $markdown=false, $html=false) {
    $params = array(
        "chat_id" => $chatId,
        "text" => $text,
    );
    if ($markdown) {
        $params['parse_mode'] = 'MarkdownV2';
    }
    if ($html) {
        $params['parse_mode'] = 'HTML';
    }
    sendMessage($params);
}

function getMobile($chatId) {
    global $link;
    $chatId = (string) $chatId;
    $sql = "select * from telegram_user where chat_id=$chatId";
    $result = mysqli_query($link, $sql);
    $row = mysqli_fetch_assoc($result);
    if(!$row) {
        return false;
    }
    return $row['mob_no'];
}

function storeMobile($chatId, $mobile) {
    global $link;
    $chatId = (string) $chatId;
    $mobile = (string) $mobile;
    $result = getMobile($chatId);
    if($result !== false) {
        error_log("$chatId:$mobile already exists in db.");
        return false;
    }
    $sql = "insert into telegram_user values('$chatId', 1, '$mobile')";
    $result = mysqli_query($link, $sql);
    if(!$result) {
        $error = error_get_last();
        printVariable("storeMobile error", $error);
        return false;
    }
    return true;
}

function sendPhoneNumberRequest($chatId) {
    $keyboard = array(array(array(
        "text" => "Send phone number",
        "request_contact" => true
    )));

    $replyMarkup = array(
        "one_time_keyboard" => true,
        "keyboard" => $keyboard
    );

    $params = array(
        "chat_id" => $chatId,
        "text" => "Please click on send phone number",
        "reply_markup" => json_encode($replyMarkup)
    );
    sendMessage($params);
}

function receivePhoneNumber($chatId, $contact) {
    $mobile = $contact->phone_number;
    $result = storeMobile($chatId, $mobile);
    if($result) {
        sendTextMessage($chatId, "Thank you for your number ".$mobile);
    } else {
        sendTextMessage($chatId, "Couldn't update your number: ".$mobile);
    }
}

function sendInvalidNumberMessage($chatId, $word) {
    $message = $word." is not a valid number. Please enter a valid number.";
    sendTextMessage($chatId, $message);
}

function isValidNumber($input) {
    if ($input[0] == '-') {
        return false;
    }
    return ctype_digit($input);
}


function getServerReply($data) {
    $url = 'https://faizstudents.com/users/_payhoob.php';

    // use key 'http' even if you send the request to https
    $headers = array(
        "Content-type: application/x-www-form-urlencoded",
        "User-Agent: Googlebot/2.1 (+http://www.googlebot.com/bot.html)"
    );
    $options = array(
        'http' => array(
            'header'  => $headers,
            'method'  => 'POST',
            'content' => http_build_query($data)
        )
    );
    $context  = stream_context_create($options);
    $result = file_get_contents($url, false, $context);
    if ($result === FALSE) { 
        /* Handle error */ 
        error_log("There was an error while posting to server");
        return "ERROR";
    }
    error_log("server response: ".$result);
    return $result;
}

function getThaliDetailsFromServer($thali) {
    global $faiz_api_key;

    $data = array(
        'thalino' => $thali,
        'api_key' => $faiz_api_key
    );
    $params = http_build_query($data);
    $url = "https://faizstudents.com/users/_fetch_thali_details.php?$params";
    $result = doGet($url, array());
    if (!$result || $result['code'] !== 200) { 
        /* Handle error */ 
        error_log("There was an error while posting to server");
        return array('error' => "Couldn't post the request to server");;
    }
    $result_json = $result['data'];
    printVariable("server thali response: ", $result_json);
    // if($result === 'null') {
    //     return array('error' => "Thali $thali doesn't exist or there's an unknown error");
    // }

    // $result_json = json_decode($result, true);
    // if($result_json === null) {
    //     return array('error' => "Error: ".$result);
    // }

    $active = $result_json['Active'];
    if ($active === '0') {
        $result_json['Active'] = 'Stopped';
    } else if($active === '1') {
        $result_json['Active'] = 'Started';
    } else {
        $result_json['Active'] = 'Unknown';
    }

    return $result_json;
}

function sendInvalidReceiptTypeMessage($chatId, $word) {
    $message = $word." is not a valid receipt type. Enter either cash or bank.";
    sendTextMessage($chatId, $message);
}

function isValidReceiptType($word) {
    $word_lower = strtolower($word);
    if ($word_lower === 'cash' || $word_lower === 'bank') {
        return true;
    }
    return false;
}