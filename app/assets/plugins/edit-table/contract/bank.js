/*
 * BSTable
 * @description  Javascript (JQuery) library to make bootstrap tables editable. Inspired by Tito Hinostroza's library Bootstable. BSTable Copyright (C) 2020 Thomas Rokicki
 * 
 * @version 1.0
 * @author Thomas Rokicki (CraftingGamerTom), Tito Hinostroza (t-edson)
 */

"use strict";

/** @class BSTable class that represents an editable bootstrap table. */
class BSTable3 {

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
                <button  type="button" class="btn btn-sm bEdit_Bank">
                    <span class="fe fe-edit fa-lg action-btn-table" > </span>
                </button>
                <button  type="button" class="btn  btn-sm bDel_Bank">
                    <span class="fe fe-trash-2 fa-lg action-btn-table" > </span>
                </button>
                <button  type="button" class="btn  btn-sm bAcep_Bank" style="display:none;">
                    <span class="fe fe-check-circle fa-lg action-btn-table" > </span>
                </button>
                <button  type="button" class="btn  btn-sm bCanc_Bank" style="display:none;">
                    <span class="fe fe-x-circle fa-lg action-btn-table" > </span>
                </button>
            </div>`
            }
        };

        this.table = $('#' + tableId);
        this.options = $.extend(true, defaults, options);

        /** @private */
        this.actionsColumnHTML = '<td name="bstable-actions-bank">' + this.options.advanced.buttonHTML + '</td>';

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
        this.table.find('thead tr').prepend('<th name="bstable-actions-bank">' + this.options.advanced.columnLabel + '</th>'); // Append column to header
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
        this.table.find('th[name="bstable-actions-bank"]').remove(); //remove header
        this.table.find('td[name="bstable-actions-bank"]').remove(); //remove body rows
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
        $(button).parent().find('.bAcep_Bank').hide();
        $(button).parent().find('.bCanc_Bank').hide();
        $(button).parent().find('.bEdit_Bank').show();
        $(button).parent().find('.bDel_Bank').show();
        let $currentRow = $(button).parents('tr'); // get the row
        $currentRow.attr('data-status', ''); // remove editing status
    }
    _actionsModeEdit(button) {
        $(button).parent().find('.bAcep_Bank').show();
        $(button).parent().find('.bCanc_Bank').show();
        $(button).parent().find('.bEdit_Bank').hide();
        $(button).parent().find('.bDel_Bank').hide();
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
        data.action = 'editbank';
        data.rowId = rowIndex
        this.postdata(data);
         $("#table2-new-row-button-bank-details").hide();
        console.log($currentRow);
        let $cols = $currentRow.find('td'); // read rows
        console.log($cols);
        if (this.currentlyEditingRow($currentRow)) return; // not currently editing, return
        //Pone en modo de ediciÃ³n
		let i = 0;
        this._modifyEachColumn(this.options.editableColumns, $cols, function($td) { // modify each column
            let content = $td.html(); // read content
            console.log(content);
            let div = '<div style="display: none;">' + content + '</div>'; // hide content (save for later use)
            let input = '<input class="form-control input-sm"  data-original-value="' + content + '" value="' + content + '">';
            //$td.html(div + input); // set content
			let inputs;
			if(i=='0')
            {
                $.ajax({url: baseUrl+"loadbanktypes/"+rowIndex, success: function(result){
                        inputs = result;
                        $td.html(div + result); 
                    }});
            }
           
             else if(i=='2')
            {
				if(content=="")
				{
					content = "DD-MM-YYYY";
				}
                var inputElement = '"dynamicbgdatebank"';
                input = "<input class='form-control' type='date' value='" + content + "' placeholder='dd-mm-yyyy'  id='dynamicbgdatebank"+rowIndex+"'  onblur='checkdateformat(this.value, "+inputElement+", "+rowIndex+")' data-date='" + content + "' data-date-format='DD-MM-YYYY'    onfocusout='checkDateWithRow("+inputElement+", this.value, "+rowIndex+");'>";
                $td.html(div + input)
            }
            else if(i=='3')
            {
               var inputElement = "'dynamicbgamountbank'";
            input = '<input type="number" class="form-control input-sm" id="dynamicbgamountbank'+rowIndex+'"   data-original-value="' + content + '" value="' + content + '" >';
                $td.html(div + input)
            }
             else if(i=='5')
            {
				if(content=="")
				{
					content = "DD-MM-YYYY";
				}
                var inputElement = '"dynamicbgvaliddatebank"';
                input = "<input class='form-control' type='date' value='" + content + "' placeholder='dd-mm-yyyy'  id='dynamicbgvaliddatebank"+rowIndex+"' data-date='" + content + "'  data-date-format='DD-MM-YYYY'   onblur='checkdateformat(this.value, "+inputElement+", "+rowIndex+")' onfocusout='checkDateWithRow("+inputElement+", this.value, "+rowIndex+");'>";
                $td.html(div + input)
            }

			else if(i=='4')
			{
                input = '<input class="form-control input-smccc"  data-original-value="' + content + '" value="' + content + '">';

				  $td.html(div + input); // set content

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
        data.action = 'deletebank';
        data.rowId = rowIndex
         this.postdata(data);
         this.options.onBeforeDelete($currentRow);
         $("#table2-new-row-button-bank-details").show();
        var bankhiddentable = $("#bank_table").html();
         $currentRow.remove();
        this.options.onDelete();
        //console.log(bankhiddentable);
        $("#bankhiddentable").val(bankhiddentable);
    }
    _rowAccept(button) {
        // Accept the changes to the row
        let $currentRow = $(button).parents('tr'); // access the row
        console.log($currentRow);
        var rowIndex = $(button).closest("tr").index();
         var data = {};
        data.sessionName = 'addcontract';
        data.action = 'acceptbank';
        data.rowId = rowIndex
        $("#table2-new-row-button-bank-details").show();
        let $cols = $currentRow.find('td'); // read fields
        if (!this.currentlyEditingRow($currentRow)) return; // not currently editing, return
         let i = 0;
          const checkErrors = [];
        // Finish editing the row & save edits
        this._modifyEachColumn(this.options.editableColumns, $cols, function($td) { // modify each column
            let cont = $td.find('input').val(); // read through each input
            var isOk = true;
            /*if(i=='0')
               {
                    data.sr_no  = cont;
               }
               else*/ 
            if(i=='0')
               {
                    cont = $td.find('option:selected').text();
                    var   isOk = requiredvalid("bank", "dynamictype", cont, rowIndex);
                    checkErrors.push(isOk);
                   if(isOk==false)
                   {
                      exit();
                   }
                    data.bank_id  = $td.find('select').val();
                    data.bank_text  = $td.find('option:selected').text();
               }
               else if(i=='1')
               {
                var   isOk = requiredvalid("bank", "dynamicbgno", cont, rowIndex);
                    checkErrors.push(isOk);
                   if(isOk==false)
                   {
                      exit();
                   }

                   data.bg_no  = cont;
               }
               else if(i=='2')
               {
				    cont = $td.find('input').attr('data-date');
                    var   isOk = requiredvalid("bank", "dynamicbgdate", cont, rowIndex);
                    checkErrors.push(isOk);
                   if(isOk==false)
                   {
                      exit();
                   }

                    data.bg_date  = cont;
               }
               else if(i=='3')
               {
                var   isOk = requiredvalid("bank", "dynamicbgamount", cont, rowIndex);
                    checkErrors.push(isOk);
                   if(isOk==false)
                   {
                      exit();
                   }
                    data.bg_amount  = cont;
               }
               else if(i=='4')
               {
                var   isOk = requiredvalid("bank", "dynamicbank", cont, rowIndex);
                    checkErrors.push(isOk);
                   if(isOk==false)
                   {
                      exit();
                   }
                    data.bank  = cont;
               }
               else if(i=='5')
               {
				    cont = $td.find('input').attr('data-date');
                    var   isOk = requiredvalid("bank", "dynamicvalidtill", cont, rowIndex);
                    checkErrors.push(isOk);
                   if(isOk==false)
                   {
                      exit();
                   }
                    data.bg_till_date  = cont;
               }
          //  $td.html(cont); // set the content and remove the input fields
               if(checkErrors.filter(Boolean).length ==6)
            {
                $("#td_dynamictype"+rowIndex).html(data.bank_text);
                $("#td_dynamicbgno"+rowIndex).html(data.bg_no);
                $("#td_dynamicbgdate"+rowIndex).html(data.bg_date);
                $("#td_dynamicbgamount"+rowIndex).html(data.bg_amount);
                 $("#td_dynamicbank"+rowIndex).html(data.bank);
                $("#td_dynamicbgamount"+rowIndex).html(data.bg_amount);
               // $td.html(cont); // set the content and remove the input fields  
            }

            i++;
        });
        this.postdata(data);
        this._actionsModeNormal(button);
        this.options.onEdit($currentRow[0]);

        var bankhiddentable = $("#bank_table").html();
        //console.log(bankhiddentable);
        $("#bankhiddentable").val(bankhiddentable);
    }
    _rowCancel(button) {
        // Reject the changes
        let $currentRow = $(button).parents('tr'); // access the row
        let $cols = $currentRow.find('td'); // read fields
        if (!this.currentlyEditingRow($currentRow)) return; // not currently editing, return
        $("#table2-new-row-button-bank-details").show();
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
        if ($allRows.length == 0) { // there are no rows. we must create them
            let $currentRow = this.table.find('thead tr'); // find header
            let $cols = $currentRow.find('th'); // read each header field
            // create the new row
            let newColumnHTML = '';
            $cols.each(function(e) {
                let column = this; // Inner function this (column object)
				console.log("Add row = "+e);
                if ($(column).attr('name') == 'bstable-actions-bank') {

                    var actionButtonHTML = `<div class="btn-list">
                <button type="button" class="btn btn-sm bEdit_Bank">
                    <span class="fe fe-edit fa-lg action-btn-table" > </span>
                </button>
                <button  type="button" class="btn btn-sm bDel_Bank">
                    <span class="fe fe-trash-2 fa-lg action-btn-table" > </span>
                </button>
                <button  type="button" class="btn btn-sm bAcep_Bank"  style="display:none;">
                    <span class="fe fe-check-circle fa-lg action-btn-table" > </span>
                </button>
                <button type="button" class="btn btn-sm bCanc_Bank" style="display:none;">
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
            let $cols = $lastRow.find('td'); //lee campos
            $cols.each(function(e) {
                let column = this; // Inner function this (column object)
								console.log("e = "+e);
								console.log("common = "+JSON.stringify(column));

                if ($(column).attr('name') == 'bstable-actions-bank') {
                    // action buttons column. change nothing
                } 
				else {
					
						 $(column).html(''); // clear the text
					
                   
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
            if ($(this).attr('name') == 'bstable-actions-bank') return; // exclude the actions column
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
        this.table.find('tbody tr .bEdit_Bank').each(function() {
            let button = this;
            button.onclick = function() { _this._rowEdit(button) }
        });
        this.table.find('tbody tr .bDel_Bank').each(function() {
            let button = this;
            button.onclick = function() { _this._rowDelete(button) }
        });
        this.table.find('tbody tr .bAcep_Bank').each(function() {
            let button = this;
            button.onclick = function() { _this._rowAccept(button) }
        });
        this.table.find('tbody tr .bCanc_Bank').each(function() {
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
                $(this).find('#bAcep_Bank').click(); // Force Accept Edit
            }
            let $cols = $(this).find('td'); // read columns
            $currentRowValues = '';
            $cols.each(function() {
                if ($(this).attr('name') == 'bstable-actions-bank') {
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