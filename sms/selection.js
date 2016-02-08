            var clickHandler = function(row){
                row.toggleClass('highlight');
                row.trigger("bgChange");
            }
            $('tbody#recipientTableBody').on('click', 'tr', function(){
                clickHandler($(this));
            });
            $('tbody#recipientTableBody').on('mouseenter', 'tr', 
                function(evt){
                    if(evt.ctrlKey)
                    {
                        clickHandler($(this));
                    }
                });
            $('#b_toggle').click(function(){
                $.each($('tbody#recipientTableBody tr'), function(){
                    clickHandler($(this));
                    
                });
            });
            $('#b_all').click(function(){
                $.each($('tbody#recipientTableBody tr'), function(){
                    $(this).addClass("highlight");
                    $(this).trigger("bgChange");
                });
            });
            $("#b_none").click(function(){
                $.each($('tbody#recipientTableBody tr'), function(){
                    $(this).removeClass("highlight");
                    $(this).trigger("bgChange");
                });
            });
            $('tbody#recipientTableBody').on("bgChange", "tr", function(){
                var selectedRecords = $('tbody#recipientTableBody tr.highlight');
                var len = selectedRecords.length;
                var selectionStatusString = "Selected "+len+" record(s).";
                $('#selection_status').html(selectionStatusString);
            });
            var getSelected = function(){
                thaliObjects = $('tr.highlight td[name="thali"]');
                nameObjects = $('tr.highlight td[name="name"]');
                contactObjects = $('tr.highlight td[name="contact"]');
                amountObjects = $('tr.highlight td[name="total_pending"]');
                len = thaliObjects.length;
                selected = []
                for(i = 0; i<len; i++)
                {
                    thali = thaliObjects.eq(i).html();
                    name = nameObjects.eq(i).html();
                    contact = contactObjects.eq(i).html();
                    amount = amountObjects.eq(i).html();
                    //console.log(thali+","+name+","+contact);
                    selection = {}
                    selection['thali'] = thali;
                    selection['name'] = name;
                    selection['contact'] = contact;
                    selection['amount'] = amount;
                    selected.push(selection);
                }
                return selected;
            }