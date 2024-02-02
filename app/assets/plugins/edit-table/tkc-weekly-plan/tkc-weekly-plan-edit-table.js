$(document).ready(function() {

    // Basic example
    /*var example1 = new BSTable("basic-edit");
    example1.init();*/
    
    
    
    /*var example3 = new BSTable("basic-datatable", {
        $addButton: $('#table2-new-row-button1'),
        onEdit:function() {
            console.log("EDITED");
        },
    });
    example3.init();*/    

    var tkc_weekly_plan_example1 = new BSTableTKCWeeklyPlan("new-add-weekly-tkc-plan-details", {
        $addButton: $('#table2-new-row-button-weekly-tkc-plan-details'),
        onEdit:function() {
            console.log('EDITED');
        }
    });
    tkc_weekly_plan_example1.init();
} );