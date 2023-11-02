/*
 * BSTable
 * @description  Javascript (JQuery) library to make bootstrap tables editable. Inspired by Tito Hinostroza's library Bootstable. BSTable Copyright (C) 2020 Thomas Rokicki
 * 
 * @version 1.0
 * @author Thomas Rokicki (CraftingGamerTom), Tito Hinostroza (t-edson)
 */

"use strict";

/** @class BSTable class that represents an editable bootstrap table. */
class BSTableProgress {

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
                <button id="bEdit" type="button" class="btn btn-sm" data-bs-toggle="modal" data-bs-target="#obs-detail-modal" data-action="edit">
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
        // console.log(this.table); return false;
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
        this._modifyEachColumn(this.options.editableColumns, $cols, function($td) { // modify each column
            let content = $td.html(); // read content
            /*console.log("i="+i);
			console.log("content="+content);
			console.log("cols row="+$cols);*/
            let div = '<div style="display: none;">' + content + '</div>'; // hide content (save for later use)
			let input;
			
			/*if(i=='1')
			{
				if (content) {
                   if(content=='Civil Work')
                    {
                        input = '<select class="form-control"><option>Select Activity Type</option><option selected>Civil Work</option><option>Sub station items<option></select>';
                    }
                    else if(content=='Sub station items')
                    {
                        input = '<select class="form-control"><option>Select Activity Type</option><option selected>Civil Work</option><option selected>Sub station items<option></select>';
                    }
                    else 
                    {
                        input = '<select class="form-control"><option>Select Activity Type</option><option selected>Civil Work</option><option>Sub station items<option></select>';
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

			}
		
            $td.html(div + input); // set content*/
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
        this._modifyEachColumn(this.options.editableColumns, $cols, function($td) { // modify each column
		let cont;
		if(i==1 || i==3)
		{
			cont = $td.find('select').val();
		}
         else{
			   cont = $td.find('input').val(); // read through each input
		 } 
			
            $td.html(cont); // set the content and remove the input fields
			i++;
        });
        this._actionsModeNormal(button);
        this.options.onEdit($currentRow[0]);
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
                if ($(column).attr('name') == 'bstable-actions') {
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

                if ($(column).attr('name') == 'bstable-actions') {
                    // action buttons column. change nothing
                } 
				else if (e == '2')
				{
					$(column).html('<select class="form-control"><option>Select Activity Type</option><option selected>Civil</option><option>Electrical<option></select>')
				}
				else if (e == '4')
				{
					$(column).html('<select class="form-control"><option>Select Control Type</option><option selected>Yes</option><option selected>No<option></select>')
				}
				else if(e=='5')
				{
					$(column).html('<button type="button" class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#input-modal_new" data-bs-whatever="@mdo"><span class="fe fe-more-vertical"> </span></button>')
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