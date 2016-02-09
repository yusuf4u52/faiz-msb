<?php
/*
salaam <NAME>, your thali #<THALINO> has outstanding amount of Rs. <AMOUNT>. please pay
*/
require 'credentials.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $records_raw = $_REQUEST['records'];
    $records = json_decode($records_raw, true);
    $message_raw = $_REQUEST['message'];
    //var_dump($records);
    // now begin by changing placeholders
    $apis = array();
    foreach($records as $record)
    {
        //extract($record);
        $number = $record['contact'];
        $thali = $record['thali'];
        $name = $record['name'];
        $amount = $record['amount'];
        $message_formatted = str_replace(array("<THALINO>","<NAME>","<AMOUNT>"),array($thali,$name,$amount),$message_raw);
        $message = urlencode($message_formatted);
        $sms_api_url = "http://sms.myn2p.com/sendhttp.php?user=mustafamnr&password=$smspassword&mobiles=$number&message=$message&sender=FAIZST&route=Template";
        //$sms_api_url = "http://murtazafaizstudent.pythonanywhere.com/sendhttp.php?user=mustafamnr&password=$smspassword&mobiles=$number&message=$message&sender=FAIZST&route=Template";
        array_push($apis,$sms_api_url);

    }
    //echo json_encode($apis);
?>
<!DOCTYPE html>
<html>
<head>
    <title>Send Message</title>
    <script src = 'https://code.jquery.com/jquery-2.2.0.min.js'></script>
    <script type = 'text/javascript'>
    $(document).ready(function(){
        var urls = <?php echo json_encode($apis) ?>;
        var index = 0;
        var sid;
        var success_fun = function(result){
            console.log("result");
            console.log(result);
            updateStatus(result);
            updateStatus("sent");
        }
        var sendSms = function(url){
            url = urls[index];
            updateStatus("sending message for index: "+index);
            $.ajax({
                url: url,
                type: "GET",
                success: success_fun,
                crossDomain:true,
                });
            index=index + 1;
            if(index>=urls.length)
            {
                clearInterval(sid);
                updateStatus("stopped timer");
                index = 0;
            }
        }
        $('#setTime').click(function(){
            time = parseInt($('#time').val());
            updateStatus("started timer! total records: "+urls.length+" and approx time: "+(time*urls.length)+"ms");
            sid = setInterval(sendSms, time);            
        });
        var updateStatus = function(status){
            $("#status").append("<li>"+status+"</li>");
        }
    });
    </script>
</head>
<body>
Time interval between each SMS:<input type='text' id='time' value = "0"/>milliseconds (1000ms = 1s)
<br>
<input type='button' id='setTime' value="start sending" />
<ul id='status'></ul>
</body>
</html>
<?php
}
?>