            
            var highlight_class = "success";
            var clickHandler = function(row){
                row.toggleClass(highlight_class);
                row.trigger("bgChange");
            }
            var getSelector = function(contactType, isIndian) {
                var selector = "tbody#recipientTableBody tr{{nationalitySelector}}{{contactSelector}}";
                var contactSelector = "."+contactType;
                var nationalitySelector = "";
                if(isIndian)
                {
                    nationalitySelector = "[data-is-indian='"+isIndian+"']";
                }
                selector = selector.replace("{{nationalitySelector}}", nationalitySelector);
                selector = selector.replace("{{contactSelector}}", contactSelector);
                return selector;
            }
            $('tbody#recipientTableBody').on('click', 'tr', function(){
                clickHandler($(this));
            });
            $('tbody#recipientTableBody').on('mouseenter', 'tr', function(evt){
                    if(evt.ctrlKey){
                        clickHandler($(this));
                    }
            });
            
            $("button.sel-all").click(function(){
                var contactType = $(this).attr("name");
                var isIndian = $(this).attr("data-is-indian");
                filerString = getSelector(contactType, isIndian)+":not(.success)";
                $.each($(filerString), function(){
                    clickHandler($(this));
                });
            });
            $("button.sel-none").click(function(){
                //debugger;
                var contactType = $(this).attr("name");
                var isIndian = $(this).attr("data-is-indian");
                filerString = getSelector(contactType, isIndian)+".success";
                $.each($(filerString), function(){
                    clickHandler($(this));
                });
            });
            $("button.sel-toggle").click(function(){
                var contactType = $(this).attr("name");
                var isIndian = $(this).attr("data-is-indian");
                filerString = getSelector(contactType, isIndian);
                $.each($(filerString), function(){
                    clickHandler($(this));                    
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
                amountObjects = $('tr.'+highlight_class+' td[name="amount"]');
                len = thaliObjects.length;
                selected = [];
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
