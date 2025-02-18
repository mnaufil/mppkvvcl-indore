/*
 * BSTable
 * @description  Javascript (JQuery) library to make bootstrap tables editable. Inspired by Tito Hinostroza's library Bootstable. BSTable Copyright (C) 2020 Thomas Rokicki
 * 
 * @version 1.0
 * @author Thomas Rokicki (CraftingGamerTom), Tito Hinostroza (t-edson)
 */

"use strict";

/** @class BSTable class that represents an editable bootstrap table. */
class BSTable {

    /**
     * Creates an instance of BSTable.
     *
     * @constructor
     * @author: Thomas Rokicki (CraftingGamerTom)
     * @param {tableId} tableId The id of the table to make editable.
     * @param {options} options The desired options for the editable table.
     */
    constructor(tableId, options) {
         
        let actionButtonHTML;
        let data = 'data-table="'+ tableId + '"';
        let increMentID = 0;
        if (tableId == 'new-milestone') {
            actionButtonHTML = `<div class="btn-list" >
                <button id="bEdit_Milestone" type="button" class="btn btn-sm" ${data}>
                    <span class="fe fe-edit fa-lg action-btn-table" > </span>
                </button>
                <button id="bAcep_Milestone" type="button" class="btn  btn-sm" ${data} style="display:none;">
                    <span class="fe fe-check-circle fa-lg action-btn-table" > </span>
                </button>
                <button id="bCanc_Milestone" type="button" class="btn  btn-sm" style="display:none;">
                    <span class="fe fe-x-circle fa-lg action-btn-table" > </span>
                </button>
            </div>`;
        } else {
            actionButtonHTML = `<div class="btn-list">
                <button type="button" class="btn btn-sm bEdit_Milestone">
                    <span class="fe fe-edit fa-lg action-btn-table" > </span>
                </button>
                <button type="button" class="btn  btn-sm bDel_Milestone">
                    <span class="fe fe-trash-2 fa-lg action-btn-table" > </span>
                </button>
                <button type="button" class="btn  btn-sm bAcep_Milestone" ${data} style="display:none;">
                    <span class="fe fe-check-circle fa-lg action-btn-table" > </span>
                </button>
                <button  type="button" class="btn  btn-sm bCanc_Milestone" style="display:none;">
                    <span class="fe fe-x-circle fa-lg action-btn-table" > </span>
                </button>
            </div>`
        }

        var defaults = {
            editableColumns: null, // Index to editable columns. If null all td will be editable. Ex.: "1,2,3,4,5"
            $addButton: null, // Jquery object of "Add" button
            onEdit: function() {}, // Called after editing (accept button clicked)
            onBeforeDelete: function() {}, // Called before deletion
            onDelete: function() {}, // Called after deletion
            onAdd: function() {}, // Called when added a new row
            advanced: { // Do not override advanced unless you know what youre doing
                columnLabel: 'Actions',
                buttonHTML: actionButtonHTML
                /*buttonHTML: `<div class="btn-list">
                <button id="bEdit" type="button" class="btn btn-sm">
                    <span class="fe fe-edit fa-lg action-btn-table" > </span>
                </button>
                <button id="bDel" type="button" class="btn  btn-sm">
                    <span class="fe fe-trash-2 fa-lg action-btn-table" > </span>
                </button>
                <button id="bAcep" type="button" class="btn  btn-sm" style="display:none;">
                    <span class="fe fe-check-circle fa-lg action-btn-table" > </span>
                </button>
                <button id="bCanc" type="button" class="btn  btn-sm" style="display:none;">
                    <span class="fe fe-x-circle fa-lg action-btn-table" > </span>
                </button>
            </div>`*/
            }
        };

        this.table = $('#' + tableId);
        this.options = $.extend(true, defaults, options);

        this.actionStyle ='style="width: 100px !important"';

        /** @private */
        this.actionsColumnHTML = '<td name="bstable-actions">' + this.options.advanced.buttonHTML + '</td>';

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
        //console.log('Style: ' +this.actionStyle);
        this.table.find('thead tr').prepend('<th name="bstable-actions"'+ this.actionStyle +'>' + this.options.advanced.columnLabel + '</th>'); // Append column to header
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
        this.table.find('th[name="bstable-actions"]').remove(); //remove header
        this.table.find('td[name="bstable-actions"]').remove(); //remove body rows
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
        $(button).parent().find('.bAcep_Milestone').hide();
        $(button).parent().find('.bCanc_Milestone').hide();
        $(button).parent().find('.bEdit_Milestone').show();
        $(button).parent().find('.bDel_Milestone').show();
        let $currentRow = $(button).parents('tr'); // get the row
        $currentRow.attr('data-status', ''); // remove editing status
    }
    _actionsModeEdit(button) {
        $(button).parent().find('.bAcep_Milestone').show();
        $(button).parent().find('.bCanc_Milestone').show();
        $(button).parent().find('.bEdit_Milestone').hide();
        $(button).parent().find('.bDel_Milestone').hide();
        let $currentRow = $(button).parents('tr'); // get the row
        $currentRow.attr('data-status', 'editing'); // indicate the editing status
    }


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

    // --------------------------------------------------
    // -- Private Event Functions
    // --------------------------------------------------

   _rowEdit(button) {

        // Indicate user is editing the row
        let $currentRow = $(button).parents('tr'); // access the row
        var rowIndex = $(button).closest("tr").index();
        var data = {};
        data.sessionName = 'addcontract';
        data.action = 'editstage';
        data.rowId = rowIndex
        this.postdata(data);
        
        let $cols = $currentRow.find('td'); // read rows
        $("#table2-new-row-button-milestone").hide();

        if (this.currentlyEditingRow($currentRow)) return; // not currently editing, return
        //Pone en modo de ediciÃ³n
        var table = $(button).attr('data-table');

        let i = 0;
        this._modifyEachColumn(this.options.editableColumns, $cols, function($td) {                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                           // modify each column
            let content = $td.html(); // read content
            let selected = false;
           
        

            let div = '<div style="display: none;">' + content + '</div>'; // hide content (save for later use)
            let input = '<input class="form-control input-sm"  data-original-value="' + content + '" value="' + content + '" onblur="checknumber(this.value)">';
            //let input;
			let inputs;
            if(i=='0')
            {
				
				 $.ajax({url: baseUrl+"loadmilestones/"+rowIndex, success: function(result){
						inputs = result;
						$td.html(div + result); 
					}});
					console.log("inputs = "+inputs);
                /* input = '<select class="form-control"><option value="Select">Select Milestone</option><option value="1">Milestone 1</option><option value="2">Milestone 2</option><option value="3">Milestone 3</option><option value="4">Milestone 4</option><option value="5">Milestone 5</option><option value="6">Milestone 6</option><option value="7">Milestone 7</option><option value="8">Milestone 8</option></select>';*/
            }
			else if(i=='1')
			{
                var inputElement = '"dynamicdatepickerstage"';
//				input = '<input class="form-control" type="date" placeholder="dd-mm-yyyy" id="dynamicdatepickerstage'+rowIndex+'"  onblur="checkdateformat(this.value, "dynamicdatepickerstage",rowIndex)" >';

                if(content=="")
				{
					content = "DD-MM-YYYY";
				}
                input = "<input class='form-control' type='date' value='" + content + "' placeholder='dd-mm-yyyy'  id='dynamicdatepickerstage"+rowIndex+"'  data-date='" + content + "' data-date-format='DD-MM-YYYY'  onblur='checkdateformat(this.value, "+inputElement+", "+rowIndex+")' >";
			   //input = '<input type="date" data-date="02-09-2015" data-date-format="DD-MM-YYYY" value="2015-08-09" >';

				$td.html(div + input)
			}
            else if(i=='2')
            {
                var inputElement = "'dynamicqtystage'";
                input = '<input class="form-control" type="number" id="dynamicqtystage'+rowIndex+'" data-original-value="' + content + '" value="' + content + '" onblur="checkquantity(this.value, '+inputElement+', '+rowIndex+')" >';
                $td.html(div + input)
            }
            else if(i=='3')
            {
                 var inputElement = "'dynamicamountstage'";
                input = '<input class="form-control input-sm" id="dynamicamountstage'+rowIndex+'"  data-original-value="' + content + '" value="' + content + '" onblur="checkquoteprice(this.value, '+inputElement+', '+rowIndex+')">';
                $td.html(div + input)
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
        data.action = 'deletestage';
        data.rowId = rowIndex
         this.postdata(data);
        this.options.onBeforeDelete($currentRow);
        $("#table2-new-row-button-milestone").show();
        $currentRow.remove();
        this.options.onDelete();
        var milestonehiddentable = $("#milestone_table").html();
        //console.log(milestonehiddentable);
        $("#milestonehiddentable").val(milestonehiddentable);
    }
    _rowAccept(button) {
		
        // Accept the changes to the row
        let $currentRow = $(button).parents('tr'); // access the row
        var rowIndex = $(button).closest("tr").index();
        //alert(rowIndex);
         var data = {};
        data.sessionName = 'addcontract';
        data.action = 'acceptstage';
        data.rowId = rowIndex
       
       
       // console.log($currentRow);
        var table = $(button).attr('data-table');
        console.log('Table: '+table);
        let $cols = $currentRow.find('td'); // read fields
        if (!this.currentlyEditingRow($currentRow)) return; // not currently editing, return

        let i = 0;
       const checkErrors = [];
        // Finish editing the row & save edits
        this._modifyEachColumn(this.options.editableColumns, $cols, function($td) { // modify each column
            let cont = '';
             var isOk = true;
            
            if(i==0)
        {
            cont = $td.find('option:selected').text();
            var   isOk = requiredvalid("stage", "dynamicstages", cont, rowIndex);
            checkErrors.push(isOk);
		   if(isOk==false)
		   {
			  exit();
		   }
            data.stage  = $td.find('select').val();
            data.stage_text  = $td.find('option:selected').text();
            //alert($td.find('option:selected').text());
			
        }
         else{
               cont = $td.find('input').val(); // read through each input
               if(i==1)
               {
				  // alert(cont);
				    cont = $td.find('input').attr('data-date');
                 isOk = requiredvalid("stage", "dynamicdatepickerstage", cont, rowIndex);
                 checkErrors.push(isOk);
                   if(isOk==false)
                   {
                      exit();
                   }
                data.date  = cont;
                    
                    
               }
               else if(i==2)
               {
                     isOk = requiredvalid("stage", "dynamicqtystage", cont, rowIndex);
                     checkErrors.push(isOk);
                   if(isOk==false)
                   {
                      exit();
                   }
                    data.quantity  = cont;
               }
               else if(i==3)
               {
                 isOk = requiredvalid("stage", "dynamicamountstage", cont, rowIndex);
                 checkErrors.push(isOk);
                   if(isOk==false)
                   {
                      exit();
                   }
                    data.amount  = cont;
               }
         } 
           // cont = $td.find('input').val(); // read through each input

           /* if (table == 'new-edit-milestone' && i == 0) {
                cont = $td.text();
            } else if (table == 'new-edit-bank-details' && i == 1) {
                cont = $td.find('select').val();
                cont = cont.charAt(0).toUpperCase() + cont.slice(1);
            }*/
            //alert("isOk="+isOk);
            if(checkErrors.filter(Boolean).length ==4)
            {
				$("#td_dynamicstages"+rowIndex).html(data.stage_text);
				$("#td_dynamicdatepickerstage"+rowIndex).html(data.date);
				$("#td_dynamicqtystage"+rowIndex).html(data.quantity);
				$("#td_dynamicamountstage"+rowIndex).html(data.amount);
               // $td.html(cont); // set the content and remove the input fields  
            }
             i++;  
            
        });
         this.postdata(data);
        this._actionsModeNormal(button);
        this.options.onEdit($currentRow[0]);
		 $("#table2-new-row-button-milestone").show();
		var milestonehiddentable = $("#milestone_table").html();
		//console.log(milestonehiddentable);
		$("#milestonehiddentable").val(milestonehiddentable);
		
		
    }
    
    _rowCancel(button) {
        // Reject the changes
        let $currentRow = $(button).parents('tr'); // access the row
        let $cols = $currentRow.find('td'); // read fields
        if (!this.currentlyEditingRow($currentRow)) return; // not currently editing, return
        $("#table2-new-row-button-milestone").show();
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
		var rowCount = $('#new-edit-milestone tr').length;
		var rowIndex = rowCount - 1;
        if ($allRows.length == 0) { // there are no rows. we must create them
            let $currentRow = this.table.find('thead tr'); // find header

            // create the new ro w
            let newColumnHTML = '';
             let $cols = $currentRow.find('th'); // read each header field
            this.increMentID = this.increMentID +1;
            $cols.each(function(e) {
                let column = this; // Inner function this (column object)
                console.log("Add row = "+e);
                if ($(column).attr('name') == 'bstable-actions') {
					
					 var actionButtonHTML = `<div class="btn-list">
                <button type="button" class="btn btn-sm bEdit_Milestone">
                    <span class="fe fe-edit fa-lg action-btn-table" > </span>
                </button>
                <button  type="button" class="btn btn-sm bDel_Milestone">
                    <span class="fe fe-trash-2 fa-lg action-btn-table" > </span>
                </button>
                <button  type="button" class="btn btn-sm bAcep_Milestone"  style="display:none;">
                    <span class="fe fe-check-circle fa-lg action-btn-table" > </span>
                </button>
                <button type="button" class="btn btn-sm bCanc_Milestone" style="display:none;">
                    <span class="fe fe-x-circle fa-lg action-btn-table" > </span>
                </button>
            </div>`
			
			        var actionsColumnHTML = '<td name="bstable-actions">' + actionButtonHTML + '</td>';

                   
                    newColumnHTML = newColumnHTML + actionsColumnHTML; // add action buttons
                } 
				 else if (e == '1')
                {
					 $.ajax({url: baseUrl+"loadmilestones", success: function(result){
						//$(column).html(result);
					}});	
                    /* $(column).html('<select class="form-control"><option value="Select">Select Milestone</option><option value="1">Milestone 1</option><option value="2">Milestone 2</option><option value="3">Milestone 3</option><option value="4">Milestone 4</option><option value="5">Milestone 5</option><option value="6">Milestone 6</option><option value="7">Milestone 7</option><option value="8">Milestone 8</option></select>') */
                }
				
				
				else {
                    
                        newColumnHTML = newColumnHTML + '<td></td>';
                    }
                                  
            });
            this.table.find('tbody').append('<tr>' + newColumnHTML + '</tr>');
        } else { // there are rows in the table. We will clone the last row
            let $lastRow = this.table.find('tr:last');
            $lastRow.clone().appendTo($lastRow.parent());
            $lastRow = this.table.find('tr:last');
            let $cols = $lastRow.find('td'); //lee campos
            $cols.each(function(e) {
                let column = this; // Inner function this (column object)
                console.log("e = "+e);
                console.log("common = "+JSON.stringify(column));

                if ($(column).attr('name') == 'bstable-actions') {
                    // action buttons column. change nothing
                } 
                /*else if (e == '1')
                {
					$.ajax({url: baseUrl+"loadmilestones", success: function(result){
						$(column).html(result);
					}});	
                }*/
                /* $(column).html('<select class="form-control"><option value="Select">Select Milestone</option><option value="1">Milestone 1</option><option value="2">Milestone 2</option><option value="3">Milestone 3</option><option value="4">Milestone 4</option><option value="5">Milestone 5</option><option value="6">Milestone 6</option><option value="7">Milestone 7</option><option value="8">Milestone 8</option></select>') */

                else {
					if(e==1)
					{
					    $(column).attr('id', 'td_dynamicstages'+rowIndex);
						$(column).html(''); // clear the text
					}
					else if(e==2)
					{
					    $(column).attr('id', 'td_dynamicdatepickerstage'+rowIndex);
						$(column).html(''); // clear the text
					}
					else if(e==3)
					{
						$(column).attr('id', 'td_dynamicqtystage'+rowIndex);
					    $(column).html(''); // clear the text
					}
					else if(e==4)
					{
						$(column).attr('id', 'td_dynamicamountstage'+rowIndex);
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
            if ($(this).attr('name') == 'bstable-actions') return; // exclude the actions column
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
        this.table.find('tbody tr .bEdit_Milestone').each(function() {
            let button = this;
            button.onclick = function() { _this._rowEdit(button) }
        });
        this.table.find('tbody tr .bDel_Milestone').each(function() {
            let button = this;
            button.onclick = function() { _this._rowDelete(button) }
        });
        this.table.find('tbody tr .bAcep_Milestone').each(function() {
            let button = this;
            button.onclick = function() { _this._rowAccept(button) }
        });
        this.table.find('tbody tr .bCanc_Milestone').each(function() {
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
                $(this).find('#bAcep').click(); // Force Accept Edit
            }
            let $cols = $(this).find('td'); // read columns
            $currentRowValues = '';
            $cols.each(function() {
                if ($(this).attr('name') == 'bstable-actions') {
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