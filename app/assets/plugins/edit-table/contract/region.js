/*
 * BSTable
 * @description  Javascript (JQuery) library to make bootstrap tables editable. Inspired by Tito Hinostroza's library Bootstable. BSTable Copyright (C) 2020 Thomas Rokicki
 * 
 * @version 1.0
 * @author Thomas Rokicki (CraftingGamerTom), Tito Hinostroza (t-edson)
 */

"use strict";

/** @class BSTable class that represents an editable bootstrap table. */
class BSTable1 {

    /**
     * Creates an instance of BSTable.
     *
     * @constructor
     * @author: Thomas Rokicki (CraftingGamerTom)
     * @param {tableId} tableId The id of the table to make editable.
     * @param {options} options The desired options for the editable table.
     */
    constructor(tableId, options) {
       
        var defaults = {
            editableColumns: null, // Index to editable columns. If null all td will be editable. Ex.: "1,2,3,4,5"
            $addButton: null, // Jquery object of "Add" button
            onEdit: function() {}, // Called after editing (accept button clicked)
            onBeforeDelete: function() {}, // Called before deletion
            onDelete: function() {}, // Called after deletion
            onAdd: function() {}, // Called when added a new row
            advanced: { // Do not override advanced unless you know what youre doing
                columnLabel: 'Actions',
                buttonHTML: `<div class="btn-list">
                <button type="button" class="btn btn-sm bEdit_Region">
                    <span class="fe fe-edit fa-lg action-btn-table" > </span>
                </button>
                <button  type="button" class="btn  btn-sm bDel_Region">
                    <span class="fe fe-trash-2 fa-lg action-btn-table" > </span>
                </button>
                <button  type="button" class="btn  btn-sm bAcep_Region" style="display:none;">
                    <span class="fe fe-check-circle fa-lg action-btn-table" > </span>
                </button>
                <button type="button" class="btn  btn-sm bCanc_Region" style="display:none;">
                    <span class="fe fe-x-circle fa-lg action-btn-table" > </span>
                </button>
            </div>`
            }
        };

        this.table = $('#' + tableId);
        this.options = $.extend(true, defaults, options);

        /** @private */
        this.actionsColumnHTML = '<td name="bstable-actions-region">' + this.options.advanced.buttonHTML + '</td>';

        //Process "editableColumns" parameter. Sets the columns that will be editable
        if (this.options.editableColumns != null) {
            // console.log("[DEBUG] editable columns: ", this.options.editableColumns);

            //Extract felds
            this.options.editableColumns = this.options.editableColumns.split(',');
        }
    }

    // --------------------------------------------------
    // -- Public Functions
    // --------------------------------------------------

    /**
     * Initializes the editable table. Creates the actions column.
     * @since 1.0.0
     */
    init() {

        this.table.find('thead tr').prepend('<th name="bstable-actions-region">' + this.options.advanced.columnLabel + '</th>'); // Append column to header
        this.table.find('tbody tr').prepend(this.actionsColumnHTML);

        this._addOnClickEventsToActions(); // Add onclick events to each action button in all rows

        // Process "addButton" parameter
        if (this.options.$addButton != null) {
            let _this = this;
            // Add a managed onclick event to the button
            this.options.$addButton.click(function() {
                _this._actionAddRow();
            });
        }
    }

    /**
     * Destroys the editable table. Removes the actions column.
     * @since 1.0.0
     */
    destroy() {
        this.table.find('th[name="bstable-actions-region"]').remove(); //remove header
        this.table.find('td[name="bstable-actions-region"]').remove(); //remove body rows
    }

    /**
     * Refreshes the editable table. 
     *
     * Literally just removes and initializes the editable table again, wrapped in one function.
     * @since 1.0.0
     */
    refresh() {
        this.destroy();
        this.init();
    }

    // --------------------------------------------------
    // -- 'Static' Functions
    // --------------------------------------------------

    /**
     * Returns whether the provided row is currently being edited.
     *
     * @param {Object} row
     * @return {boolean} true if row is currently being edited.
     * @since 1.0.0
     */
    currentlyEditingRow($currentRow) {
        // Check if the row is currently being edited
        if ($currentRow.attr('data-status') == 'editing') {
            return true;
        } else {
            return false;
        }
    }

    // --------------------------------------------------
    // -- Button Mode Functions
    // --------------------------------------------------

    _actionsModeNormal(button) {
        $(button).parent().find('.bAcep_Region').hide();
        $(button).parent().find('.bCanc_Region').hide();
        $(button).parent().find('.bEdit_Region').show();
        $(button).parent().find('.bDel_Region').show();
        let $currentRow = $(button).parents('tr'); // get the row
        $currentRow.attr('data-status', ''); // remove editing status
    }
    _actionsModeEdit(button) {
        $(button).parent().find('.bAcep_Region').show();
        $(button).parent().find('.bCanc_Region').show();
        $(button).parent().find('.bEdit_Region').hide();
        $(button).parent().find('.bDel_Region').hide();
        let $currentRow = $(button).parents('tr'); // get the row
        $currentRow.attr('data-status', 'editing'); // indicate the editing status
    }

    // --------------------------------------------------
    // -- Private Event Functions
    // --------------------------------------------------

    postdata(data)
    {
        $.ajax({
         type: "POST",
         url: baseUrl+"generatesession",
         //data: {name: 'John'},
         data: data,
         success: function(data){
         console.log(data);
         },
         error: function(xhr, status, error){
         console.error(xhr);
         }
        });
    }

   _rowEdit(button) {
        // Indicate user is editing the row
        let $currentRow = $(button).parents('tr'); // access the row
        var rowIndex = $(button).closest("tr").index();
        var data = {};
        data.sessionName = 'addcontract';
        data.action = 'editregion';
        data.rowId = rowIndex;
        //alert(rowIndex);
        this.postdata(data);
        console.log($currentRow);
        let $cols = $currentRow.find('td'); // read rows
         $("#table2-new-row-button-region").hide();
        console.log($cols);
        if (this.currentlyEditingRow($currentRow)) return; // not currently editing, return
        //Pone en modo de ediciÃ³n
		let i = 0;
        this._modifyEachColumn(this.options.editableColumns, $cols, function($td) { // modify each column
            let content = $.trim($td.html()); // read content
            console.log(content);
            let div = '<div style="display: none;">' + content + '</div>'; // hide content (save for later use)
            let input = '<input class="form-control input-sm"  data-original-value="' + content + '" value="' + content + '">';
            //$td.html(div + input); // set content
			let inputs;
            if(i=='0')
            {
				
				 $.ajax({url: baseUrl+"loadregions/"+rowIndex, success: function(result){
						inputs = result;
						$td.html(div + result); 
					}});
					console.log("inputs = "+inputs);
                /* input = '<select class="form-control"><option value="Select">Select Milestone</option><option value="1">Milestone 1</option><option value="2">Milestone 2</option><option value="3">Milestone 3</option><option value="4">Milestone 4</option><option value="5">Milestone 5</option><option value="6">Milestone 6</option><option value="7">Milestone 7</option><option value="8">Milestone 8</option></select>';*/
            }
			else if(i=='1')
			{
                $.ajax({
                    url: baseUrl+"loadsessioncircle/"+rowIndex,
                    success: function(result){
                        console.log(result);
                        inputs = result;
                        $td.html(div + result); 
                    }});

				input = '<div id="loadcircles"><select class="form-control" ><option value="Select">Select Circle</option></select></div>';
				//$td.html(input)
			}
			else if(i=='2')
			{
                $.ajax({
                    url: baseUrl+"loadsessiondivision/"+rowIndex, 
                    success: function(result){
                        inputs = result;
                        $td.html(div + result); 
                }});
				input = '<div id="loaddivisions"><select class="form-control"><option value="Select">Select Division</option></select></div>';
				$td.html(input)
			}
            else if (i == '3')
            {
                var inputElement = "'dynamicdistrictregion'";
                input = '<input class="form-control input-sm" id="dynamicdistrictregion'+rowIndex+'" data-original-value="' + content + '" value="' + content + '" onblur="charlimitwithrow(this.value, '+inputElement+', '+rowIndex+', 50)">';
                $td.html(div + input)
            }
            else if (i == '4')
            {
                var inputElement = "'dynamicvidhansabharegion'";
                input = '<input class="form-control input-sm" id="dynamicvidhansabharegion'+rowIndex+'" data-original-value="' + content + '" value="' + content + '" onblur="charlimitwithrow(this.value, '+inputElement+', '+rowIndex+', 50)">';
                $td.html(div + input)
            }
            else if (i == '5')
            {
                var inputElement = "'dynamicloksabharegion'";
                input = '<input class="form-control input-sm" id="dynamicloksabharegion'+rowIndex+'" data-original-value="' + content + '" value="' + content + '" onblur="charlimitwithrow(this.value, '+inputElement+', '+rowIndex+', 50)">';
                $td.html(div + input)
            }
			else if(i=='6')
            {
             var inputElement = "'dynamiclocationregion'";
            input = '<input class="form-control input-sm" id="dynamiclocationregion'+rowIndex+'"   data-original-value="' + content + '" value="' + content + '" onblur="charlimitwithrow(this.value, '+inputElement+', '+rowIndex+', 100)">';
                $td.html(div + input)
            }
            else if(i=='7')
            {
             var inputElement = "'dynamicfeedernameregion'";
            input = '<input class="form-control input-sm" id="dynamicfeedernameregion'+rowIndex+'"   data-original-value="' + content + '" value="' + content + '" onblur="charlimitwithrow(this.value, '+inputElement+', '+rowIndex+', 100)">';
                $td.html(div + input)
            }
            else if(i=='8')
            {
             var inputElement = "'dynamicfeederidregion'";
            input = '<input class="form-control input-sm" id="dynamicfeederidregion'+rowIndex+'"   data-original-value="' + content + '" value="' + content + '" onblur="charlimitwithrow(this.value, '+inputElement+', '+rowIndex+', 50)">';
                $td.html(div + input)
            }
            else if(i=='9')
            {
             var inputElement = "'dynamicprojectidregion'";
            input = '<input class="form-control input-sm" id="dynamicprojectidregion'+rowIndex+'"   data-original-value="' + content + '" value="' + content + '" onblur="charlimitwithrow(this.value, '+inputElement+', '+rowIndex+', 50)">';
                $td.html(div + input)
            }
            else if(i=='10')
            {
             var inputElement = "'dynamicgeocoderegion'";
            input = '<input class="form-control input-sm" id="dynamicgeocoderegion'+rowIndex+'"   data-original-value="' + content + '" value="' + content + '" onblur="charlimitwithrow(this.value, '+inputElement+', '+rowIndex+', 50)">';
                $td.html(div + input)
            }
            else if(i=='11')
            {
             var inputElement = "'dynamicqtyregion'";
            input = '<input type="number" class="form-control input-sm" id="dynamicqtyregion'+rowIndex+'"   data-original-value="' + content + '" value="' + content + '" onblur="charlimitwithrow(this.value, '+inputElement+', '+rowIndex+', 7)">';
                $td.html( div + input)
            }
            else if(i=='12')
            {
                 input = '';
                 $.ajax({url: baseUrl+"checktypeofworkboq/", success: function(result){
                        //alert("result="+result);
                        if(result=='1')
                        {
                            //alert("inside if = ");
                            $("#rowid").val(rowIndex);
                            //$("#boqform").reset();
//                             input = '<button id="bEdit" type="button" class="btn btn-sm btn-obs" data-bs-toggle="modal" data-bs-target="#boq-modal"><span class="fe fe-more-vertical"> </span> </button>';  
                                let row_feeder_id = $($currentRow).find('td[id^=td_dynamicfeederidregion] > input').val();
                                input = '<button id="bEdit" type="button" class="btn btn-sm btn-obs" onclick="showmodal('+rowIndex+','+row_feeder_id+')"><span class="fe fe-more-vertical"> </span> </button>';                            
                             $td.html(div + input)
                        }
                        else
                        {
                            //alert("inside else = ");
                             $td.html(div + input)
                        }

                    }});

                
               
            }
			else
			{
				  $td.html(div + input); // set content

			}

            i++;
        });
        this._actionsModeEdit(button);
    }
    _rowDelete(button) {
        // Remove the row
        let $currentRow = $(button).parents('tr'); // access the row
         var rowIndex = $(button).closest("tr").index();
         var data = {};
        data.sessionName = 'addcontract';
        data.action = 'deleteregion';
        data.rowId = rowIndex
         this.postdata(data);
        this.options.onBeforeDelete($currentRow);
        $("#table2-new-row-button-region").show();
        $currentRow.remove();
        this.options.onDelete();
         var regionhiddentable = $("#region_table").html();
        console.log(regionhiddentable);
        $("#regionhiddentable").val(regionhiddentable);
    }
    _rowAccept(button) {
        // Accept the changes to the row
        let $currentRow = $(button).parents('tr'); // access the row
        $("#table2-new-row-button-region").show();
        var rowIndex = $(button).closest("tr").index();
        //alert(rowIndex);
        var data = {};
        data.sessionName = 'addcontract';
        data.action = 'acceptregion';
        data.rowId = rowIndex

        var database_id = $currentRow.attr('data-database-id');
        let $cols = $currentRow.find('td'); // read fields
        if (!this.currentlyEditingRow($currentRow)) return; // not currently editing, return
		
		let i = 0;
		const checkErrors = [];
        // Finish editing the row & save edits
        this._modifyEachColumn(this.options.editableColumns, $cols, function($td) { // modify each column
            // let cont = $td.find('input').val(); // read through each input
            // $td.html(cont); // set the content and remove the input fields
		    let cont = '';
		    var isOk = true;
			
		    // if(i==0 || i==1 || i==2)
            if(i==0)
            {
                cont = $td.find('option:selected').text();			
    			var isOk = requiredvalid("region", "dynamicregion", cont, rowIndex);
                checkErrors.push(isOk);

    		    if(isOk==false)
    		    {
    			  exit();
    		    }

                data.region  = $td.find('select').val();
                data.region_text = $td.find('option:selected').text();
            }
            else if(i==1)
            {
                cont = $td.find('option:selected').text();
    			var   isOk = requiredvalid("region", "dynamiccircleregion", cont, rowIndex);
                checkErrors.push(isOk);

    		    if(isOk==false)
    		    {
    			  exit();
    		    }	 
    			
                data.circle  = $td.find('select').val();
                data.circle_text = $td.find('option:selected').text();
            }
            else if(i==2)
            {
                cont = $td.find('option:selected').text();
    			var   isOk = requiredvalid("region", "dynamicdivisionregion", cont, rowIndex);
                checkErrors.push(isOk);

    		    if(isOk==false)
    		    {
    			  exit();
    		    }	 
    			
                data.division  = $td.find('select').val();
                data.division_text = $td.find('option:selected').text();
            }
            else
            {
                cont = $td.find('input').val(); // read through each input
                if (i == 3)
                {
                    data.district = cont;
                }

                if (i == 4)
                {
                    data.vidhansabha = cont;
                }

                if (i == 5)
                {
                    data.loksabha = cont;
                }

                if(i==6)
                {
                    
    				/*var   isOk = requiredvalid("region", "dynamiclocationregion", cont, rowIndex);
    				checkErrors.push(isOk);
    				if(isOk==false)
    				{
    				    exit();
    				}*/	    
                    data.location = cont;
                }

                if(i==7)
                {
    				var   isOk = requiredvalid("region", "dynamicfeedernameregion", cont, rowIndex);
    				checkErrors.push(isOk);
    				if(isOk==false)
    				{
    				    exit();
    				}	 
                    data.feedername = cont;
                }

                if(i==8) 
                {
    				var isOk = requiredvalid("region", "dynamicfeederidregion", cont, rowIndex, database_id);
    				checkErrors.push(isOk);
    				if(isOk==false)
    				{
    				    exit();
    				}
                    data.feederid = cont;
                }

                if(i==9)
                {
    				/*var   isOk = requiredvalid("region", "dynamicprojectidregion", cont, rowIndex);
    				checkErrors.push(isOk);
    				if(isOk==false)
    				{
    				    exit();
    				}*/	   //Uncomment Later
                    data.projectid = cont;
                }
                
                if(i==10)
                {
                    data.geocode = cont;
                }

                if(i==11)
                {
    				var   isOk = requiredvalid("region", "dynamicqtyregion", cont, rowIndex);
    				checkErrors.push(isOk);
    				if(isOk==false)
    				{
    				    exit();
    				}
                    data.quantity = cont;
                }

                if(i==12)
                {
                    data.boq = cont;
                }
            } 
		 
		    //$td.html(cont); // set the content and remove the input fields
			// if(checkErrors.filter(Boolean).length ==8) //Original
            if(checkErrors.filter(Boolean).length == 6) //Delete Later
            {
				$("#td_dynamicregion"+rowIndex).html(data.region_text);
				$("#td_dynamiccircle"+rowIndex).html(data.circle_text);
				$("#td_dynamicdivision"+rowIndex).html(data.division_text);
                $("#td_dynamicdistrict"+rowIndex).html(data.district);
                $("#td_dynamicvidhansabha"+rowIndex).html(data.vidhansabha);
                $("#td_dynamicloksabha"+rowIndex).html(data.loksabha);
				$("#td_dynamiclocationregion"+rowIndex).html(data.location);
				$("#td_dynamicfeedernameregion"+rowIndex).html(data.feedername);
				$("#td_dynamicfeederidregion"+rowIndex).html(data.feederid);
				$("#td_dynamicprojectidregion"+rowIndex).html(data.projectid);
				$("#td_dynamicgeocoderegion"+rowIndex).html(data.geocode);
				$("#td_dynamicqtyregion"+rowIndex).html(data.quantity);
			}
            i++;
        });
        this.postdata(data);
        this._actionsModeNormal(button);
        this.options.onEdit($currentRow[0]);
         var regionhiddentable = $("#region_table").html();
        console.log(regionhiddentable);
        $("#regionhiddentable").val(regionhiddentable);
    }
    _rowCancel(button) {
        // Reject the changes
        let $currentRow = $(button).parents('tr'); // access the row
        let $cols = $currentRow.find('td'); // read fields
        if (!this.currentlyEditingRow($currentRow)) return; // not currently editing, return
         $("#table2-new-row-button-region").show();
        // Finish editing the row & delete changes
        this._modifyEachColumn(this.options.editableColumns, $cols, function($td) { // modify each column
            let cont = $td.find('div').html(); // read div content
            $td.html(cont); // set the content and remove the input fields
        });
        this._actionsModeNormal(button);

       
    }
    _actionAddRow() {
        // Add row to this table

        let $allRows = this.table.find('tbody tr');
		var rowCount = $('#new-edit-region tr').length;
		var rowIndex = rowCount - 1;
		
        if ($allRows.length == 0) { // there are no rows. we must create them
            let $currentRow = this.table.find('thead tr'); // find header
            let $cols = $currentRow.find('th'); // read each header field
            // create the new row
            let newColumnHTML = '';
            $cols.each(function(e) {
                let column = this; // Inner function this (column object)
				console.log("Add row = "+e);
                if ($(column).attr('name') == 'bstable-actions-region') {

                     var actionButtonHTML = `<div class="btn-list">
                <button type="button" class="btn btn-sm bEdit_Region">
                    <span class="fe fe-edit fa-lg action-btn-table" > </span>
                </button>
                <button  type="button" class="btn btn-sm bDel_Region">
                    <span class="fe fe-trash-2 fa-lg action-btn-table" > </span>
                </button>
                <button  type="button" class="btn btn-sm bAcep_Region"  style="display:none;">
                    <span class="fe fe-check-circle fa-lg action-btn-table" > </span>
                </button>
                <button type="button" class="btn btn-sm bCanc_Region" style="display:none;">
                    <span class="fe fe-x-circle fa-lg action-btn-table" > </span>
                </button>
            </div>`

                                var actionsColumnHTML = '<td name="bstable-actions">' + actionButtonHTML + '</td>';


                    newColumnHTML = newColumnHTML + actionsColumnHTML; // add action buttons
                } else {
					
						newColumnHTML = newColumnHTML + '<td></td>';
					}
                                  
            });
            this.table.find('tbody').append('<tr>' + newColumnHTML + '</tr>');
        } else { // there are rows in the table. We will clone the last row
            let $lastRow = this.table.find('tr:last');
            $lastRow.clone().appendTo($lastRow.parent());
            $lastRow = this.table.find('tr:last');

            $lastRow.attr('data-database-id', ''); //Clearing the attr data-database-id for the newly appended row

            let $cols = $lastRow.find('td'); //lee campos
            $cols.each(function(e) {
                let column = this; // Inner function this (column object)
								console.log("e = "+e);
								console.log("common = "+JSON.stringify(column));

                if ($(column).attr('name') == 'bstable-actions-region') {
                    // action buttons column. change nothing
                } 
				else {
					
					// $(column).html(''); // clear the text
						
					if(e==1)
					{
				        $(column).attr('id', 'td_dynamicregion'+rowIndex);
						$(column).html(''); // clear the text
					}
					else if(e==2)
					{
					    $(column).attr('id', 'td_dynamiccircle'+rowIndex);
						$(column).html(''); // clear the text
					}
					else if(e==3)
					{
					    $(column).attr('id', 'td_dynamicdivision'+rowIndex);
						$(column).html(''); // clear the text
					}
                    else if (e == 4)
                    {
                        $(column).attr('id', 'td_dynamicdistrict'+rowIndex);
                        $(column).html(''); // clear the text
                    }
                    else if (e == 5)
                    {
                        $(column).attr('id', 'td_dynamicvidhansabha'+rowIndex);
                        $(column).html(''); // clear the text
                    }
                    else if (e == 6)
                    {
                        $(column).attr('id', 'td_dynamicloksabha'+rowIndex);
                        $(column).html(''); // clear the text
                    }
					else if(e==7)
					{
					    $(column).attr('id', 'td_dynamiclocationregion'+rowIndex);
						$(column).html(''); // clear the text
					}
					else if(e==8)
					{
					    $(column).attr('id', 'td_dynamicfeedernameregion'+rowIndex);
						$(column).html(''); // clear the text
					}
					else if(e==9)
					{
					    $(column).attr('id', 'td_dynamicfeederidregion'+rowIndex);
						$(column).html(''); // clear the text
					}
					else if(e==10)
					{
					    $(column).attr('id', 'td_dynamicprojectidregion'+rowIndex);
						$(column).html(''); // clear the text
					}
					else if(e==11)
					{
					    $(column).attr('id', 'td_dynamicgeocoderegion'+rowIndex);
						$(column).html(''); // clear the text
					}
					else if(e==12)
					{
					    $(column).attr('id', 'td_dynamicqtyregion'+rowIndex);
						$(column).html(''); // clear the text
					}
                }
            });
        }
        this._addOnClickEventsToActions(); // Add onclick events to each action button in all rows
        this.options.onAdd();
    }

    // --------------------------------------------------
    // -- Helper Functions
    // --------------------------------------------------

    _modifyEachColumn($editableColumns, $cols, howToModify) {
        // Go through each editable field and perform the howToModifyFunction function
        let n = 0;
        $cols.each(function() {
            n++;
            if ($(this).attr('name') == 'bstable-actions-region') return; // exclude the actions column
            if (!isEditableColumn(n - 1)) return; // Check if the column is editable
            howToModify($(this)); // If editable, call the provided function
        });
        // console.log("Number of modified columns: " + n); // debug log


        function isEditableColumn(columnIndex) {
            // Indicates if the column is editable, based on configuration
            if ($editableColumns == null) { // option not defined
                return true; // all columns are editable
            } else { // option is defined
                //console.log('isEditableColumn: ' + columnIndex);  // DEBUG
                for (let i = 0; i < $editableColumns.length; i++) {
                    if (columnIndex == $editableColumns[i]) return true;
                }
                return false; // column not found
            }
        }
    }

    _addOnClickEventsToActions() {
        let _this = this;
        // Add onclick events to each action button
        this.table.find('tbody tr .bEdit_Region').each(function() {
            let button = this;
            button.onclick = function() { _this._rowEdit(button) }
        });
        this.table.find('tbody tr .bDel_Region').each(function() {
            let button = this;
            button.onclick = function() { _this._rowDelete(button) }
        });
        this.table.find('tbody tr .bAcep_Region').each(function() {
            let button = this;
            button.onclick = function() { _this._rowAccept(button) }
        });
        this.table.find('tbody tr .bCanc_Region').each(function() {
            let button = this;
            button.onclick = function() { _this._rowCancel(button) }
        });
    }

    // --------------------------------------------------
    // -- Conversion Functions
    // --------------------------------------------------

    convertTableToCSV(separator) {
        // Convert table to CSV
        let _this = this;
        let $currentRowValues = '';
        let tableValues = '';

        _this.table.find('tbody tr').each(function() {
            // force edits to complete if in progress
            if (_this.currentlyEditingRow($(this))) {
                $(this).find('#bAcep_Region').click(); // Force Accept Edit
            }
            let $cols = $(this).find('td'); // read columns
            $currentRowValues = '';
            $cols.each(function() {
                if ($(this).attr('name') == 'bstable-actions-region') {
                    // buttons column - do nothing
                } else {
                    $currentRowValues = $currentRowValues + $(this).html() + separator;
                }
            });
            if ($currentRowValues != '') {
                $currentRowValues = $currentRowValues.substr(0, $currentRowValues.length - separator.length);
            }
            tableValues = tableValues + $currentRowValues + '\n';
        });
        return tableValues;
    }

}

function selectcircle(val, rowIndex)
{
    $.ajax({
        url: baseUrl+"loadcircle/"+val+"/"+rowIndex,
        success: function(result){
			$("#loadcircles").empty();
			$("#loadcircles").html(result);

            selectdivision(val, rowIndex);
		}});
	}
		
function selectdivision(val, rowIndex)
{
    $.ajax({
        url: baseUrl+"loaddivision/"+val+"/"+rowIndex, 
        success: function(result){
			$("#loaddivisions").empty();
			$("#loaddivisions").html(result);
		}});
}		