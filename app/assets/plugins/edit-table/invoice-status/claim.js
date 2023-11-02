/*
 * BSTable
 * @description  Javascript (JQuery) library to make bootstrap tables editable. Inspired by Tito Hinostroza's library Bootstable. BSTable Copyright (C) 2020 Thomas Rokicki
 * 
 * @version 1.0
 * @author Thomas Rokicki (CraftingGamerTom), Tito Hinostroza (t-edson)
 */

"use strict";

/** @class BSTable class that represents an editable bootstrap table. */
class BSTableClaim {

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
                <button id="bEdit" type="button" class="btn btn-sm">
                    <span class="fe fe-edit fa-lg action-btn-table"> </span>
                </button>
                <button id="bDel" type="button" class="btn  btn-sm">
                    <span class="fe fe-trash-2 fa-lg action-btn-table"> </span>
                </button>
                <button id="bAcep" type="button" class="btn  btn-sm" style="display:none;">
                    <span class="fe fe-check-circle fa-lg action-btn-table"> </span>
                </button>
                <button id="bCanc" type="button" class="btn  btn-sm" style="display:none;">
                    <span class="fe fe-x-circle fa-lg action-btn-table"> </span>
                </button>
            </div>`
            }
        };

        this.table = $('#' + tableId);
        this.options = $.extend(true, defaults, options);

        console.log('inside js file');
        console.log('mode: ' + mode);

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
        if (mode != 'view') {
            this.table.find('thead tr').prepend('<th name="bstable-actions">' + this.options.advanced.columnLabel + '</th>'); // Append column to header
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
        $(button).parent().find('#bAcep').hide();
        $(button).parent().find('#bCanc').hide();
        $(button).parent().find('#bEdit').show();
        $(button).parent().find('#bDel').show();
        let $currentRow = $(button).parents('tr'); // get the row
        $currentRow.attr('data-status', ''); // remove editing status
    }
    _actionsModeEdit(button) {
        $(button).parent().find('#bAcep').show();
        $(button).parent().find('#bCanc').show();
        $(button).parent().find('#bEdit').hide();
        $(button).parent().find('#bDel').hide();
        let $currentRow = $(button).parents('tr'); // get the row
        $currentRow.attr('data-status', 'editing'); // indicate the editing status
    }

    // --------------------------------------------------
    // -- Private Event Functions
    // --------------------------------------------------

    _rowEdit(button) {
        // Indicate user is editing the row
        let $currentRow = $(button).parents('tr'); // access the row        
        // console.log("currentRow="+JSON.stringify($currentRow));
        let $cols = $currentRow.find('td'); // read rows
        // console.log("cols="+JSON.stringify($cols));
        if (this.currentlyEditingRow($currentRow)) return; // not currently editing, return
        //Pone en modo de edición
        var i = 0;
        let row_id = $currentRow.attr('data-row-id');

        //Disabling Add New button
        $('#table2-new-row-button-claim-details').prop('disabled', true);

        this._modifyEachColumn(this.options.editableColumns, $cols, function($td) { // modify each column
            let content = $td.html(); // read content
            let div = '<div style="display: none;">' + content + '</div>'; // hide content (save for later use)
            let input = '';
            
            if (i == 0) { /*Claim Type*/
                input += '<select class="form-control">';
                input += '<option value="" selected disabled>Select Claim Type</option>';

                if ($td.text() == '') {
                    $.each(type_of_claims, function(index, value) {
                        input += '<option value="'+ value.type_of_claim_id +'">'+ value.name +'</option>';
                    });
                } else if ($td.text() != '') {
                    $.each(type_of_claims, function(index, value) {
                        let selected = ($td.text() == value.name) ? 'selected' : '' ;
                        input += '<option value="'+ value.type_of_claim_id +'" '+ selected +'>'+ value.name +'</option>';
                    });
                }

                input += '</select>';
            } else if (i == 1) { /*Claim Amount (With GST)*/
                input += '<input class="form-control input-sm" name="claimAmount" data-original-value="' + content + '" value="' + content + '">';
            } else if (i == 2) { /*Mobilisation Advance Adjusted*/
                input += '<input class="form-control input-sm" name="mobilisationAdvanceAdjusted" data-original-value="' + content + '" value="' + content + '">';
            } else if (i == 3) { /*LD*/
                input += '<input class="form-control input-sm" name="ld" data-original-value="' + content + '" value="' + content + '">';
            } else if (i == 4) { /*Interest on Mobilisation Advance*/
                input += '<input class="form-control input-sm" name="interestOnMobilisationAdvance" data-original-value="' + content + '" value="' + content + '">';
            } else if (i == 5) { /*Other Deductions*/
                input += '<input class="form-control input-sm" name="otherDeductions" data-original-value="' + content + '" value="' + content + '">';
            } else if (i == 6) { /*TDS/GST-TDS*/
               input += '<input class="form-control input-sm" name="TDS" data-original-value="' + content + '" value="' + content + '">'; 
            } else if (i == 7) { /*Payable Amount*/
               input += '<input class="form-control input-sm" name="payableAmount" data-original-value="' + content + '" value="' + content + '">'; 
            } else if (i == 8) { /*Balance to Pay*/
                console.log(content);
                console.log('row:' + row_id);
                // input += '<a href="javascript:void(0)" class="btn btn-link" data-claim-row="'+ row_id +'" onclick="openPaymentDetailsModal(this);">';
               
                // input += '</a>';

                if (content == '') {
                    input += '<a href="javascript:void(0)" class="btn btn-link" data-claim-row="'+ row_id +'" onclick="openPaymentDetailsModal(this);">';
                    input += 'Add';
                    input += '</a>';                    
                } else {
                    input += content; 
                }
            }

            /*if (i == 0) {
                input += '<select class="form-control">';
                input += '<option value="select" disabled>Select Type</option>';
                input += '<option value="60% Supply" selected>60% Supply</option>';
                input += '<option value="30% Supply">30% Supply</option>';
                input += '<option value="90% Installation">90% Installation</option>';
                input += '<option value="RA Bills">RA Bills</option>';
                input += '<option value="Final Bill/OA">Final Bill/OA</option>';
                input += '</select>';
            } else if (i == 8) {
                let a_content = $(content).text();
                input += '<input class="form-control input-sm"  data-original-value="' + a_content + '" value="' + a_content + '">';

            } else {
                input += '<input class="form-control input-sm"  data-original-value="' + content + '" value="' + content + '">';
            }*/

            $td.html(div + input); // set content
            i++;
        });
        this._actionsModeEdit(button);
    }
    _rowDelete(button) {
        // Remove the row
        let $currentRow = $(button).parents('tr'); // access the row
        this.options.onBeforeDelete($currentRow);
        $currentRow.remove();
        this.options.onDelete();
    }
    _rowAccept(button) {
        // Accept the changes to the row
        let $currentRow = $(button).parents('tr'); // access the row
        console.log($currentRow);
        let $cols = $currentRow.find('td'); // read fields
        if (!this.currentlyEditingRow($currentRow)) return; // not currently editing, return

        form_change = true;

        // Finish editing the row & save edits
        var i = 0;
        let row_accept = true;
        let claim_type_cont, claim_amt_cont, mob_adv_adj_cont, ld_cont, int_mob_adv_cont, other_dts_cont, tds_cont, pay_amt_cont, bal_amt_cont;

        this._modifyEachColumn(this.options.editableColumns, $cols, function($td) { // modify each column
            let cont;
            let toast_message;

            if (i == 0) { /*Claim Type*/
                if ($td.find('select').length == 1) {
                    claim_type_cont = cont = $td.find('select option:selected').text();
                } else {
                    claim_type_cont = cont = $td.text();
                }

                if (claim_type_cont == 'Select Claim Type') {
                    row_accept = false;
                    toast_message = 'Select Claim Type';
                }
            } else if (i == 1) { /*Claim Amount (With GST)*/
                if ($td.find('input[name="claimAmount"]').length == 1) {
                    claim_amt_cont = cont = $td.find('input[name="claimAmount"]').val();
                } else {
                    claim_amt_cont = cont = $td.text();
                }
            } else if (i == 2) { /*Mobilisation Advance Adjusted*/
                if ($td.find('input[name="mobilisationAdvanceAdjusted"]').length == 1) {
                    mob_adv_adj_cont = cont = $td.find('input[name="mobilisationAdvanceAdjusted"]').val();
                } else {
                    mob_adv_adj_cont = cont = $td.text();
                }
            } else if (i == 3) { /*LD*/
                if ($td.find('input[name="ld"]').length == 1) {
                    ld_cont = cont = $td.find('input[name="ld"]').val();
                } else {
                    ld_cont = cont = $td.text();
                }
            } else if (i == 4) { /*Interest on Mobilisation Advance*/
                if ($td.find('input[name="interestOnMobilisationAdvance"]').length == 1) {
                    int_mob_adv_cont = cont = $td.find('input[name="interestOnMobilisationAdvance"]').val();
                } else {
                    int_mob_adv_cont = cont = $td.text();
                }
            } else if (i == 5) { /*Other Deductions*/
                if ($td.find('input[name="otherDeductions"]').length == 1) {
                    other_dts_cont = cont = $td.find('input[name="otherDeductions"]').val();
                } else {
                    other_dts_cont = cont = $td.text();
                }
            } else if (i == 6) { /*TDS/GST-TDS*/
                if ($td.find('input[name="TDS"]').length == 1) {
                    tds_cont = cont = $td.find('input[name="TDS"]').val();
                } else {
                    tds_cont = cont = $td.text();
                }
            } else if (i == 7) { /*Payable Amount*/
                if ($td.find('input[name="payableAmount"]').length == 1) {
                    pay_amt_cont = cont = $td.find('input[name="payableAmount"]').val();
                } else {
                    pay_amt_cont = cont = $td.text();
                }
            } else if (i == 8) { /*Balance to Pay*/

            }

            if (row_accept == true) {
                $td.html(cont); // set the content and remove the input fields
                i++;
            } else {
                $('.toast').find('.toast-body').text(toast_message);
                $('.toast').toast('show');

                return false;
            }
        });

        if (row_accept == true) {
            this._actionsModeNormal(button);
            this.options.onEdit($currentRow[0]);

            //Enabling Add New button
            $('#table2-new-row-button-claim-details').prop('disabled', false);  
        }
    }
    _rowCancel(button) {
        // Reject the changes
        let $currentRow = $(button).parents('tr'); // access the row
        let $cols = $currentRow.find('td'); // read fields
        if (!this.currentlyEditingRow($currentRow)) return; // not currently editing, return

        // Finish editing the row & delete changes
        this._modifyEachColumn(this.options.editableColumns, $cols, function($td) { // modify each column
            let cont = $td.find('div').html(); // read div content
            $td.html(cont); // set the content and remove the input fields
        });
        this._actionsModeNormal(button);

        if ($('#table2-new-row-button-claim-details').prop('disabled')) {
            //Enabling Add New button
            $('#table2-new-row-button-claim-details').prop('disabled', false);  
        }
    }
    _actionAddRow() {
        // Add row to this table

        let $allRows = this.table.find('tbody tr');
        if ($allRows.length == 0) { // there are no rows. we must create them
            let $currentRow = this.table.find('thead tr'); // find header
            let $cols = $currentRow.find('th'); // read each header field
            // create the new row
            let newColumnHTML = '';
            let actionsButtonsColumnHTML = this.actionsColumnHTML;

            $cols.each(function(e) {
                let column = this; // Inner function this (column object)
                // console.log("Add row = "+e);
                if ($(column).attr('name') == 'bstable-actions') {
                    newColumnHTML = newColumnHTML + actionsButtonsColumnHTML; // add action buttons
                } else {                    
                    newColumnHTML = newColumnHTML + '<td></td>';
                }
            });
            this.table.find('tbody').append('<tr>' + newColumnHTML + '</tr>');
        } else { // there are rows in the table. We will clone the last row
            let $lastRow = this.table.find('tr:last');
            $lastRow.clone().appendTo($lastRow.parent());
            $lastRow = this.table.find('tr:last');

            //Calculating id of previous tr
            let last_id = $lastRow.attr('data-row-id');

            //Setting id to last tr
            let new_id = parseInt(last_id) + 1;
            $lastRow.attr('data-row-id', new_id);

            let $cols = $lastRow.find('td'); //lee campos
            $cols.each(function(e) {
                let column = this; // Inner function this (column object)
                /*console.log("e = "+e);
                console.log("common = "+JSON.stringify(column));*/

                if ($(column).attr('name') == 'bstable-actions') {
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
        this.table.find('tbody tr #bEdit').each(function() {
            let button = this;
            button.onclick = function() { _this._rowEdit(button) }
        });
        this.table.find('tbody tr #bDel').each(function() {
            let button = this;
            button.onclick = function() { _this._rowDelete(button) }
        });
        this.table.find('tbody tr #bAcep').each(function() {
            let button = this;
            button.onclick = function() { _this._rowAccept(button) }
        });
        this.table.find('tbody tr #bCanc').each(function() {
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