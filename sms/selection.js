            
            var highlight_class = "success";
            var clickHandler = function(row){
                row.toggleClass(highlight_class);
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
                    $(this).addClass(highlight_class);
                    $(this).trigger("bgChange");
                });
            });
            $("#b_none").click(function(){
                $.each($('tbody#recipientTableBody tr'), function(){
                    $(this).removeClass(highlight_class);
                    $(this).trigger("bgChange");
                });
            });
            $('tbody#recipientTableBody').on("bgChange", "tr", function(){
                var selectedRecords = $('tbody#recipientTableBody tr.'+highlight_class);
                var len = selectedRecords.length;
                var selectionStatusString = "Selected "+len+" record(s).";
                $('#selection_status').html(selectionStatusString);
            });
            var getSelected = function(){
                thaliObjects = $('tr.'+highlight_class+' td[name="Thali"]');
                nameObjects = $('tr.'+highlight_class+' td[name="NAME"]');
                contactObjects = $('tr.'+highlight_class+' td[name="CONTACT"]');
                amountObjects = $('tr.'+highlight_class+' td').filter('[name="Total_Pending"],[name="next_install"],[name="prev_install_pending"]');
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
                //console.log(selected);
                return selected;
            }
