
$(document).ready(function () {
    $('#viewtaskdataTable').DataTable();
});
$(document).ready(function () {
    $('#listagent_taskdatatable').DataTable();
});

// get data
$(document).on("click", ".view_task", function (e) {

    e.preventDefault();

    var viewtaskid = $(this).data('agent_task_id');
    var user_id = $(this).data('user_id');
    var date_assigned = $(this).data('date_assigned');
    dataEdits = 'agent_task_id=' + viewtaskid;
    get_task_datas(user_id, date_assigned);

    $.ajax({

        type: 'GET',

        data: dataEdits,


        url: base_url + 'Tasks/agents/view_agent_task_detail',

        dataType: 'json',

        success: function (data) {
            var tr = "";
            for (var i = 0; i < data.length; i++) {

                $(".editleadgenttask_form .agent_task_id").val(data[i].agent_task_id);
                $(".editleadgenttask_form .assign_to").val(data[i].user_id).change();
                $(".editleadgenttask_form .remarks").text(data[i].remarks);
                $(".editleadgenttask_form .priority").val(data[i].priority);
                $(".editleadgenttask_form .title").val(data[i].lead_id);
            }
        }
    });
});

// start list of tasks
function get_task_datas(user_id = 0, date_assigned = "") {
    let id = user_id;
    let date = date_assigned;
    const dataTableElement = $('#viewtaskdataTable');

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
        // scrollX: true,

        ajax: {
            url: `${base_url}tasks/agents/fetch_agent_view_data_lead/${id}/${date}`,
            type: "GET"
        },
        columns: [
            {
                data: "lead_id",
                render: data => `Lead <br>${String(data).padStart(4, '0')}`
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
                        return `<a href="https://mail.google.com/mail/?view=cm&fs=1&to=${trimmedEmail} " target="_blank">${trimmedEmail} </a>`;
                    }).join('<br>');
                }
            },
            {
                data: "customer_address", render: function (data, type, row) {
                    return data.substring(0, 15);
                }
            },
            { data: "brand_name" },


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


            {
                data: null,
                render: function (data) {
                    return `${data.leadgent_fname} ${data.leadgent_lname}`; // Combine first and last name
                }
            },
            {
                data: null,
                render: function (data) {
                    return `${data.fname} ${data.lname}`; // Combine first and last name
                }
            },
            { data: "lead_status" },

            { data: "agent_priority" },
           
            {
                data: "agent_date_assigned",
                render: formatDate
            },
            { data: "sales_remarks" },
            { data: "remark_tasks" },
            // { 
            //   data: "remarks",
            // },

        ],
        drawCallback: function() {
            // Add event listener to rows after each draw (to handle dynamic row rendering)
            $('#viewtaskdataTable tbody').on('click', 'tr', function() {
              // Remove the highlight (background color) from all rows
              $('#viewtaskdataTable tbody tr').css('background-color', '');
        
              // Set the background color of the clicked row to highlight it
              $(this).css('background-color', 'rgb(211, 234, 253)');  // Change the color as needed (e.g., light green)
            });
          }
    });



}


