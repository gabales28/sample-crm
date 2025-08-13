
// alert('test');
// $('#leaddatatable').DataTable();
var taskstable = $('#taskdatatable').DataTable({
    "processing": true,
    "serverSide": true,
    "pageLength": 100, // Default number of entries
    "lengthMenu": [100, 200, 500, 1000, 2000, 3000], // Options for entries per page
    "ajax": {
        "url": base_url + 'tasks/tasks/fetch_lead_limit_data',
        "type": "GET"
    },
    fixedColumns: {
        start: 2,
        end: 1
    },
    scrollCollapse: true,
    scrollX: true,
   
    "columns": [
        { data: "lead_id", render: function (data) { return `Lead${String(data).padStart(4, '0')}`; } },
        { data: "customer_name" },
        {
            data: 'customer_contact',
            render: function (data) {
                return data.split(',').map(contact => `<a href="tel:${contact.trim()}">${contact.trim()}</a>`).join('<br>'); // Converts contact numbers into clickable links
            }
        },
        {
            data: 'customer_email',
            render: function (data) {
                return data.split(',').map(email => {
                    const trimmedEmail = email.trim();
                    return `<a href="https://mail.google.com/mail/?view=cm&fs=1&to=${trimmedEmail}" target="_blank">${trimmedEmail}</a>`;
                }).join('<br>');
            }
        },
        { data: "customer_address", render: function(data, type, row){
            return data.substring(0, 15);
          }},
        { data: "brand_name" },
        {
            data: null,
            "render": function (data, type, row) {
                return '<a href="javascript::void();" class="OpenModal view_lead_activity" data-lead_id=' + row.lead_id + ' data-toggle="modal" data-target="#activityModal">' + row.title + '</a>';
            }
        },
        // { data: "description" },
        // { data: "lead_value" },
        {
            data: "book_link", render: function (data, type, row) {
                return '<a href="' + data + '" target="_blank" rel="noopener noreferrer">' + data.substring(0, 15) + '</a>';
            }
        },
        { data: "source" },

        {
            data: null,
            render: function (data) {
                return `${data.fname} ${data.lname}`; // Combine first and last name
            }
        },
        {
            data: null,
            render: function (data) {
                return `${data.agent_fname} ${data.agent_lname}`; // Combine first and last name
            }
        },
        { data: "lead_status" },
        { data: "services_status" },
        { data: "agent_priority" },
        { data: "agent_remarks" },
        { data: "recording", render: function(data, type, row) {
             var data_recording = data == null ?  "" : data;
            return '<a href="' + data + '" target="_blank" rel="noopener noreferrer">' + data_recording.substring(0, 15) + '</a>';
          }},
        // { data: "status_services" },
        { data: "date_assigned" },
        { data: "agent_date_assigned", render: formatDate },
        { data: "sales_remarks"},
        {
            "data": "remark_tasks", "render": function (data, type, row) {
                return data ? '<textarea class="form-control edit_remark col" style="width: 250px;"  data-lead_id="' + row.lead_id + '" rows="2" id="comment">' + data + '</textarea>' :
                    '<textarea class="form-control edit_remark" style="width: 250px;"     data-lead_id="' + row.lead_id + '" rows="2" id="comment"></textarea>';
            }
        },
        {
            data: null,
            "render": function (data, type, row) {

                return '<button type="button" class="btn btn-md  edit_payment_history" style="background-color:teal; color:white" data-lead_id=' + row.lead_id + '  data-agent_task_id=' + row.agent_task_id + ' data-toggle="modal" data-target="#edit_history">Edit Payment history</button>'

            },

        },
    ],
    drawCallback: function() {
        // Add event listener to rows after each draw (to handle dynamic row rendering)
        $('#taskdatatable tbody').on('click', 'tr', function() {
          // Remove the highlight (background color) from all rows
          $('#taskdatatable tbody tr').css('background-color', '');
    
          // Set the background color of the clicked row to highlight it
          $(this).css('background-color', 'rgb(211, 234, 253)');  // Change the color as needed (e.g., light green)
        });
      }
});


$(document).on("click", ".edit_payment_history", function (e) {

    e.preventDefault();

    var lead_id = $(this).data('lead_id');

    dataEdit = 'lead_id=' + lead_id;

    $.ajax({

        type: 'GET',

        data: dataEdit,

        url: base_url + 'history/view_agent_history',

        dataType: 'json',

        success: function (data) {

            var tr = "";
            var date_paid = new Date();

            let n = 1;
            for (var i = 0; i < data.length; i++) {
                var date_paid = data[i].date_paid || "Not Yet to change by admin";
                var pitched_price = formatCurrency(data[i].pitched_price);
                var amount = formatCurrency(data[i].amount);
                var recordingLink = data[i].recording
                    ? '<a href="' + data[i].recording + '" target="_blank" rel="noopener noreferrer">' +
                        data[i].recording.substring(0, 15) + '...</a>'
                    : 'No Recording Available';
                tr += `
            <tr>
                <td>${data[i].payment_id}</td>
                <td>${data[i].title}</td>
                <td>${data[i].additional_book}</td>
                <td>
                    <input type="text" name="pitched_price" value="${data[i].pitched_price || ''}" class="form-control" />
                </td>
                <td>
                    <input type="text" name="amount" value="${data[i].amount || ''}" class="form-control" />
                     <input type="hidden" name="agent_task_id" value="${data[i].agent_task_id || ''}" class="form-control" />
                     <input type="hidden" name="agent_priority" value="${data[i].agent_priority || ''}" class="form-control" />
                     <input type="hidden" name="services_status" value="${data[i].services_status || ''}" class="form-control" />
                     <input type="hidden" name="agent_remarks" value="${data[i].agent_remarks || ''}" class="form-control" />
                     <input type="hidden" name="lead_id" value="${data[i].lead_id || ''}" class="form-control" />

                </td>
                
                <td>
                    <select name="payment_status" class="form-control">
                        <option value="Full payment" ${data[i].payment_status === 'Full payment' ? 'selected' : ''}>Full Payment</option>
                        <option value="Initial payment" ${data[i].payment_status === 'Initial payment' ? 'selected' : ''}>Initial Payment</option>
                    </select>
                </td>
                <td><input type="text" name="services_status" value="${data[i].services_status}" class="form-control" readonly /></td>
                <td><textarea type="text" name="service_purchased" style="width: 250px;" cols="30" rows="2" class="form-control"/>${data[i].service_purchased || ''}</textarea></td>
                <td><input type="text" name="agent_remarks" value="${data[i].agent_remarks}" class="form-control" readonly /></td>
                <td><input type="text" name="agent_priority" value="${data[i].agent_priority}" class="form-control" readonly /></td>
                <td>${recordingLink}</td>
                <td>
                    <input type="date" name="date_paid" value="${formatDatE_datepaid(data[i].date_paid) || ''}" class="form-control date-picker" />
                </td>
                <td>${formatDate(data[i].date)}</td>
                <td>
                    <button type="button" class="btn btn-primary payment_history_update" data-payment_id="${data[i].payment_id}">Update</button>
                    <button type="button" class="btn btn-danger payment_history_reset" data-payment_id="${data[i].payment_id}">Reset</button>

                </td>
            </tr>`;

            }
            $(".edit_history").html(tr);
            $('#edithistorydataTable').DataTable();



        }
    });


});

//   $(document).on('click', '.payment_history_update', function() {
//     var transaction_id = $(this).data('transaction_id');
//     var pitched_price = $(this).closest('tr').find('input[name="pitched_price"]').val();
//     var amount = $(this).closest('tr').find('input[name="amount"]').val();
//     var payment_status = $(this).closest('tr').find('input[name="payment_status"]').val();
//     var date_paid = $(this).closest('tr').find('input[name="date_paid"]').val();
// // alert(pitched_price)
//     $.ajax({
//         url: `${base_url}history/edit_agent_history`,
//         type: 'POST',
//         data: {
//             transaction_id: transaction_id,
//             pitched_price: pitched_price,
//             amount: amount,
//             payment_status: payment_status,
//             date_paid: date_paid
//         },
//         dataType: 'json', // Expecting JSON response
//             success: function (res) {
//                 if (res.response =='success') {
//                     $("#history_task_form").animate({ scrollTop: 0 }, "slow")
//                     $("#history_task_form .alert-danger").removeClass("alert-danger").addClass("alert-success");
//                     $("#history_task_form .alert-success").css("display", "block");
//                     $("#history_task_form .alert-success p").html(res.message);
//                     $('#history_task_form').DataTable().ajax.reload();



//                     // setTimeout(function () {
//                     //     location.reload(); 
//                     // }, 1000);
//                 } else {
//                     $("#history_task_form").animate({ scrollTop: 0 }, "slow")
//                     $("#history_task_form .alert-success").removeClass("alert-success").addClass("alert-danger");
//                     $("#history_task_form .alert-danger").css("display", "block");
//                     $("#history_task_form .alert-danger p").html(res.message);
//                     $('#history_task_form').table_agent().ajax.reload();

//                     setTimeout(function () {
//                         $("#history_task_form .alert-danger").css("display", "none");
//                     }, 4000);
//                 }
//             }
//     });
// });
$(document).on('click', '.payment_history_update', function () {
    const transactionId = $(this).data('transaction_id');
    const payment_id = $(this).data('payment_id');
    const pitchedPrice = parseInt($(this).closest('tr').find('input[name="pitched_price"]').val(), 10) || 0;
    const amount = parseInt($(this).closest('tr').find('input[name="amount"]').val(), 10) || 0;
    const paymentStatus = $(this).closest('tr').find('select[name="payment_status"]').val();
    const datePaid = $(this).closest('tr').find('input[name="date_paid"]').val();
    const expirationDate = $(this).closest('tr').find('input[name="expiration_date"]').val();
    const agent_task_id = $(this).closest('tr').find('input[name="agent_task_id"]').val();
    const agent_priority = $(this).closest('tr').find('input[name="agent_priority"]').val();
    const services_status = $(this).closest('tr').find('input[name="services_status"]').val();
    const service_purchased = $(this).closest('tr').find('input[name="service_purchased"]').val();
    const additional_book = $(this).closest('tr').find('textarea[name="additional_book"]').val();
    const agent_remarks = $(this).closest('tr').find('select[name="agent_remarks"]').val();
    const lead_id = $(this).closest('tr').find('input[name="lead_id"]').val();

    // alert(agent_task_id)

    // alert (datePaid);
    $.ajax({
        url: `${base_url}history/updatePaymentHistory`,
        type: 'POST',
        data: {
            payment_id: payment_id,
            pitched_price: pitchedPrice,
            amount: amount,
            payment_status: paymentStatus,
            date_paid: datePaid,
            expirationDate:expirationDate,
            agent_task_id: agent_task_id,
            agent_remarks: agent_remarks,
            services_status:services_status,
            service_purchased:service_purchased,
            additional_book:additional_book,
            agent_priority: agent_priority,
            lead_id: lead_id  
        },
        success: function (response) {
            // Handle success responseddd

            $("#history_task_form .alert-danger").removeClass("alert-danger").addClass("alert-success");

            $("#history_task_form .alert-success").css("display", "block");

            $("#history_task_form .alert-success p").html("Payment history updated successfully!");
            setTimeout(function () {
            location.reload();
             },3000);

        },
        error: function (xhr, status, error) {
            // Handle error response
            $("#history_task_form .alert-success").removeClass("alert-success").addClass("alert-danger");

            $("#history_task_form .alert-danger").css("display", "block");

            $("#history_task_form .alert-danger p").html('Error updating payment history: ' + error);
        }
    });


    
});

$(document).on('click', '.payment_history_reset', function () {
    const transactionId = $(this).data('transaction_id');
    const agent_task_id = $(this).closest('tr').find('input[name="agent_task_id"]').val();
    const lead_id = $(this).closest('tr').find('input[name="lead_id"]').val();

    // alert (datePaid);

    $('#agentdialog').dialog({
        resizable: false,
        height: "auto",
        width: 500,
        modal: true,
        buttons: {
            "Yes": function() {
                // Code to delete the item
                $.ajax({
                    url: `${base_url}history/resetPaymentHistory`,
                    type: 'POST',
                    data: {
                        transaction_id: transactionId,
                        agent_task_id: agent_task_id,
                        lead_id: lead_id,
                    },
                    success: function (response) {
                        // Handle success responseddd
            
                        $("#history_task_form .alert-danger").removeClass("alert-danger").addClass("alert-success");
            
                        $("#history_task_form .alert-success").css("display", "block");
            
                        $("#history_task_form .alert-success p").html("Payment history updated successfully!");
                        setTimeout(function () {
                            location.reload();
                        }, 1000);
                    },
                    error: function (xhr, status, error) {
                        // Handle error response
                        $("#history_task_form .alert-success").removeClass("alert-success").addClass("alert-danger");
            
                        $("#history_task_form .alert-danger").css("display", "block");
            
                        $("#history_task_form .alert-danger p").html('Error updating payment history: ' + error);
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




function formatDatE_assigned(data) {
    if (!data) return '';
    const date = new Date(data);
    return moment(date).format('YYYY/MM/DD HH:mm:ss');
}

function formatDatE_datepaid(data) {
    if (!data) return '';
    const date = new Date(data);
    return moment(date).format('YYYY-MM-DD');
}


$('#statusfilters').on('change', function () {
    var selectLead_Status = $(this).val();
    taskstable.ajax.url(base_url + 'tasks/tasks/fetch_lead_limit_data?lead_status=' + selectLead_Status).load();
});

$(document).on("click", ".view_agent_task", function (e) {

    e.preventDefault();

    var taskid = $(this).data('task_id');
    var user_id = $(this).data('user_id');
    var date_assigned = $(this).data('date_assigned');
    dataEdit = 'agent_task_id=' + taskid;

    get_data(user_id, date_assigned);
    $.ajax({

        type: 'GET',

        data: dataEdit,

        url: base_url + 'leadgent/sales_agent/view_agent_task_detail',

        dataType: 'json',

        success: function (data) {
            var tr = "";
            for (var i = 0; i < data.length; i++) {

                $(".editagenttask_form .assign_to").val(data[i].user_id).change();

            }
        }
    });
});
$(document).ready(function () {
    $('#viewtaskagentdataTable').DataTable();

}

)// start list of tasks
function get_data(user_id = 0, date_assigned = "") {
    let id = user_id;
    let date = date_assigned;
    const dataTableElement = $('#viewtaskagentdataTable');

    // Destroy existing DataTable instance if it exists
    if ($.fn.DataTable.isDataTable(dataTableElement)) {
        dataTableElement.DataTable().destroy();
    }

    dataTableElement.DataTable({
        processing: true,
        serverSide: true,
        fixedColumns: {
            start: 2,
            end: 2
        },
        scrollCollapse: true,
        scrollX: true,
       
        ajax: {
            url: `${base_url}agent/view_lead_agent/fetch_agent_view_data/${id}/${date}`,
            type: "GET"
        },
        columns: [
            {
                data: "lead_id",
                render: data => `Lead${String(data).padStart(4, '0')}`
            },
            {
                data: null,
                "render": function (data, type, row) {
                    return '<a href="javascript::void();" class="OpenModal view_lead_activity" data-lead_id=' + row.lead_id + ' data-toggle="modal" data-target="#activityModal">' + row.title + '</a>';
                }
            },
            {
                data: "book_link", render: function (data, type, row) {
                    return '<a href="' + data + '" target="_blank" rel="noopener noreferrer">' + data.substring(0, 15) + '</a>';
                }
            },
            // { data: "lead_value" },
            { data: "source" },
            { data: "priority" },

            { data: "customer_name" },
            {
                data: 'customer_contact',
                render: function (data) {
                    return data.split(',').map(contact => `<a href="tel:${contact.trim()}">${contact.trim()}</a>`).join('<br>'); // Converts contact numbers into clickable links
                }
            },
            {
                data: 'customer_email',
                render: function (data) {
                    return data.split(',').map(email => {
                        const trimmedEmail = email.trim();
                        return `<a href="https://mail.google.com/mail/?view=cm&fs=1&to=${trimmedEmail}" target="_blank">${trimmedEmail}</a>`;
                    }).join('<br>');
                }
            },
            { data: "lead_status" },
            {
                data: "agent_date_assigned",
                render: formatDate
            },
            { data: "agent_priority" },
            { data: "services_status" },
            { data: "agent_priority" },


        ],
        drawCallback: function() {
            // Add event listener to rows after each draw (to handle dynamic row rendering)
            $('#taskdatatable tbody').on('click', 'tr', function() {
              // Remove the highlight (background color) from all rows
              $('#taskdatatable tbody tr').css('background-color', '');
        
              // Set the background color of the clicked row to highlight it
              $(this).css('background-color', 'rgb(211, 234, 253)');  // Change the color as needed (e.g., light green)
            });
          }

    });
}


// get data
$(document).on("click", ".edit_agent_leads", function (e) {

    e.preventDefault();

    const agentTaskId = $(this).data('agent_task_id');
    const leadId = $(this).data('lead_id');
    const service_status = $(this).data('service_status');

    // alert(agentTaskId)
    const dataEdit = { agent_task_id: agentTaskId, lead_id: leadId};
    $.ajax({

        type: 'GET',

        data: dataEdit,

        url: base_url + 'agent/Lead_Agent/view_agent_Task_detail',

        dataType: 'json',

        success: function (data) {
            var tr = "";
            for (var i = 0; i < data.length; i++) {

                $(".edit_detail_form .agent_task_id").val(data[i].agent_task_id);
                $(".edit_detail_form .lead_id").val(data[i].lead_id);
                $(".edit_detail_form .agent_remarks").val(data[i].agent_remarks);
                $(".edit_detail_form .agent_priority").val(data[i].agent_priority);
                $(".edit_detail_form .services_status").val(data[i].services_status);
                $(".edit_detail_form .note").val(data[i].note);



            }
        }
    });
});



$(document).on("click", ".view_agent_task", function (e) {

    e.preventDefault();

    var taskid = $(this).data('task_id');
    var user_id = $(this).data('user_id');
    var date_assigned = $(this).data('date_assigned');
    dataEdit = 'agent_task_id=' + taskid;

    get_data(user_id, date_assigned);
    $.ajax({

        type: 'GET',

        data: dataEdit,

        url: base_url + 'leadgent/sales_agent/view_agent_task_detail',

        dataType: 'json',

        success: function (data) {
            var tr = "";
            for (var i = 0; i < data.length; i++) {

                $(".editagenttask_form .assign_to").val(data[i].user_id).change();

            }
        }
    });
});
$(document).ready(function () {
    $('#viewtaskagentdataTable').DataTable();

}

)// start list of tasks
function get_data(user_id = 0, date_assigned = "") {
    let id = user_id;
    let date = date_assigned;
    const dataTableElement = $('#viewtaskagentdataTable');

    // Destroy existing DataTable instance if it exists
    if ($.fn.DataTable.isDataTable(dataTableElement)) {
        dataTableElement.DataTable().destroy();
    }

    dataTableElement.DataTable({
        processing: true,
        serverSide: false,
        fixedColumns: {
            start: 2,
            end: 1
        },
        scrollCollapse: true,
        scrollX: true,
      
        ajax: {
            url: `${base_url}agent/view_lead_agent/fetch_agent_view_data/${id}/${date}`,
            type: "GET"
        },
        columns: [
            {
                data: "lead_id", render: function (data) { return `Lead${String(data).padStart(4, '0')}`; },
            },
            { data: "customer_name" },
            {
                data: 'customer_contact',
                render: function (data) {
                    return data.split(',').map(contact => `<a href="tel:${contact.trim()}">${contact.trim()}</a>`).join('<br>'); // Converts contact numbers into clickable links
                }
            },
            {
                data: 'customer_email',
                render: function (data) {
                    return data.split(',').map(email => {
                        const trimmedEmail = email.trim();
                        return `<a href="https://mail.google.com/mail/?view=cm&fs=1&to=${trimmedEmail}" target="_blank">${trimmedEmail}</a>`;
                    }).join('<br>');
                }
            },

            { data: "customer_address", render: function(data, type, row){
                return data.substring(0, 15);
              }},
            // { data: "brand_name" },


            // {
            //     data: 'title',
            //     "render": function (data, type, row) {
            //         return '<a href="javascript::void();" class="OpenModal view_lead_activity" data-lead_id=' + row.lead_id + ' data-toggle="modal" data-target="#activityModal">' + data + '</a>';
            //     }
            // },
            {
                data: null,
                render: function (data, type, row) {
                  var titleParts = row.title ? row.title.split(',') : [''];
                  var formattedTitle = titleParts.map(part => part.trim()).join('<br>');
                  return (
                    '<a href="javascript:void(0);" class="OpenModal view_lead_activity" data-lead_id="' +
                    row.lead_id +
                    '" data-toggle="modal" data-target="#activityModal">' +
                    formattedTitle +
                    "</a>"
                  );
                }
              },
            {
                data: "book_link", render: function (data, type, row) {
                    return '<a href="' + data + '" target="_blank" rel="noopener noreferrer">' + data.substring(0, 15) + '</a>';
                }
            },
            // { data: "lead_value" },
            // { data: "source" },
            // { data: "priority" },
            { data: "lead_status" },

            // {
            //     data: null,
            //     render: function (data) {
            //         return `${data.leadgent_fname} ${data.leadgent_lname}`; // Combine first and last name
            //     }
            // },
            // {
            //     data: "agent_date_assigned",
            //     render: formatDate
            // },
            // { data: "agent_priority" },
            // { data: "services_status" },
            // { data: "agent_remarks" },
            {
                data: "sales_remarks",
                render: function (data, type, row) {
                  const leadId = row.lead_id;
                  const textareaContent = data ? data : "";
                  return `<textarea class="form-control col sales_remarks" style="width: 250px;" data-lead_id="${leadId}" rows="2" id="comment">${textareaContent}</textarea>`;
                },
              },
              {
                data: "remark_tasks",
                render: function (data, type, row) {
                  const leadId = row.lead_id;
                  const textareaContent = data ? data : "";
                  return `<textarea class="form-control col edit_remark" style="width: 250px;" data-lead_id="${leadId}" rows="2" id="comment">${textareaContent}</textarea>`;
                },
              },
            

        ],
        drawCallback: function() {
            // Add event listener to rows after each draw (to handle dynamic row rendering)
            $('#viewtaskagentdataTable tbody').on('click', 'tr', function() {
              // Remove the highlight (background color) from all rows
              $('#viewtaskagentdataTable tbody tr').css('background-color', '');
        
              // Set the background color of the clicked row to highlight it
              $(this).css('background-color', 'rgb(211, 234, 253)');  // Change the color as needed (e.g., light green)
            });
          }
        
        

    });
}


$(document).ready(function () {
   // Cache DOM elements
const pitchedPriceInput = document.getElementById('pitchedPrice');
const amountInput = document.getElementById('amount');
const balanceInput = document.getElementById('balance');
const paymentType = document.getElementById('paymentStatus');

let latestPitchedPrice = 0;
let currentBalance = 0;

if ($('#pitchedPrice').val() === '0.00' || $('#pitchedPrice').val() === '0') {
    $('#pitchedPrice').val('');
}

// Pitched Price input change
$('#pitchedPrice').on('input', function () {
    const pitchedPrice = parseFloat($(this).val()) || 0;
    latestPitchedPrice = pitchedPrice;
    currentBalance = pitchedPrice;

    // Check if full payment is selected
    if ($('#paymentStatus').val() === 'full') {
        $('#amount').val(pitchedPrice.toFixed(2));
    }

    const amountEntered = parseFloat($('#amount').val()) || 0;
    const balance = Math.max(pitchedPrice - amountEntered, 0);
    $('#balance').val(balance.toFixed(2));
});

// Amount input change
$('#amount').on('input', function () {
    const amountEntered = parseFloat($(this).val()) || 0;
    const balance = Math.max(currentBalance - amountEntered, 0);
    $('#total_payment').val(amountEntered.toFixed(2));
    $('#balance').val(balance.toFixed(2));
});

// Payment type change (in case user switches between full/partial)
$('#paymentStatus').on('change', function () {
    const pitchedPrice = parseFloat($('#pitchedPrice').val()) || 0;
    if ($(this).val() === 'Full payment' && pitchedPrice > 0) {
        $('#amount').val(pitchedPrice).trigger('input');
    }
});


    // Form submission
    $('#update_agent_lead').on('click', function () {
        const formData = $('#edit_agent_detail_form').serialize();

        const additionalData = {
            agent_task_id: $('.agent_task_id').val(),
            lead_id: $('.lead_id').val(),
            agent_remarks: $('.agent_remarks').val(),
            agent_priority: $('.agent_priority').val(),
            services_status: $('.services_status').val(),
            service_purchased: $('.service_purchased').val(),
            additional_book: $('.additional_book').val(),
            balance: $('#balance').val(),
            pitched_price: $('#pitchedPrice').val(),
            amount: $('#amount').val(),
            total_payment: $('#total_payment').val(),
            payment_status: $('.payment_status').val(),
            current_status_payment: $('.current_status_payment').val(),
            recording: $('.recording').val(),
        };

        const dataToSend = `${formData}&${$.param(additionalData)}`;

        $.ajax({
            type: 'POST',
            url: `${base_url}agent/Lead_Agent/update_agent`,
            data: dataToSend,
            dataType: 'json',
            success: function (res) {
                if (res.response === 'success') {
                    $("#editLeadsModal").animate({ scrollTop: 0 }, "slow");

                    swal({
                        title: "Lead Successfully Updated",
                        text: res.message,
                        icon: "success",
                        buttons: false,
                        timer: 2000
                    }).then(() => {
                        $('#editLeadsModal').modal('hide');
                        $('body').removeClass('modal-open');
                        $('.modal-backdrop').remove();
                        $('#agentsdatatable').DataTable().ajax.reload();

                        setTimeout(function () {
                            location.reload();
                        }, 1000);
                    });

                } else {
                    $("#editLeadsModal").animate({ scrollTop: 0 }, "slow");
                    $("#editLeadsModal .alert-success").removeClass("alert-success").addClass("alert-danger");
                    $("#editLeadsModal .alert-danger").css("display", "block").find("p").html(res.message);

                    setTimeout(function () {
                        $("#editLeadsModal .alert-danger").css("display", "none");
                    }, 4000);
                }
            },
            error: function (xhr, status, error) {
                console.error('AJAX error:', status, error);
            }
        });
    });
});
// $('#amount').on('input', function () {
//     const amountEntered = parseFloat($(this).val()) || 0;
//     if (amountEntered <= 0) return; // Don't proceed if 0 or invalid

//     const agentTaskId = $('.agent_task_id').val();
//     const leadId = $('.lead_id').val();

//     $.ajax({
//         url: `${base_url}agent/Lead_Agent/save_total_payment`,
//         method: 'POST',
//         data: {
//             total_payment: amountEntered,
//             agent_task_id: agentTaskId,
//             lead_id: leadId
//         },
//         success: function (response) {
//             console.log('Saved successfully:', response);
//         },
//         error: function (xhr, status, error) {
//             console.error('AJAX Error:', error);
//         }
//     });
// });





// get data
$(document).on("click", ".view_agent_leads", function (e) {

    e.preventDefault();

    const agentTaskId = $(this).data('agent_task_id');
    const leadId = $(this).data('lead_id');

    const transactionId = $(this).data('transaction_id');
    // const balance = $(this).data('balance');
    let balance = 0;
    

    const current_status_payment = $(this).data('current_status_payment');
    const service_status = $(this).data('service_status');


    // alert(agentTaskId)
    const dataEdit = { agent_task_id: agentTaskId, lead_id: leadId, transaction_id: transactionId, service_status: service_status };
    $.ajax({

        type: 'GET',

        data: dataEdit,

        url: base_url + 'agent/Lead_Agent/view_agent_Task_detail',

        dataType: 'json',

        success: function (data) {
            var tr = "";
            for (var i = 0; i < data.length; i++) {


                // alert(data[i].payment_status)
                $(".edit_detail_form .agent_task_id").val(agentTaskId);
                $(".edit_detail_form .lead_id").val(leadId);
                $(".edit_detail_form .agent_remarks").val(data[i].agent_remarks).change();
                //    $(".edit_detail_form .agent_priority").val(data[i].agent_priority).change();
                // $(".edit_detail_form .services_status").val(data[i].services_status);
                $(".edit_detail_form .services_status").val(data[i].services_status).change();
                $(".edit_detail_form .agent_remarks").val(data[i].agent_remarks).change();
                $(".edit_detail_form .current_amount").val(data[i].amount).change();

                $(".edit_detail_form .note").val(data[i].note);
                   $(".edit_detail_form .payment_status").val(data[i].payment_status);
                //    $(".edit_detail_form .amount").val(data[i].amount);
                $(".edit_detail_form .pitched_price").val();
                const total_payment = data[i].total_amount;

                if(data[i].services_status == "Publishing"){
                    $(".edit_detail_form .pitched_price").val(data[i].pitched_price);
                    balance = data[i].pitched_price - total_payment ; // Calculate balance


                }
                else if(data[i].services_status == "Marketing"){
                    $(".edit_detail_form .pitched_price").val(data[i].pitched_price_marketing);
                    balance = data[i].pitched_price_marketing - total_payment ; // Calculate balance

  
                }
                else if(data[i].services_status == "Package"){
                    $(".edit_detail_form .pitched_price").val(data[i].pitched_price_packages);
                    balance = data[i].pitched_price_marketing - total_payment ; // Calculate balance

                    
                }
                else{
                    $(".edit_detail_form .pitched_price").val("");
                    balance = 0;


                }
                $(".edit_detail_form .date_paid").val(data[i].date_paid);
                $(".edit_detail_form .recording").val(data[i].recording);
                $(".edit_detail_form .balance").val(balance);
                $(".edit_detail_form .current_balance").val(balance);
                $(".edit_detail_form .current_status_payment").val(current_status_payment);
                $(".upload_form .agent_task_id").val(agentTaskId);
                $(".upload_form .lead_id").val(leadId);


            }

        }
    });
});

// document.addEventListener('DOMContentLoaded', function () {
//     const paymentStatusSelect = document.getElementById('paymentStatus');
//     const amountInput = document.getElementById('amount');
//     const pitchedPriceInput = document.getElementById('pitchedPrice');
//     const balanceInput = document.querySelector(".edit_detail_form .balance");
//     const current_balance = document.querySelector(".edit_detail_form .current_balance");
//     const prioritySelect = document.getElementById('agent_priority');

//     function handlePaymentStatusChange() {
//         let balanceValue = parseFloat(balanceInput.value) || 0;
//         let current_balanceValue = parseFloat(current_balance.value) || 0;

//         switch (paymentStatusSelect.value) {
//             case "":
//                 amountInput.disabled = true;
//                 amountInput.value = '';
//                 pitchedPriceInput.disabled = false;
//                 break;
//             case "Initial payment":
//                 amountInput.disabled = false; // Enable input for Initial payment
//                 amountInput.value = '';
//                 balanceInput.value = current_balanceValue.toFixed(2);
//                 pitchedPriceInput.disabled = false;
//                 break;
//             case "Full payment":
//                 amountInput.value = balanceValue.toFixed(2); // Set amount to balance
//                 amountInput.disabled = true; // Disable input
//                 balanceInput.value = 0;
//                 pitchedPriceInput.disabled = true;
//                 break;
//             default:
//                 amountInput.disabled = false;
//                 amountInput.value = '';
//                 pitchedPriceInput.disabled = false;
//         }
//     }

//     function handlePriorityChange() {
//         const currentStatusPayment = document.querySelector(".payment_status")?.value;
//         const isPipeSelected = prioritySelect.value === 'Pipe';
//         const isFullPaymentClosed = currentStatusPayment === 'Full payment' && prioritySelect.value === 'Closed';

//         if (isPipeSelected || isFullPaymentClosed) {
//             amountInput.disabled = true;
//         } else {
//             amountInput.disabled = false;
//         }
//     }

//     // Event Listeners
//     paymentStatusSelect.addEventListener('change', handlePaymentStatusChange);
//     prioritySelect.addEventListener('change', handlePriorityChange);
// });

// Select priority 'Closed' enable input, 'pipe' disabled input

document.addEventListener('DOMContentLoaded', function () {
    const prioritySelect = document.getElementById('agent_priority');
    const paymentStatusSelect = document.querySelector(".current_status_payment"); // Ensure we get the correct element

    const formElements = [
        document.getElementById('services_status'),
        document.getElementById('agent_remarks'),
        document.getElementById('paymentStatus'),
        document.getElementById('pitchedPrice'),
        document.getElementById('date_paid'),
        document.getElementById('recording'),
        document.getElementById('amount'),
        document.getElementById('additional_book'),
        document.getElementById('service_purchased')
    ].filter(element => element !== null); // Filter out null elements

    function toggleFormElements(isDisabled) {
        formElements.forEach(element => {
            element.disabled = isDisabled;
        });
    }

    function handlePriorityChange() {
        const currentStatusPayment = paymentStatusSelect?.value || ""; // Ensure we fetch the correct value

        console.log("Current Payment Status:", currentStatusPayment); // Debug to see the actual value
        console.log("Selected Priority:", prioritySelect.value);

        const isPipeSelected = prioritySelect.value === 'Pipe' || prioritySelect.value === 'Prospect';
        const isFullPaymentClosed = currentStatusPayment === 'Full payment' && prioritySelect.value === 'Closed';
        const isInitialPayment = currentStatusPayment === 'Initial payment'; // Replace this with the actual value

        if (isPipeSelected) {
            toggleFormElements(true);
        } else if (isFullPaymentClosed) {
            toggleFormElements(false);
            document.getElementById('amount').disabled = false;
            document.getElementById('additional_book').disabled = false;
            document.getElementById('paymentStatus').disabled = false;
            document.getElementById('pitchedPrice').disabled = false;
            document.getElementById('recording').disabled = false;
        } else if (isInitialPayment) {
            console.log("Enabling inputs for Initial Payment.");
            toggleFormElements(false); // Enable all fields when "Initial Payment" is selected
        } else {
            toggleFormElements(false); // Enable all fields if none of the conditions are met
        }
    }

    // Run the function on page load to set the correct initial state
    handlePriorityChange();

    // Attach event listeners
    prioritySelect.addEventListener('change', handlePriorityChange);
    if (paymentStatusSelect) {
        paymentStatusSelect.addEventListener('change', handlePriorityChange);
    }
});


$(document).ready(function() {
    $('#upload_form').on('submit', function(e) {
        e.preventDefault();
        $.ajax({
            url: `${base_url}agent/Lead_Agent/do_upload`,

            type: 'POST',
            data: new FormData(this),
            contentType: false,
            processData: false,
            success: function(response) {
                $('#response').html(response);
                $('#agentsdatatable').DataTable().ajax.reload();

            },
            error: function() {
                $('#response').html('An error occurred while uploading the file.');
            }
        });
    });
});


$(document).on("click", ".edit_agents_payment_leads", function (e) {
    e.preventDefault();

    var lead_id = $(this).data('lead_id');
    var dataEdit = 'lead_id=' + lead_id;

    $.ajax({
        type: 'GET',
        data: dataEdit,
        url: base_url + 'history/get_latest_transaction_history',
        dataType: 'json',
        success: function (data) {
            var tr = "";
            var n = 1;
            var totalBalance = 0;

            for (var i = 0; i < data.length; i++) {
                const date_paid = data[i].date_paid == null ? "Await Confirmation!" : data[i].date_paid;
                const pitched_price = formatCurrency(data[i].pitched_price);
                const amount = formatCurrency(data[i].amount);
                const balanceVal = parseFloat(data[i].balance) || 0;
                totalBalance += balanceVal;

                tr += `
                <tr>
                    <td>${n++}</td>
                    <td>${data[i].title}</td>
                    <td><textarea class="form-control additional_book" name="additional_book" id="additional_book" style="width: 250px;" cols="30" rows="2">${data[i].additional_book || ''}</textarea></td>
                    <td>
                        <input type="text" name="pitched_price" value="${data[i].pitched_price || ''}" class="form-control pitched_price" readonly/>
                    </td>
                    <td>
                        <input type="text" name="amount" value="" class="form-control amount" data-prev="${data[i].amount || 0}" />
                        <input type="hidden" name="agent_task_id" value="${data[i].agent_task_id || ''}" />
                        <input type="hidden" name="agent_priority" value="${data[i].agent_priority || ''}" />
                        <input type="hidden" name="services_status" value="${data[i].services_status || ''}" />
                        <input type="hidden" name="service_purchased" value="${data[i].service_purchased || ''}" />
                        <input type="hidden" name="agent_remarks" value="${data[i].agent_remarks || ''}" />
                        <input type="hidden" name="lead_id" value="${data[i].lead_id || ''}" />
                        <input type="hidden" name="current_balance" value="${data[i].balance || ''}" />
                        <input type="hidden" name="total_payment" value="${data[i].total_payment || ''}" />
                        <input type="hidden" name="prev_total_payment"  value="${data[i].total_payment || ''}" />
                    </td>
                    <td>
                        <input type="text" name="balance" value="${data[i].balance || ''}" class="form-control balance" readonly/>
                    </td>
                    <td><input type="text" name="services_status" value="${data[i].services_status}" class="form-control" readonly /></td>
                    <td><textarea type="text" name="service_purchased" style="width: 250px;" cols="30" rows="2" class="form-control">${data[i].service_purchased || ''}</textarea></td>
                    <td>
                        <select name="payment_status" class="form-control" style="width: 200px;">
                            <option value="Full payment" ${data[i].payment_status === 'Full payment' ? 'selected' : ''}>Full Payment</option>
                            <option value="Initial payment" ${data[i].payment_status === 'Initial payment' ? 'selected' : ''}>Initial Payment</option>
                        </select>
                    </td>
                    <td>
                        <select name="agent_remarks" class="form-control agent_remarks">
                            <option value="On Process" ${data[i].agent_remarks === 'On Process' ? 'selected' : ''}>On Process</option>
                            <option value="Completed" ${data[i].agent_remarks === 'Completed' ? 'selected' : ''}>Completed</option>
                        </select>
                    </td>
                    <td><input type="text" name="agent_priority" value="${data[i].agent_priority}" class="form-control" readonly /></td>
                    <td><textarea class="form-control recording" name="recording" id="recording" style="width: 250px;" cols="30" rows="2">${data[i].recording || ''}</textarea></td>
                   
                    <td>${formatDate(data[i].date)}</td>
                    <td>
                        <button type="button" class="btn btn-primary update_payment" data-transaction_id="${data[i].transaction_id}">Update</button>
                    </td>
                </tr>`;
            }

            $(".edit_agent_leads").html(tr);

            $('#editPaymentsdataTable').DataTable();

            
            // $('#totalBalanceCell').text(formatCurrency(totalBalance));
        }
    });
});

function formatCurrency(amount) {
    return parseFloat(amount).toLocaleString('en-US', {
        style: 'currency',
        currency: 'USD'
    });
}


$(document).on('input', '.amount', function () {
    const $row = $(this).closest('tr');

    const pitchedPrice = parseFloat($row.find('.pitched_price').val()) || 0;
    const prevAmount = parseFloat($(this).data('prev')) || 0;
    const amountEntered = parseFloat($row.find('input[name="prev_total_payment"]').val());
    const prev_total_payment = parseFloat($(this).val()) || 0;
    // const prevTotalpayment = parseFloat($(this).data('prev-total-payment')) || 0;

    const newTotalPayment = prev_total_payment + amountEntered; 
    const newBalance = pitchedPrice - newTotalPayment;

    $row.find('input[name="total_payment"]').val(newTotalPayment);
    $row.find('.balance').val(newBalance);
});



// 🔵 When user changes the Payment Status dropdown
$(document).on('change', 'select[name="payment_status"]', function () {
    const $row = $(this).closest('tr');

    const pitchedPrice = parseFloat($row.find('.pitched_price').val()) || 0;
    const prevTotalPayment = parseFloat($row.find('input[name="prev_total_payment"]').val()) || 0;
    const $amountInput = $row.find('.amount');

    if ($(this).val() === 'Full payment') {
        const remainingBalance = pitchedPrice - prevTotalPayment;

        // Set the remaining balance as the new amount
         $amountInput.val(remainingBalance).prop('readonly', true);

        // Recalculate total payment and balance
        const newTotalPayment = pitchedPrice;
        const newBalance = 0;

        $row.find('input[name="total_payment"]').val(newTotalPayment);
        $row.find('.balance').val(newBalance.toFixed(2));
    }else {
        // Unlock the amount field for editing
        $amountInput.prop('readonly', false);
    }
    
});

$(document).on('click', '.update_payment', function () {
    const transactionId = $(this).data('transaction_id');
    const pitchedPrice = parseInt($(this).closest('tr').find('input[name="pitched_price"]').val(), 10) || 0;
    const amount = parseInt($(this).closest('tr').find('input[name="amount"]').val(), 10) || 0;
    const total_payment = $(this).closest('tr').find('input[name="total_payment"]').val();
    const paymentStatus = $(this).closest('tr').find('select[name="payment_status"]').val();
    const datePaid = $(this).closest('tr').find('input[name="date_paid"]').val();
    const agent_task_id = $(this).closest('tr').find('input[name="agent_task_id"]').val();
    const agent_priority = $(this).closest('tr').find('input[name="agent_priority"]').val();
    const services_status = $(this).closest('tr').find('input[name="services_status"]').val();
    const balance = $(this).closest('tr').find('input[name="balance"]').val();
    const service_purchased = $(this).closest('tr').find('textarea[name="service_purchased"]').val();
    const additional_book = $(this).closest('tr').find('textarea[name="additional_book"]').val();
    const agent_remarks = $(this).closest('tr').find('select[name="agent_remarks"]').val();
    const recording = $(this).closest('tr').find('textarea[name="recording"]').val();
    const lead_id = $(this).closest('tr').find('input[name="lead_id"]').val();

   
    $.ajax({
        url: `${base_url}history/updateLatestPayment`,
        type: 'POST',
        data: {
            transaction_id: transactionId,
            pitched_price: pitchedPrice,
            amount: amount,
            total_payment: total_payment,
            balance: balance,
            payment_status: paymentStatus,
            agent_task_id: agent_task_id,
            agent_remarks: agent_remarks,
            recording: recording,
            service_purchased: service_purchased,
            additional_book: additional_book,
            services_status:services_status,
            agent_priority: agent_priority,
            lead_id: lead_id  
        },
        success: function (response) {
            // Handle success responseddd

            $("#history_task_form .alert-danger").removeClass("alert-danger").addClass("alert-success");

            $("#history_task_form .alert-success").css("display", "block");

            $("#history_task_form .alert-success p").html("Payment Updated Successfully!");
            $('#taskdatatable').DataTable().ajax.reload();

        },
        error: function (xhr, status, error) {
            // Handle error response
            $("#history_task_form .alert-success").removeClass("alert-success").addClass("alert-danger");

            $("#history_task_form .alert-danger").css("display", "block");

            $("#history_task_form .alert-danger p").html('Error Updating Payment: ' + error);
        }
    });
});