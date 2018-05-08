<?php
require '_credentials.php';
//require '../users/update_next_install.php';

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

<select multiple class="form-control hidden" id="transporter_param">
        <option>1s</option>
        <option>2d</option>
        <option>3a</option>
        <option>4f</option>
        <option>5a</option>
      </select>

    */
    $multiselect_html = "";
    //var_dump($stmt);
    for($i=0; $i<count($stmt); $i++)
    {
        $val = $stmt[$i][0];
        $multiselect_html = $multiselect_html."\t<option>$val</option>\n"; 
    }
    $root_urls = array(
        "real" => "http://sms.myn2p.com/sendhttp.php?",
        "telegram" => "http://murtazafaizstudent.pythonanywhere.com/sendhttp.php?",
        "email" => "http://murtazafaizstudent.pythonanywhere.com/sendsmtp?");
    //$multiselect_html.="\t<br>\n";
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <title>The Faiz Se3 System</title>
    <link rel="icon" href="/users/images/icon.png">
    <!-- Bootstrap -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.0.12/css/all.css" integrity="sha384-G0fIWCsCzJIMAVNQPfjH08cyYaUtMwjJwqiRKxxE/rx96Uroj1BtIQ6MLJuheaO9" crossorigin="anonymous">
    <style>
    .jumbotron {
      padding-right: 30px !important;
      padding-left: 30px !important;
    }
    .row-eq-height {
      display: -webkit-box;
      display: -webkit-flex;
      display: -ms-flexbox;
      display: flex;
    }
    .no-padded-span {
      padding: 0px !important;
    }
    .fill {
      min-height: 100%;
      height: 100%;
    }
    body{
      background-color: LightYellow
    }
    .label-as-badge {
      border-radius: 1em;
      float: right;
    }
    body { padding-bottom: 70px; }
    }
    </style>
  </head>
  <body>
    <div class="modal fade" tabindex="-1" role="dialog" id='sure_modal'>
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <h4 class="modal-title">Send SMS</h4>
          </div>
          <div class="modal-body">
            <p>This request cannot be undone. Are you absolutely sure?</p>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">Na hamna rehwado</button>
            <button type="button" class="btn btn-primary" id='send_sure' data-dismiss='modal'>Ha bhai, sure chhu.</button>
          </div>
        </div><!-- /.modal-content -->
      </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->



    <!--
      now i need to divide my page into three parts
      1. filtering
      2. selection
      3. sending
    -->
    <div class='container-fluid'>
      <div class = 'row'>
        
        <!-- ############## FILTERING ############## -->
        <div class = 'col-lg-3'>
          <div class="jumbotron text-center" id='jumbo_search'>
            <h1>Search <span class = "glyphicon glyphicon-search"></span></h1>      
            <p>Set your target recipients!</p>
          </div>
          <div class='content'>
            <!-- <div class = 'container'> -->
                <div class="form-group">
                <div class = 'text-center'><!-- <p>Add placeholders or templates </p> --><!-- <h2><span class="glyphicon glyphicon-filter" aria-hidden="true"></span></h2> --></div>
                  <div class="btn-group btn-group-justified" role="group" aria-label="...">
                    <div class="btn-group" role="group">
                      <div class="dropdown">
                        <button class="btn btn-default dropdown-toggle my-tooltip" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true" title='insert templates'>
                          Lazy
                          <span class="caret"></span>
                        </button>
                        <ul class="dropdown-menu" aria-labelledby="dropdownMenu1">
                          <li><a href='#' id='template_warning'><i class="fa fa-exclamation fa-lg fa-fw"></i>Warning</a></li>
                          <li><a href="#" id='template_urgent'><i class="fa fa-exclamation-triangle fa-lg fa-fw"></i>Urgent</a></li>
                          <li role="separator" class="divider"></li>
                          <li><a href="#" id='template_delay'><i class="fa fa-clock-o fa-lg fa-fw"></i>Delay</a></li>
                          <li><a href="#" id='template_na'>
                            <span class="fa-stack fa-lg">
                              <i class="fa fa-motorcycle fa-stack-1x"></i>
                              <i class="fa fa-ban fa-stack-2x text-danger"></i>
                            </span>
                            N/A</a></li>
                        </ul>
                      </div>
                    </div>
                    <div class="btn-group" role="group">
                      <button type="button" class="btn btn-default" data-toggle='tooltip' data-placement='top' data-original-title='<NAME>' id="placeholder_name"><i class='fa fa-user fa-lg'></i></button>
                    </div>
                    <div class="btn-group" role="group">
                      <button type="button" class="btn btn-default" data-toggle='tooltip' data-placement='top' data-original-title='<THALI>' id="placeholder_thali"><i class='fa fa-hashtag fa-lg'></i></button>
                    </div>
                    <div class="btn-group" role="group">
                      <button type="button" class="btn btn-default" data-toggle='tooltip' data-placement='top' data-original-title='<AMOUNT>' id="placeholder_amount"><i class='fa fa-usd fa-lg'></i></button>
                    </div>
                  </div>
                  <textarea class="form-control" rows="5" id="message" placeholder="Write the message here..."></textarea>                  
                </div>  
            <!-- </div> -->
            <div class = 'form-group'>
              <!-- <div class='text-center'><p>Apply filtering on amount:</p></div> -->
              <form id="amount_type_form" class='form-group'>
                <label class="radio-inline">
                  <input type="radio" name="amount_type" value="prev_install_pending">Previous Pending
                </label>
                <label class="radio-inline">
                  <input type="radio" name="amount_type" value="next_install" checked>Next Installment
                </label>
                 <label class="radio-inline">
                  <input type="radio" name="amount_type" value="Total_Pending">Total Amount
                </label>
              </form>
              <div class="btn-group btn-group-justified" role="group" aria-label="...">
                <div class="btn-group hidden" role="group">
                  <input type="text" class="form-control" value = '0' id='amount_param2'>
                </div>
                <div class="btn-group" role="group">
                  <div class='input-group'>
                    <span class="input-group-addon"><i class='fas  fa-rupee-sign fa-lg fa-fw'></i></span>
                    <select class='form-control' id='amount_operator'>
                      <option value="none">None</option>
                      <option value="<">Less than</option>
                      <option value="<=">Less than or equal to</option>
                      <option value="=">Equal to</option>
                      <option value=">=">Greater than or equal to</option>
                      <option value=">">Greater than</option>
                      <option value="between">Between</option>
                    </select>

                  </div>
                </div>
                <div class="btn-group hidden" role="group">
                  <input type="text" class="form-control" value = '0' id='amount_param'>
                </div>
              </div>
            </div>

            <div class = 'form-group'>
              <!-- <div class='text-center'><p>Apply filtering on transporter:</p></div> -->
              <div class="btn-group btn-group-justified" role="group" aria-label="...">
                <div class="btn-group hidden" role="group">
                  <input type="text" class="form-control" value = '0' id='amount_param2'>
                </div>
                <div class="btn-group" role="group">
                  <div class='input-group'>
                    <span class="input-group-addon"><i class='fa  fa-motorcycle fa-lg fa-fw'></i></span>
                    <select class='form-control' id='transporter_operator'>
                      <option value = "none">None</option>
                      <option value = "in">Equal to</option>
                      <option value = "not in"> Not equal to</option>
                    </select>
                  </div>
                  
                <select multiple class="form-control hidden" id="transporter_param">
                <?php echo $multiselect_html ?>
                </select>
                </div>
                <div class="btn-group hidden" role="group">
                  <input type="text" class="form-control" value = '0' id='amount_param'>
                </div>
              </div>
            </div>

            <div class = 'form-group'>
              <!-- added this div for active/inactive support -->
              <div class="btn-group btn-group-justified" role="group" aria-label="...">
                <div class="btn-group hidden" role="group">
                  <input type="text" class="form-control" value = '0' id='amount_param2'>
                </div>
                <div class="btn-group" role="group">
                  <div class='input-group'>
                    <span class="input-group-addon"><i class='fa fa-stop-circle fa-lg fa-fw'></i></span>
                    <select class='form-control' id='active_operator'>
                      <option value = "active">Active</option>
                      <option value = "inactive">Inactive</option>
                      <option value = "all">All</option>
                    </select>
                  </div>
                </div>
              </div>
            </div>

            <div class='form-group'>
              <div class="btn-group btn-group-justified" role="group" aria-label="...">
                <div class="btn-group" role="group">
                  <div class='input-group'>
                    <span class="input-group-addon"><i class='fas fa-graduation-cap fa-lg fa-fw'></i></span>
                    <select class='form-control' id='student_param'>
                      <option value="yes">Yes</option>
                      <option value="no">No</option>
                    </select>
                  </div>
                </div>
              </div>
            </div>

            <div class='form-group'>
              <div class="btn-group btn-group-justified" role="group" aria-label="...">
                <div class="btn-group" role="group">
                  <div class='input-group'>
                    <span class="input-group-addon"><i class='fas fa-user-tie fa-lg fa-fw'></i></span>
                    <select class='form-control' id='father_param'>
                      <option value="none">No</option>
                      <option value="indian">Indian</option>
                      <option value="foreign">Foreign</option>
                      <option value="all">All</option>
                    </select>
                  </div>
                </div>
              </div>
            </div>

            <div class='form-group'>
              <div class="btn-group btn-group-justified" role="group" aria-label="...">
                <div class="btn-group" role="group">
                  <button class='btn btn-primary btn-lg' id='filter'>Filter <span class="glyphicon glyphicon-filter" aria-hidden="true"></span><span style="float:right;"><span class="badge" id='query_status'></span></span></button>
                </div>
              </div>

            </div>

          </div>
        </div>

        <!-- ############## SELECTION ############## -->
        <div class = 'col-lg-5'>
          <div class="jumbotron text-center" id='jumbo_select'>
            <h1>Select <span class = "glyphicon glyphicon-check"></span></h1>      
            <p>Whom do you want to send SMS to?</p>
          </div>

          <div class='content'>
          <div id = 'selection_status' class="alert alert-info text-center" role="alert">Filter and then Select</div>
            <div class="btn-group btn-group-justified hidden" role="group" id='b_selection'>
              <div class="btn-group" role="group">
                <button id='b_all' type="button" class="btn btn-default" data-toggle='tooltip' data-placement='top' data-original-title='Select All'><span class="glyphicon glyphicon-ok" aria-hidden="true"></span></button>
              </div>
              <div class="btn-group" role="group">
                <button id='b_none' type="button" class="btn btn-default" data-toggle='tooltip' data-placement='top' data-original-title='Select None'><span class="glyphicon glyphicon-remove" aria-hidden="true"></span></button>
              </div>
              <div class="btn-group" role="group">
                <button id='b_toggle' type="button" class="btn btn-default" data-toggle='tooltip' data-placement='top' data-original-title='Toggle'><span class="glyphicon glyphicon-random" aria-hidden="true"></span></button>
              </div>
            </div>
            <div class='table-responsiv'> <!-- i have disabled this, non responsive is better -->
              <table class='table' id = 'recipientTable'>
                <thead>
                    <tr><th>#</th><th>Thali No.</th><th>Name</th><th>Mob No.</th><th>Transporter</th><th>Amount</th></tr>
                </thead>
                <tbody id = 'recipientTableBody'>
                </tbody>
              </table>
            </div>
          </div>
        </div>

        <!-- ############## SENDING ############## -->

        <div class = 'col-lg-4'>
          <div class="jumbotron text-center" id='jumbo_send'>
            <h1>Send <span class = "glyphicon glyphicon-send"></span></h1>      
            <p>Are you ready? If not try MOCK SEND!</p>
            
          </div>
          <div class='content'>
            <!-- <div class='form-group' id = 'balance_form_group'>
              <div class="btn-group btn-group-justified" role="group" aria-label="...">
                <div class="btn-group" role="group">
                  <button class='btn btn-info btn-lg' id='balance'>Check Balance<span style="float:right;"><span class="badge" id='balance_badge'></span></span></button>
                </div>
              </div>
            </div> -->
            <div class='form-group'>
              <div class="btn-group btn-group-justified" role="group" aria-label="...">
                <div class="btn-group hidden" role="group">
                  <input type="text" class="form-control" placeholder="Chat id or Email" id='send_param2'>
                </div>
                <div class="btn-group" role="group">
                    <button class='btn btn-info' id='balance' data-toggle='tooltip' data-placement='top' data-original-title='Check Balance' disabled="disabled">Balance</button>
                </div>
                <div class="btn-group" role="group">
                    <select class='form-control' id='send_operator'>
                      <option value="sms">SMS</option>
                      <option value="mock">MOCK</option>
                    </select>
                </div>
                  <div class="btn-group" role="group">
                    <div class='input-group'>
                      <input type="text" class="form-control" placeholder="milliseconds" value = '500' id='send_param' data-toggle='tooltip' data-original-title='Set the interval (1s = 1000ms)'>
                      <span class="input-group-addon">ms</span>
                    </div>
                  </div>
              </div>
            </div>
            <div class='form-group'>
              <div class="btn-group btn-group-justified" role="group" aria-label="...">
                <div class="btn-group" role="group">
                  <button class='btn btn-danger btn-lg' id='send'>Send</button>
                </div>
              </div>

            </div>
            <div class='dontknow'>
              <ul class='list-group' id='status'></ul>
            </div>

          </div>
        </div>




       </div>

     </div>
     <nav class="navbar navbar-default navbar-fixed-bottom hidden-lg">
      <div class="container-fluid">
        <div class="navbar-header">
          <a class='pull-left' href="#">
            <img alt="Brand" src="fmb.jpg" height='50px'>
          </a>
          <a href="#jumbo_search" class='navbar-brand'>
            Search
          </a>
          <a href="#jumbo_select" class='navbar-brand'>
            Select
          </a>
          <a href="#jumbo_send" class='navbar-brand'>
            Send
          </a>
        </div>
      </div>
    </nav>
    
    <!-- Latest compiled and minified CSS -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>

    <!-- Latest compiled and minified JavaScript -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js" integrity="sha384-0mSbJDEHialfmuBBQP6A4Qrprq5OVfW37PRR3j5ELqxss1yVqOtnepnHVP9aJ7xS" crossorigin="anonymous"></script>
    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="jquery.jqEasyCharCounter.min.js" type="text/javascript"></script>
    <script type="text/javascript">
      $(document).ready(function(){
        $('[data-toggle="tooltip"]').tooltip();
        $('.my-tooltip').tooltip();

        var rootUrls = <?php echo json_encode($root_urls) ?>;
        var params = null;
        var sid;
        var index=0;
        var defaultUrl = rootUrls["real"];
        var extra = "";
        var selected = null;
        $.getScript("filter.js");
        $.getScript("selection.js");
        $('#send_operator').change(function(){
          switch($(this).val())
          {
            case 'sms':
              $('#send_param2').parent().addClass("hidden");
              $('#send_param').parent().removeClass("hidden");
              $("#balance").parent().removeClass("hidden");
            break;
            case 'mock':
              $('#send_param2').parent().removeClass("hidden");
              $('#send_param').parent().removeClass("hidden");
              $("#balance").parent().addClass("hidden");
            break;
            // default:
            //   $("#send_param").parent().addClass("hidden");
            //   $("#send_param2").parent().addClass("hidden");
          }

        });
        $("#send").on('click', function(){
          selected = getSelected();
          selectedRecords = JSON.stringify(getSelected());
          timeInterval = $("#send_param").val();
          message = $('#message').val();
          requestObj = $.post("send.php", { 
            records: selectedRecords,
            message: message
          });
          requestObj.done(function(data){
            var json = null;
            try{
              json = JSON.parse(data);
            }catch(err){
              document.write(data);
              return;
            }
            if(json['result'] == "success"){
              params = json['params'];
              //now our usual logic will go here!
              timeInterval = parseInt($("#send_param").val());
              //check what we are sending here?
              if($("#send_operator").val()=='sms'){
                $("#sure_modal").modal();
              }
              else{
                // this is a mock message, validate the input first
                var mock_param = $("#send_param2").val();
                if(mock_param.match("^[+-]?\\d+$") != null)
                {
                    console.log("number");
                    extra = "&chatid="+mock_param;
                    url = rootUrls['telegram'];
                }
                else if(mock_param.match("^[\\w.]+@[\\w.]+$"))
                {
                    console.log("email");
                    extra = "&email="+mock_param;
                    url = rootUrls['email'];
                }
                else{
                    alert("Invalid input! either enter a telegram chat id or an email address");
                    return;
                }
                $("#status").html("");
                updateStatus("started timer! total records: "+params.length+" and approx time: "+(timeInterval*params.length/1000)+"s", -1);
                sid = setInterval(sendSms.bind(null, url, extra), timeInterval); 

              }
            }
            else {
              alert("there was some error in retrieving the urls");
            }
          });
        });

        $("#send_sure").on('click', function(){
          extra = "&chatid=163349099";
          timeInterval = parseInt($("#send_param").val());
          $("#status").html("");
          updateStatus("started timer! total records: "+params.length+" and approx time: "+(timeInterval*params.length/1000)+"s", -1);
          sid = setInterval(sendSms.bind(null, defaultUrl, extra), timeInterval);  
        })

        var sendSms = function(gateway, extra){
            url = gateway+params[index]+extra;
            // console.log("url");
            //console.log(url);
            //console.log(extra);
            name_field = selected[index]['name'];
            number_field = selected[index]['contact'];
            updateStatus("("+(index+1)+") sending message to "+name_field+" on "+number_field, index);
            $.ajax({
                url: url,
                beforeSend: function(jqxhr, settings) {
                    jqxhr.name_field = name_field;
                    jqxhr.number_field = number_field;
                    jqxhr.index_field = index;
                },
                type: "GET",
                complete: function(e) {
                    // updateStatus("<b>sent to "+e.name_field+" on "+e.number_field +"</b>", e.index_field);
                    updateStatus(' <span class="label label-success label-as-badge"><i class="fa fa-check fa-lg"></i></span>', e.index_field);
                },
                crossDomain:true,
                error: function(xhrobj, status, text){
                  console.log(xhrobj);
                  //console.log(xhrobj.responseText);
                  console.log(status);
                  //console.log(text);
                }
                });
            index=index + 1;
            if(index>=params.length)
            {
                clearInterval(sid);
                updateStatus("stopped timer", -1);
                index = 0;
                updateBalance();
            }
        }

        var updateStatus = function(status, index){
            //console.log("updateStatus was called with "+status+" "+index);
            className='list-group-item';
            if(index < 0)
            {
                $("#status").append("<li class='"+className+"''>"+status+"</li>");
                return;
            }
            var li = $("#status li.classSent"+index);
            // console.log("li length");
            // console.log(li.length);
            if(li.length) 
                li.append(status);
            else {
                $("#status").append("<li class = 'classSent"+index+" "+className+"' >"+status+"</li>");
            }          
        }
        var updateBalance = function() {
          $.get("_getBalance.php", function(data) {
              $("#balance").html("<strong>Bal: </strong>"+data);
            });
        }
        updateBalance();
      });
    </script>
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
    $amount_type = $_REQUEST['amount_type'];
    if($amount_type == "Total_Pending"){
      $amount_type = "(Previous_Due + Dues + yearly_hub + Zabihat + Reg_Fee + TranspFee - Paid)";
    }

    $amount_operator = $_REQUEST['amount_operator'];
    $amount_param = $_REQUEST['amount_param'];
    $amount_param2 = $_REQUEST['amount_param2'];

    $transporter_operator = $_REQUEST['transporter_operator'];
    $transporter_param = $_REQUEST['transporter_param'];
    $field_transporter = "Transporter";

    $student_param = $_REQUEST['student_param'];
    $father_param = $_REQUEST['father_param'];
    $field_studentNo = "CONTACT";
    $field_fatherNo = "fathersNo";

    $active_operator = $_REQUEST['active_operator'];
    $field_amount = $amount_type;
    
    $query = "SELECT Thali, NAME, $field_studentNo, $field_transporter, $amount_type, $field_fatherNo from thalilist where CONTACT is not null and ";
    $condition = "1=1";

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
    $query = $query." and Active in ";
    $condition = "";
    switch($active_operator) {
      case "active":
        $condition = '("1")';
        break;
      case "inactive":
        $condition = '("0")';
        break;
      case "all":
        $condition = '("1", "0")';
    }
    $query = $query.$condition;

    switch($student_param) {
      case "yes":
      break;
      case "no":
      break;
    }

    //echo "\n\nfinal sql string = ".$query."\n\n";

    try{
        $stmt = $conn->prepare($query);
        //$stmt->debugDumpParams();
        $stmt->execute();

        // set the resulting array to associative
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        foreach ($result as $key => $value) {
          $result[$key][$field_studentNo] = array($value[$field_studentNo], $value[$field_fatherNo]);
          unset($result[$key][$field_fatherNo]);
        }       
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
