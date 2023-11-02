/*
 * BSTable
 * @description  Javascript (JQuery) library to make bootstrap tables editable. Inspired by Tito Hinostroza's library Bootstable. BSTable Copyright (C) 2020 Thomas Rokicki
 * 
 * @version 1.0
 * @author Thomas Rokicki (CraftingGamerTom), Tito Hinostroza (t-edson)
 */

"use strict";

/** @class BSTable class that represents an editable bootstrap table. */
class BSTableWithBOQ {

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
        this.table.find('thead tr').prepend('<th name="bstable-actions" style="width: 20px !important;">' + this.options.advanced.columnLabel + '</th>'); // Append column to header
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
        // Disable Add New Row button
        $('#table2-new-row-button-withBOQ').prop('disabled', true);

        // Indicate user is editing the row
        let $currentRow = $(button).parents('tr'); // access the row
        // console.log("currentRow="+JSON.stringify($currentRow));
        let $cols = $currentRow.find('td'); // read rows
        // console.log("cols="+JSON.stringify($cols));
        if (this.currentlyEditingRow($currentRow)) return; // not currently editing, return
        //Pone en modo de edición
        var i = 0;
        this._modifyEachColumn(this.options.editableColumns, $cols, function($td) { // modify each column
            let content = $td.html(); // read content
            
            let div = '<div style="display: none;">' + content + '</div>'; // hide content (save for later use)
            let input;

            if (i == 0) { /*Seq No*/
                input = '<input class="form-control input-sm"  data-original-value="' + content + '" value="' + content + '">';
            } else if (i == 1) { /*Type Of Activity*/
                input = '<input class="form-control input-sm type_of_activity" onkeyup="showWithBOQOptions(this)" data-original-value="' + content + '" value="' + content + '">';
                input += '<div id="activity-group-view" class="dropdown-view"></div>';
            } else if (i == 2) { /*Activity Name*/
                input = '<input class="form-control input-sm"  data-original-value="' + content + '" value="' + content + '">';
            } else if (i == 3) { /*Observations*/
                input = '<span class="obs-list">' + content + '</span>';
                // input += '<button type="button" class="btn btn-sm btn-obs" data-bs-toggle="modal" data-bs-target="#input-modal" data-bs-whatever="@mdo">';
                input += '<button type="button" class="btn btn-sm btn-obs" onclick="openObservationsModal()">';
                input += '<span class="fe fe-more-vertical"> </span>';
                input += '</button>';
            } else if (i == 4) { /*Dashboard Head*/
                content = (content == '') ? '-' : content;
                input = '<input class="form-control input-sm dashboard_head" onkeyup="showDashboardHeadOptions(this)" data-activity-type="withBOQ" data-original-value="' + content + '" value="' + content + '">';
                input += '<div id="dashboard-head" class="dropdown-view"></div>';
            } else if (i == 5) { /*Report Head*/
                content = (content == '') ? '-' : content;
                input = '<input class="form-control input-sm report_head" onkeyup="showReportHeadOptions(this)" data-activity-type="withBOQ" data-original-value="' + content + '" value="' + content + '">';
                input += '<div id="report-head" class="dropdown-view"></div>';
            } else if (i == 6) { /*Multiply Factor*/
                content = (content == '') ? '1' : content;
                input = '<input class="form-control input-sm" data-original-value="' + content + '" value="' + content + '">';
            } else if (i == 7 ) { /*Item Code*/
                content = (content == '') ? '-' : content;
                input = '<input class="form-control input-sm"  data-original-value="' + content + '" value="' + content + '">';
            } else if (i == 8) { /*ERP Item Name*/
                content = (content == '') ? '-' : content;
                input = '<input class="form-control input-sm"  data-original-value="' + content + '" value="' + content + '">';
            }
            
            /*if(i=='1')
            {
                if (content) {
                   if(content=='33KV Feeder')
                    {
                        input = '<select class="form-control"><option>Select Activity Type</option><option selected>33KV Feeder</option><option>11KV Feeder<option></select>';
                    }
                    else if(content=='11KV Feeder')
                    {
                        input = '<select class="form-control"><option>Select Activity Type</option><option selected>33KV Feeder</option><option selected>11KV Feeder<option></select>';
                    }
                    else 
                    {
                        input = '<select class="form-control"><option>Select Activity Type</option><option selected>33KV Feeder</option><option>11KV Feeder<option></select>';
                    } 
                } else {
                    input = '<input class="form-control input-sm"  data-original-value="' + content + '" value="' + content + '">';
                }
            }
            else if(i=='3')
            {
                if (content) {
                    if(content=='Yes')
                    {
                        input = '<select class="form-control"><option>Select Control Type</option><option selected>Yes</option><option>No<option></select>';
                    }
                    else if(content=='No')
                    {
                        input = '<select class="form-control"><option>Select Control Type</option><option selected>Yes</option><option selected>No<option></select>';
                    }
                    else 
                    {
                        input = '<select class="form-control"><option>Select Control Type</option><option selected>Yes</option><option selected>No<option></select>';
                    }
                } else {
                    input = '<input class="form-control input-sm"  data-original-value="' + content + '" value="' + content + '">';
                }
            }
            else if(i=='4')
            {
                console.log("In console 4");
                return;
            }
            else
            {
                 input = '<input class="form-control input-sm"  data-original-value="' + content + '" value="' + content + '">';

            }*/
        
            $td.html(div + input); // set content
            i++;
        });
        this._actionsModeEdit(button);
    }
    _rowDelete(button) {
        console.log('delete button clicked'); 
        //Finding hidden input
        let hidden_input = $(button).closest('td').next('input[type="hidden"]');
        
        if (hidden_input.length == 1) {
            //Calling function to delete the record from the database
            deleteActivity(button);    
        }

        // Remove the row
        let $currentRow = $(button).parents('tr'); // access the row
        this.options.onBeforeDelete($currentRow);
        $currentRow.remove();
        this.options.onDelete();
    }
    _rowAccept(button) {
        // Accept the changes to the row
        let $currentRow = $(button).parents('tr'); // access the row
        // console.log($currentRow);
        let $cols = $currentRow.find('td'); // read fields
        if (!this.currentlyEditingRow($currentRow)) return; // not currently editing, return

        let currentRow_id = $currentRow.attr('id');

        let content_arr = [];

        // Finish editing the row & save edits
        var i = 0;
        let row_accept = true;
        let seqno_cont, activity_group_cont, activity_name_cont, observations_cont, dashboard_head_cont, multiply_factor_cont, report_head_cont, item_code_cont, erp_item_name_cont;
        this._modifyEachColumn(this.options.editableColumns, $cols, function($td) { // modify each column
            let cont;
            let toast_message;

            if(i == 0) { /*Seq No*/
                seqno_cont = cont = $td.find('input').val(); // read through each input
                // content_arr.push({'seqno': cont});

                if (seqno_cont == '') {
                    row_accept = false;
                    toast_message = 'Add Seq No for the activity';
                }
            } else if (i == 1) { /*Type Of Activity*/
                activity_group_cont = cont = $td.find('input').val(); // read through each input
                // content_arr.push({'activity_group': cont});

                if (activity_group_cont == '') {
                    row_accept = false;
                    toast_message = 'Add Type of Activity';
                }
            } else if (i == 2) { /*Activity Name*/
                activity_name_cont = cont = $td.find('input').val(); // read through each input
                // content_arr.push({'activity_name': cont});

                if (activity_name_cont == '') {
                    row_accept = false;
                    toast_message = 'Add Activity Name';
                }
            } else if (i == 3) { /*Observations*/
                cont = $td.find('.obs-list').text();
                // console.log(observations_withBOQ);

                $.each(observations_withBOQ, function(index, value) {
                    $.each(value, function(ind, val) {
                        if (currentRow_id == ind) {
                            observations_cont = val;            
                        }
                    });
                });
                
                /*console.log('currentRow_id: ' + currentRow_id);
                console.log('observations_cont: ' + observations_cont);*/
                // content_arr.push({'observations': cont}); 
            } else if (i == 4) { /*Dashboard Head*/
                dashboard_head_cont = cont = (seqno_cont == '' || activity_group_cont == '' || activity_name_cont == '') ? '' : $td.find('input').val(); // read through each input
                // content_arr.push({'dashboard_head': cont}); 
            } else if (i == 5) { /*Report Head*/
                report_head_cont = cont = (seqno_cont == '' || activity_group_cont == '' || activity_name_cont == '') ? '' : $td.find('input').val(); // read through each input
                // content_arr.push({'report_head': cont});
            } else if (i == 6) { /*Multiply Factor*/
                multiply_factor_cont = cont = (seqno_cont == '' || activity_group_cont == '' || activity_name_cont == '') ? '' : $td.find('input').val(); // read through each input
                // content_arr.push({'multiply_factor': cont});
            } else if (i == 7) { /*Item Code*/
                item_code_cont = cont = (seqno_cont == '' || activity_group_cont == '' || activity_name_cont == '') ? '' : $td.find('input').val(); // read through each input
                // content_arr.push({'item_code': cont});
            } else if (i == 8) { /*ERP Item Name*/
                erp_item_name_cont = cont = (seqno_cont == '' || activity_group_cont == '' || activity_name_cont == '') ? '' : $td.find('input').val(); // read through each input
                // content_arr.push({'erp_item_name': cont});
            } 
            
            if (row_accept == true) {
                $td.html(cont); // set the content and remove the input fields
                i++;
            } else {
                $('.toast-body').text(toast_message);
                $('.toast').toast('show');
                return false;
            }
        });

        /*console.log(data_withBOQ);
        console.log(data_withBOQ.length);*/

        if (row_accept == true) {
            let activity_id = '';

            if ($currentRow.find('input[type="hidden"]').length == 1) {
                activity_id  = $currentRow.find('input[type="hidden"]').val();
            }
            
            content_arr.push({'seqno' : seqno_cont, 'activity_group' : activity_group_cont, 'activity_name' : activity_name_cont, 'observations' : observations_cont, 'dashboard_head' : dashboard_head_cont, 'multiply_factor' : multiply_factor_cont, 'report_head' : report_head_cont, 'item_code' : item_code_cont, 'erp_item_name' : erp_item_name_cont, 'activity_id' : activity_id});

            if (!$.isEmptyObject(data_withBOQ)) {
                $.each(data_withBOQ, function(index, value) {
                    $.each(value, function(ind, val) {
                        if (currentRow_id == ind) {
                            data_withBOQ.splice(index, 1);                            
                        }
                    });
                });

                data_withBOQ.push({[currentRow_id]: content_arr});
            } else {
                data_withBOQ.push({[currentRow_id]: content_arr});    
            }

            this._actionsModeNormal(button);
            this.options.onEdit($currentRow[0]);    
        }        

        // Enable Add New Row button
        $('#table2-new-row-button-withBOQ').prop('disabled', false);
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

        // Enable Add New Row button
        $('#table2-new-row-button-withBOQ').prop('disabled', false);
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
            this.table.find('tbody').append('<tr id="row-0">' + newColumnHTML + '</tr>');
        } else { // there are rows in the table. We will clone the last row
            let $lastRow = this.table.find('tr:last');

            $lastRow.clone().appendTo($lastRow.parent());
            $lastRow = this.table.find('tr:last');

            $lastRow.find('input[type="hidden"]').remove();

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
                /*else if (e == '2')
                {
                    $(column).html('<select class="form-control"><option>Select Activity Type</option><option selected>33KV Feeder</option><option>11KV Feeder<option></select>')
                }
                else if (e == '4')
                {
                    $(column).html('<select class="form-control"><option>Select Control Type</option><option selected>Yes</option><option selected>No<option></select>')
                }
                else if(e=='5')
                {
                    $(column).html('<button type="button" class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#input-modal_new" data-bs-whatever="@mdo"><span class="fe fe-more-vertical"> </span></button>')
                }*/
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