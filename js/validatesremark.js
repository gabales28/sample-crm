$(document).on('blur ','#taskdatatable .edit_remark',function(e) {
    var lead_id = $(this).data('lead_id');
    var remark = $(this).val();
    $('#dialog').dialog({
        resizable: false,
        height: "auto",
        width: 500,
        modal: true,
        buttons: {
            "Yes": function() {
                // Code to delete the item
                $.ajax({
                    url: base_url + 'tasks/tasks/add_remark',
                    type: "POST",
                    dataType: 'json',
                    data: { lead_id: lead_id, remark: remark },
                    success: function(response) {
                        console.log("Data updated successfully");
                    },
                    error: function() {
                        console.log("Error updating data");
                    }
                    
                });
                $(this).dialog("close");
            },
            "No": function() {
                $(this).dialog("close");
            }
        }
    })


});

$(document).on('blur ','#agentsdatatable .edit_remark',function(e) {
    var lead_id = $(this).data('lead_id');
    var remark = $(this).val();
    $('#dialog').dialog({
        resizable: false,
        height: "auto",
        width: 500,
        modal: true,
        buttons: {
            "Yes": function() {
                // Code to delete the item
                $.ajax({
                    url: base_url + 'tasks/tasks/add_remark',
                    type: "POST",
                    dataType: 'json',
                    data: { lead_id: lead_id, remark: remark },
                    success: function(response) {
                        console.log("Data updated successfully");
                    },
                    error: function() {
                        console.log("Error updating data");
                    }
                    
                });
                $(this).dialog("close");
            },
            "No": function() {
                $(this).dialog("close");
            }
        }
    })


});
$(document).on('blur ','#recycledatatable .edit_remark',function(e) {
    var lead_id = $(this).data('lead_id');
    var remark = $(this).val();
    $('#dialog').dialog({
        resizable: false,
        height: "auto",
        width: 500,
        modal: true,
        buttons: {
            "Yes": function() {
                // Code to delete the item
                $.ajax({
                    url: base_url + 'tasks/tasks/add_remark',
                    type: "POST",
                    dataType: 'json',
                    data: { lead_id: lead_id, remark: remark },
                    success: function(response) {
                        console.log("Data updated successfully");
                    },
                    error: function() {
                        console.log("Error updating data");
                    }
                    
                });
                $(this).dialog("close");
            },
            "No": function() {
                $(this).dialog("close");
            }
        }
    })


});
$(document).on('blur ','#viewrecycle_historydatatable .edit_remark',function(e) {
    var lead_id = $(this).data('lead_id');
    var remark = $(this).val();
    $('#dialog').dialog({
        resizable: false,
        height: "auto",
        width: 500,
        modal: true,
        buttons: {
            "Yes": function() {
                // Code to delete the item
                $.ajax({
                    url: base_url + 'tasks/tasks/add_remark',
                    type: "POST",
                    dataType: 'json',
                    data: { lead_id: lead_id, remark: remark },
                    success: function(response) {
                        console.log("Data updated successfully");
                    },
                    error: function() {
                        console.log("Error updating data");
                    }
                    
                });
                $(this).dialog("close");
            },
            "No": function() {
                $(this).dialog("close");
            }
        }
    })


});


$(document).on('blur ','#viewtaskagentdataTable .edit_remark',function(e) {
    var lead_id = $(this).data('lead_id');
    var remark = $(this).val();
    $('#dialog').dialog({
        resizable: false,
        height: "auto",
        width: 500,
        modal: true,
        buttons: {
            "Yes": function() {
                // Code to delete the item
                $.ajax({
                    url: base_url + 'tasks/tasks/add_remark',
                    type: "POST",
                    dataType: 'json',
                    data: { lead_id: lead_id, remark: remark },
                    success: function(response) {
                        console.log("Data updated successfully");
                    },
                    error: function() {
                        console.log("Error updating data");
                    }
                    
                });
                $(this).dialog("close");
            },
            "No": function() {
                $(this).dialog("close");
            }
        }
    })


});


$(document).on('blur ','#agentsdatatable .sales_remarks',function(e) {
    var lead_id = $(this).data('lead_id');
    var remark = $(this).val();
    // alert(remark)
    // exit();

    $('#dialog').dialog({
        resizable: false,
        height: "auto",
        width: 500,
        modal: true,
        buttons: {
            "Yes": function() {
                // Code to delete the item
                $.ajax({
                    url: base_url + 'tasks/tasks/update_sales_agent_remarks',
                    type: "POST",
                    dataType: 'json',
                    data: { lead_id: lead_id, remark: remark },
                    success: function(response) {
                        console.log("Data updated successfully");
                    },
                    error: function() {
                        console.log("Error updating data");
                    }
                    
                });
                $(this).dialog("close");
            },
            "No": function() {
                $(this).dialog("close");
            }
        }
    })
});


$(document).on('blur ','#viewtaskagentdataTable .sales_remarks',function(e) {
    var lead_id = $(this).data('lead_id');
    var remark = $(this).val();
    // alert(remark)
    // exit();
    $('#dialog').dialog({
        resizable: false,
        height: "auto",
        width: 500,
        modal: true,
        buttons: {
            "Yes": function() {
                // Code to delete the item
                $.ajax({
                    url: base_url + 'tasks/tasks/update_sales_agent_remarks',
                    type: "POST",
                    dataType: 'json',
                    data: { lead_id: lead_id, remark: remark },
                    success: function(response) {
                        console.log("Data updated successfully");
                    },
                    error: function() {
                        console.log("Error updating data");
                    }
                    
                });
                $(this).dialog("close");
            },
            "No": function() {
                $(this).dialog("close");
            }
        }
    })
});

