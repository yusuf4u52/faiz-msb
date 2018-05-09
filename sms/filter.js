	$('#message').jqEasyCounter({
		'maxChars': 1000,
		'maxCharsWarning': 145
	});

	$("button[id^='placeholder_']").each(function (i, el) {
		$(el).on('click', function(){
			$("#message").val($("#message").val() + $(this).attr('data-original-title'));
	  	});
	});
	var templates = {
		"warning": "Salam <NAME> bhai, Thali#<THALI> Ur hub <AMOUNT> is pending for current month. Pls contribute before ^ to get uninterrupted transport.",
		"urgent": "Salam <NAME> bhai, Thali#<THALI> LAST DAY to contribute your hub <AMOUNT>, Transportation will be discontinued from tomorrow onwards.",
		"delay": "Salam <NAME> bhai, your transporter ^ is delayed. Your thali (<THALI>) is delayed by ^ hours. Sorry for inconvenience.",
		"na": "Salam <NAME> bhai, your transporter ^ is ^. Plz pick up your thali(<THALI>) before ^ from Faiz. Sorry for inconvenience."
	}

	$("a[id^='template_']").each(function(i, el){
		// console.log("clicked"+$(this).attr("id"));
		text = $(el).attr("id").replace("template_","");
		text = templates[text];
		$(el).on('click', function(){
			$("#message").val(templates[$(this).attr("id").replace("template_", "")]);
		})
	});

  	$('#amount_operator').change(function(){
		switch($(this).val())
		{
			case '>':
			case '<':
		 	case '>=':
			case '<=':
			case '=':
				$('#amount_param').parent().removeClass("hidden");
				$('#amount_param2').parent().addClass("hidden");
			break;
			case 'between':
				$('#amount_param').parent().removeClass("hidden");
				$('#amount_param2').parent().removeClass("hidden");
		  	break;
			case 'none':
				$('#amount_param').parent().addClass("hidden");
				$('#amount_param2').parent().addClass("hidden");
			break;
		}
  	});
  
	$('#transporter_operator').change(function(){
		switch($(this).val())
		{
			case 'none':
				$('#transporter_param').addClass("hidden");
			break;
			case 'not in':
			case 'in':
				$('#transporter_param').removeClass("hidden");
			break;
		}
	});

	var getSelectedTransporters = function() {
		if(!$("#transporter_param").val())
			return "";
		var t = $("#transporter_param").val().map(function(val, i){
			return "'"+val+"'";
		}).join(",");
		return t;          
	}

	$('#filter').click(function(){
	//alert("you clicked me");
	//get the values from user
	//debugger;
		$("#query_status").html('<i class="fa fa-refresh fa-spin"></i>');
		amount_type = $('input[name=amount_type]:checked', '#amount_type_form').val()
		amount_operator = $('#amount_operator').val();
		amount_param = $('#amount_param').val();
		amount_param2 = $('#amount_param2').val();
		transporter_operator = $("#transporter_operator").val();
		transporter_param = getSelectedTransporters();
		active_operator = $('#active_operator').val();
		student_param = $("#student_param").val();
		father_param = $("#father_param").val();
		requestObj = $.post("index.php", {
			'amount_type':amount_type,
			'amount_operator':amount_operator,
			'amount_param':amount_param,
			'amount_param2':amount_param2,
			'transporter_operator':transporter_operator,
			'transporter_param':transporter_param,
			'active_operator':active_operator,
			'student_param':student_param,
			'father_param':father_param
		});
		requestObj.done(function(data){
			var json = null;
			try{
				json = JSON.parse(data);
			}catch(err){
				document.write(data);
				//alert(err);
				return;
			}
		  
			//alert(json['query']);
			if(json['result'] == "success")
			{
			// now populate the table with new records!
			//$("#recipientTable td").parent().remove();
				$('#recipientTableBody').html("");
				var html = "";
				var records = json['data'];
				//alert("total:"+records.length);
				//debugger;

				var field_studentNo = "CONTACT";

				var getCellHTMLFromField = function(key, value) {
					html = "";
					switch(key)
					{
						case "CONTACT":
						html = "<td name='{{key}}'>{{value}}</td>";
						value = value[0];
						break;
						default:
						html = "<td rowspan = '2' name='{{key}}'>{{value}}</td>";
					}
					html = html.replace("{{key}}", key);
					html = html.replace("{{value}}", value);
					return html;
				}
				var getRowHTMLFromRecord = function(srNo, record) {
					html = "<tr class='student' name = '{{name}}'>".replace("{{name}}", srNo);
					html += getCellHTMLFromField("index", srNo);
					for(var key in record)
					{
						html += getCellHTMLFromField(key, record[key]);
					}
					html += "</tr><tr class='father' name = '{{name}}'>".replace("{{name}}", srNo);
					//debugger;
					html += getCellHTMLFromField(field_studentNo, [record[field_studentNo][1]]);
					html += "</tr>";
					return html;
				}
				for(index=0; index<records.length; index++)
				{
					/*
					html+="<tr><td rowspan='2'>"+(index+1)+"</td>";
					record = records[index];
					for(var key in record){
						html+= "<td name = '"+key+"'>"+record[key]+"</td>";
						if(key == "CONTACT") {
							html += <td name
						}
					}
					html+="</tr>\n";
					*/
					html += getRowHTMLFromRecord(index+1, records[index]);
				}
				$('#recipientTableBody').html(html);
				$('#query_status').html(records.length);
				if(records.length > 0) {
					$('#b_selection').removeClass("hidden");
				}
				else{
					$('#b_selection').addClass("hidden");
				}
			}
			else
			{
				alert("there was some error in retrieving the records");
			}
		  //alert(json['result']);
		});
	});
