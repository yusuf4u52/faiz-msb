<?php
require 'credentials.php';
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    try {
        $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        /*
        i want to filter records based on transporter
        but how do i know that how many transporters are there
        and what are their names?
        the query below gives me just that
        the problem is that if i have entries in transporter like
        "Aziz bhai" and "Azizbhai"
        then they will be treated as different transporters, therefore,
        i request the faiz team to please be strict in entering transporter details
        */
        $stmt = $conn->prepare("SELECT distinct Transporter from thalilist where Active=1"); 
        $stmt->execute();
        $stmt = $stmt->fetchAll();
    }
    catch(PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
    $conn = null;
    /*
    this variable takes care of creating checkboxes for transporter filter
    note: if there are transporter fields having null values, then it displays nothing in label
    */
    $checkbox_html = "";
    //var_dump($stmt);
    for($i=0; $i<count($stmt); $i++)
    {
        $val = $stmt[$i][0];
        $checkbox_html = $checkbox_html."\t<label><input type='checkbox' name = 'transporters[]' value='$val'/>$val</label>\n"; 
    }
    $checkbox_html.="\t<br>\n";
?>
<!DOCTYPE html>
<html>
   <head>
       <title> SMS filtering </title>
       <style type='text/css'>
       .highlight{
            background-color: #FFCF8B
        }
        table{
            border-collapse: collapse;
        }
        td{
            padding: 5px;
        }
        tbody#recipientTableBody tr:hover {
            background-color: #FFCF8B;
            font-weight: bold;
        }
       </style>
       <script type='text/javascript' src = 'https://code.jquery.com/jquery-2.2.0.min.js'></script>
       <script src="jquery.jqEasyCharCounter.min.js" type="text/javascript"></script>
       <script type='text/javascript'>
            $(document).ready(function(){
                $.getScript("filter.js");
                $.getScript("selection.js");
                
                $('.countable2').jqEasyCounter({
                    'maxChars': 1000,
                    'maxCharsWarning': 145
                });

                $('#submit').click(function(){
                    //console.log("clicked");
                    // sure = confirm("Are you sure?");
                    // if(!sure) return;
                    selected = getSelected();
                    message = $('#message').val();
                    //console.log(message);
                    redirect = 'send.php';
                    console.log(JSON.stringify(selected));
                    $.redirectPost(redirect, {"message":message, "records":JSON.stringify(selected)});
                }); 

                // jquery extend function
                $.extend(
                {
                    redirectPost: function(location, args)
                    {
                        var form = '';
                        $.each( args, function( key, value ) {
                            form += "<input type='hidden' name='"+key+"' value='"+value+"'>";
                        });
                        form = '<form action="'+location+'" method="POST">'+form+'</form>';
                        console.log(form);
                        $(form).appendTo('body').submit();
                    }
                });
            
            });
       </script>
    </head>
    <body>

        <textarea name="message" style="height:150px; width:400px" class="countable2" id="message"></textarea>
        <!-- <br> -->
        <select id="holder">
            <option value="<THALINO>">Thali Number</option>
            <option value="<NAME>">Name</option>
            <option value="<AMOUNT>">Amount</option>
        </select>
        <input type="button" name="add" value="Add" onClick='document.getElementById("message").value += document.getElementById("holder").value;'>
        <input type="button" id="submit" value="Send Message">

        <p> Apply filtering on amount to select the recipients</p>
        <input type = 'text' id = 'amount_param2' value = '0' hidden />
        <select id='amount_operator'>
          <option value="none">None</option>
          <option value="<">Less than</option>
          <option value="<=">Less than or equal to</option>
          <option value="=">Equal to</option>
          <option value=">=">Greater than or equal to</option>
          <option value=">">Greater than</option>
          <option value="between">Between</option>
        </select>
        <input type='text' id = 'amount_param' value='0' hidden /><br>

        <p> Apply filtering on transporter </p>
        <select id='transporter_operator'>
            <option value = "none">None</option>
            <option value = "in">Equal to</option>
            <option value = "not in"> Not equal to</option>
        </select>
        <div id='transporter_param' style="display:inline" >
    <?php
    echo $checkbox_html;
    ?>
        </div>
        <br>
        <button id='filterButton'>Filter</button>
        <br>
        <div id ='selectionButtons' hidden>
        <input id = "b_toggle" type="button" value = "toggle"/>
        <input id = "b_all" type="button" value = "select all"/>
        <input id = "b_none" type = "button" value = "select none"/>
        </div>
        <p id = 'query_status'></p>
        <p id='selection_status'></p>
        <table style='' id = 'recipientTable'>
        <thead>
            <tr><th>#</th><th>Thali No.</th><th>Name</th><th>Mob No.</th><th>Transporter</th><th>Amount</th></tr>
        </thead>
        <tbody id = 'recipientTableBody'>
        </tbody>
        </table>
    </body>
</html>

<?php
}
else{
    try {
        $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    // set the PDO error mode to exception
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    //echo "Connected successfully"; 
    }
    catch(PDOException $e)
    {
        echo "Connection failed: " . $e->getMessage();
    //return;
    }
    $query = "SELECT Thali, NAME, CONTACT, Transporter, Total_Pending from thalilist where Active=1 and CONTACT is not null and ";
    $condition = "1=1";
    $amount_operator = $_REQUEST['amount_operator'];
    $amount_param = $_REQUEST['amount_param'];
    $amount_param2 = $_REQUEST['amount_param2'];
    $transporter_operator = $_REQUEST['transporter_operator'];
    $transporter_param = $_REQUEST['transporter_param']; // this will be an array
    //var_dump( $transporter_param); returns zero length string
    $field_amount = "Total_Pending";
    $field_transporter = "Transporter";
    switch($amount_operator)
    {
        case ">":
        case ">=":
        case "<":
        case "<=":
        case "=":
            $condition = $field_amount." ".$amount_operator." ".$amount_param;
        break;
        case "between":
            $condition = $field_amount." ".$amount_operator." ".$amount_param2." and ".$amount_param;
        break;
    }
    $query = $query.$condition;
    if(strlen($transporter_param) != 0)
    {
        $query = $query." and ";
        $condition = "1=1";
        switch($transporter_operator)
        {
            case 'in':
            case 'not in':
                $condition = $field_transporter." ".$transporter_operator." (".$transporter_param.")";
            break;
        }
        $query = $query.$condition;
    }
    //echo "\n\nfinal sql string = ".$query."\n\n";
    try{
        $stmt = $conn->prepare($query);
        //$stmt->debugDumpParams();
        $stmt->execute();

        // set the resulting array to associative
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    catch(PDOException $e)
    {
        echo "error ".$e->getMessage();
    }
    //print_r( $result);
    $result2 = array(
        'result' => 'success',
        'query' => $query,
        'data' => $result);
    //echo print_r($result2);
    $result_json = json_encode($result2);
    echo $result_json;

    
    $conn = null;
}
?>
