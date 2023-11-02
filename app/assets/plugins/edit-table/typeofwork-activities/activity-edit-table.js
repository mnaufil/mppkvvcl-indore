$(document).ready(function() {

    /*// Basic example
    var example1 = new BSTable("basic-edit");
    example1.init();
    
    
    
    var example3 = new BSTable("basic-datatable", {
        $addButton: $('#table2-new-row-button1'),
        onEdit:function() {
            console.log("EDITED");
        },
    });
    example3.init();*/

    // New row edit-table example
    var example2 = new BSTableWithBOQ("new-edit-withBOQ", {
        $addButton: $('#table2-new-row-button-withBOQ'),
        onEdit:function() {
            console.log("EDITED");
        },
    });
    example2.init();

    var example9 = new BSTableWithoutBOQ("new-edit-withoutBOQ", {
        $addButton: $('#table2-new-row-button-withoutBOQ'),
        onEdit:function() {
            console.log("EDITED");
        },
    });
    example9.init();
    
    
     /*var example4 = new BSTable1("new-edit-region", {
        $addButton: $('#table2-new-row-button-region'),
        onEdit:function() {
            console.log("EDITED");
        },
    });
    example4.init();
    
    
     var example5 = new BSTable2("new-edit-installation", {
        $addButton: $('#table2-new-row-button-installation'),
        onEdit:function() {
            console.log("EDITED");
        },
    });
    example5.init();

    var example6 = new BSTable("new-edit-milestone", {
        $addButton: $("#table2-new-row-button-milestone"),
        onEdit:function() {
            console.log("EDITED");
        }
    });
    example6.init();

    var example7 = new BSTable3("new-edit-bank-details", {
        $addButton: $("#table2-new-row-button-bank-details"),
        onEdit:function() {
            console.log("EDITED");
        }
    });
    example7.init();

    var example8 = new BSTable3("new-edit-mobilisation-details", {
        $addButton: $("#table2-new-row-button-mobilisation-details"),
        onEdit:function() {
            console.log("EDITED");
        }
    });
    example8.init();*/
   
} );