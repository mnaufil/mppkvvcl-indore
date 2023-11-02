/*
 * BSTable
 * @description  Javascript (JQuery) library to make bootstrap tables editable. Inspired by Tito Hinostroza's library Bootstable. BSTable Copyright (C) 2020 Thomas Rokicki
 * 
 * @version 1.0
 * @author Thomas Rokicki (CraftingGamerTom), Tito Hinostroza (t-edson)
 */

"use strict";

/** @class BSTable class that represents an editable bootstrap table. */
class BSTableMaterialRandomSampling {

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
            },
            samplingData: null
        };

        this.table = $('#' + tableId);
        this.options = $.extend(true, defaults, options);

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
        if (this.options.samplingData != null) {
            this.table.find('thead tr').prepend('<th name="bstable-actions">' + this.options.advanced.columnLabel + '</th>'); // Append column to header
            this.table.find('tbody').empty();
            let html = '';

            $.each(this.options.samplingData, function(index, value) {
                html += '<tr class="check">';
                html += '<td>'+ value.circle_name +'</td>';
                html += '<td>'+ value.sampling_quantity +'</td>';
                html += '<td>'+ value.sampling_serial_nos +'</td>';
                html += '<td>'+ value.sampling_date +'</td>';
                html += '<td>'+ value.sampling_letter_no +'</td>';
                html += '<td>'+ value.sampling_lab_id +'</td>';
                html += '<td>'+ value.accepted_report_no +'</td>';
                html += '<td>'+ value.accepted_report_date +'</td>';
                html += '<td>'+ value.accepted_quantity +'</td>';
                html += '</tr>';
            });

            this.table.find('tbody').append(html);

            for (var i = 0; i < this.table.find('tbody tr').length; i++) {
                this.table.find('tbody tr').eq(i).prepend(this.actionsColumnHTML);                
            }

            this._addOnClickEventsToActions(); // Add onclick events to each action button in all rows
        } else if (this.options.materialData == null) {
            this.table.find('thead tr').prepend('<th name="bstable-actions">' + this.options.advanced.columnLabel + '</th>'); // Append column to header
            this.table.find('tbody tr').prepend(this.actionsColumnHTML);

            this._addOnClickEventsToActions(); // Add onclick events to each action button in all rows
        }

        /*this.table.find('thead tr').prepend('<th name="bstable-actions">' + this.options.advanced.columnLabel + '</th>'); // Append column to header
        this.table.find('tbody tr').prepend(this.actionsColumnHTML);

        this._addOnClickEventsToActions(); // Add onclick events to each action button in all rows*/

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

        //Disabling Add New button
        $('#table2-new-row-button-material-sampling-details').prop('disabled', true);

        this._modifyEachColumn(this.options.editableColumns, $cols, function($td) { // modify each column
            let content = $td.html(); // read content            
            let div = '<div style="display: none;">' + content + '</div>'; // hide content (save for later use)
            let input = '';

            if (i == 0) { /*Circle*/
                input += '<select class="form-control" name="circle">';
                input += '<option value="" selected disabled>Select Circle</option>';

                if ($td.text() == '') {
                    $.each(circle_list, function(index, value) {
                        input += '<option value="'+value.circle_id+'">'+value.circle_name+'</option>';
                    });
                } else if ($td.text() != '') {
                    $.each(circle_list, function(index, value) {
                        let selected = ($td.text() == value.circle_name) ? 'selected' : '' ;
                        input += '<option value="'+value.circle_id+'" '+ selected +'>'+value.circle_name+'</option>';
                    });
                }

                input += '</select>';
            } else if (i == 1) { /*Sampling Quantity*/
                input = '<input class="form-control input-sm" name="sampling_qty" data-original-value="' + content + '" value="' + content + '">';
            } else if (i == 2) { /*Sampling Serial Nos*/
                input = '<input class="form-control input-sm" name="sampling_serial_nos" data-original-value="' + content + '" value="' + content + '">';
            } else if (i == 3) { /*Sampling Date*/
                //Applying class to td
                // $td.addClass('sampling-date');
                input += '<input class="form-control input-sm" name="sampling_date" placeholder="DD-MM-YYYY" data-original-value="' + content + '" value="' + content + '">';
            } else if (i == 4) { /*Sampling Letter No*/
                input = '<input class="form-control input-sm" name="sampling_letter_no" data-original-value="' + content + '" value="' + content + '">';
            } else if (i == 5) { /*Sampling Lab*/
                input += '<select class="form-control" name="sampling_lab">';
                input += '<option value="" selected disabled>Select Sampling Lab</option>';

                if ($td.text() == '') {
                    $.each(sampling_lab_data, function(index, value) {
                        input += '<option value="'+ value.sampling_lab_id +'">'+ value.lab_name +'</option>';
                    });    
                } else if ($td.text() != '') {
                    $.each(sampling_lab_data, function(index, value) {
                        let selected = ($td.text() == value.lab_name) ? 'selected' : '' ;
                        input += '<option value="'+ value.sampling_lab_id +'" '+ selected +'>'+ value.lab_name +'</option>';
                    });
                }                

                input += '</select>';
            } else if (i == 6) { /*Accepted Report No*/
                input = '<input class="form-control input-sm" name="accepted_report_no" data-original-value="' + content + '" value="' + content + '">';
            } else if (i == 7) { /*Accepted Report Date*/
                input += '<input class="form-control input-sm" name="accepted_report_date" placeholder="DD-MM-YYYY" data-original-value="' + content + '" value="' + content + '">';
            } else if (i == 8) { /*Accepted Quantity*/
                input = '<input class="form-control input-sm" name="accepted_qty" data-original-value="' + content + '" value="' + content + '">';
            }
        
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

        // Finish editing the row & save edits
        var i = 0;
        let row_accept = true;
        form_change = true;
        let circle_cont, qty_cont, serial_cont, sampling_date_cont, letter_cont, lab_cont, report_cont, report_date_cont, accepted_qty_cont;
        this._modifyEachColumn(this.options.editableColumns, $cols, function($td) { // modify each column
            let cont;
            let toast_message;

            if (i == 0) { /*Circle*/
                if ($td.find('select[name="circle"]').length == 1) {
                    circle_cont = cont = $td.find('select[name="circle"] option:selected').text(); // read through each input
                } else {
                    circle_cont = cont = $td.text();
                }

                if (circle_cont == 'Select Circle') {
                    row_accept = false;
                    toast_message = 'Select Circle';
                }

            }  else if (i == 1) { /*Sampling Quantity*/
                if ($td.find('input[name="sampling_qty"]').length == 1) {
                    qty_cont = cont = $td.find('input[name="sampling_qty"]').val(); // read through each input
                } else {
                    qty_cont = cont = $td.text();
                }
            } else if (i == 2) { /*Sampling Serial Nos*/
                if ($td.find('input[name="sampling_serial_nos"]').length == 1) {
                    serial_cont = cont = $td.find('input[name="sampling_serial_nos"]').val(); // read through each input
                } else {
                    serial_cont = cont = $td.text();
                }
            } else if (i == 3) { /*Sampling Date*/
                if ($td.find('input[name="sampling_date"]').length == 1) {
                    sampling_date_cont = cont = $td.find('input[name="sampling_date"]').val(); // read through each input

                    var dtRegex = new RegExp(/(^0[1-9]|[12][0-9]|3[01])-(0[1-9]|1[0-2])-(\d{4}$)/);

                    if (dtRegex.test(sampling_date_cont) == false) {
                        row_accept = false;
                        toast_message = 'Enter Sampling Date in DD-MM-YYYY format';
                    }

                    let material_received_trs = $('#new-edit-material-received-details > tbody').find('tr');

                    $.each(material_received_trs, function(index, value) {
                        let circle = $(value).find('td').eq(1).text();                        

                        if (circle == circle_cont) {
                            let received_date = $(value).find('td').eq(4).text();

                            if (received_date == '') {
                                row_accept = false;
                                toast_message = 'Enter Material Received Date for Circle ' + circle;
                            } else if ((received_date != '') && (getModifiedDate(sampling_date_cont) < getModifiedDate(received_date))) {
                                row_accept = false;
                                toast_message = 'Sampling Date must be greater than Material Received Date of Circle ' + circle;
                            }
                        }
                    });
                } else {
                    sampling_date_cont = cont = $td.text();
                }
            } else if (i == 4) { /*Sampling Letter No*/
                if ($td.find('input[name="sampling_letter_no"]').length == 1) {
                    letter_cont = cont = $td.find('input[name="sampling_letter_no"]').val(); // read through each input
                } else {
                    letter_cont = cont = $td.text();
                }
            } else if (i == 5) { /*Sampling Lab*/
                if ($td.find('select[name="sampling_lab"]').length == 1) {
                    lab_cont = cont = $td.find('select[name="sampling_lab"] option:selected').text(); // read through each input

                    if (lab_cont == 'Select Sampling Lab') {
                        row_accept = false;
                        toast_message = 'Select Sampling Lab';
                    }
                } else {
                    lab_cont = cont = $td.text();
                }
            } else if (i ==6) { /*Accepted Report No*/
                if ($td.find('input[name="accepted_report_no"]').length == 1) {
                    report_cont = cont = $td.find('input[name="accepted_report_no"]').val(); // read through each input
                } else {
                    report_cont = cont = $td.text();
                }
            } else if (i == 7) { /*Accepted Report Date*/
                if ($td.find('input[name="accepted_report_date"]').length == 1) {
                    report_date_cont = cont = $td.find('input[name="accepted_report_date"]').val(); // read through each input

                    var dtRegex = new RegExp(/(^0[1-9]|[12][0-9]|3[01])-(0[1-9]|1[0-2])-(\d{4}$)/);

                    if (dtRegex.test(report_date_cont) == false) {
                        row_accept = false;
                        toast_message = 'Enter Accepted Report Date in DD-MM-YYYY format';
                    }

                    if (getModifiedDate(report_date_cont) < getModifiedDate(sampling_date_cont)) {
                        row_accept = false;
                        toast_message = 'Accepted Report Date must be greater than Sampling Date';
                    }
                } else {
                    report_date_cont = cont = $td.text(); 
                }
            } else if (i == 8) { /*Accepted Quantity*/
                if ($td.find('input[name="accepted_qty"]').length == 1) {
                    accepted_qty_cont = cont = $td.find('input[name="accepted_qty"]').val(); // read through each input    
                } else {
                    accepted_qty_cont = cont = $td.text();
                }
            }

            if (row_accept == true) {
                $td.html(cont); // set the content and remove the input fields
                i++;    
            } else {
                $('#material-alert').find('.toast-body').text(toast_message);
                $('#material-alert').toast('show');
                return false;
            }            
        });

        if (row_accept == true) {
            this._actionsModeNormal(button);
            this.options.onEdit($currentRow[0]);

            //Enabling Add New button
            $('#table2-new-row-button-material-sampling-details').prop('disabled', false);  
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

        if ($('#table2-new-row-button-material-sampling-details').prop('disabled')) {
            //Enabling Add New button
            $('#table2-new-row-button-material-sampling-details').prop('disabled', false);  
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
                console.log("Add row = "+e);
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
            let last_id = $lastRow.attr('id');
            let id_arr = last_id.split('-');
            last_id = id_arr[id_arr.length - 1];

            //Setting id to last tr
            let new_id = 'row-' + (parseInt(last_id) + 1);
            $lastRow.attr('id', new_id);

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