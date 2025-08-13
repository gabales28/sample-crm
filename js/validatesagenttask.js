var agenttask_table = $("#agent_taskmodaldatatable").DataTable({
  processing: true,
  serverSide: true,
  fixedColumns: {
    start: 2,
    end: 2,
  },
  scrollCollapse: false,
  scrollX: false,

  dom: 'rt<"d-flex mt-2 mb-2 justify-content-between align-items-center"ip>',
  ajax: {
    url: `${base_url}leads/fetch_lead_limit_agent_data_modal`,
    type: "GET",
    error: function (xhr, error, thrown) {
      console.error("Ajax error: ", error);
      alert("An error occurred while fetching data. Please try again.");

    },
  },
  columns: [
    {
      data: "lead_id",
      render: (data) => `Lead${String(data).padStart(4, "0")}`,
    },
    { data: "customer_name" },
    {
      data: "customer_contact",
      render: function (data) {
        return data
          .split(",")
          .map(
            (contact) => `<a href="tel:${contact.trim()}">${contact.trim()}</a>`
          )
          .join("<br>"); // Converts contact numbers into clickable links
      },
    },
    {
      data: "customer_email",
      render: function (data) {
        return data
          .split(",")
          .map((email) => {
            const trimmedEmail = email.trim();
            return `<a href="https://mail.google.com/mail/?view=cm&fs=1&to=${trimmedEmail}" target="_blank">${trimmedEmail}</a>`;
          })
          .join("<br>");
      },
    },
    {
      data: "customer_address",
      render: function (data, type, row) {
        return data.substring(0, 15);
      },
    },
    { data: "brand_name" },

    {
      data: null,
      render: function (data, type, row) {
        return (
          '<a href="javascript::void();" class="OpenModal view_lead_activity" data-lead_id=' +
          row.lead_id +
          ' data-toggle="modal" data-target="#activityModal">' +
          row.title +
          "</a>"
        );
      },
    },
    // { data: "description" },
    {
      data: "book_link",
      render: function (data, type, row) {
        return (
          '<a href="' +
          data +
          '" target="_blank" rel="noopener noreferrer">' +
          data.substring(0, 15) +
          "</a>"
        );
      },
    },
    { data: "source" },
    { data: "lead_status" },
    {
      data: "date_created",
      render: formatDate,
    },
    {
      data: null,
      render: (data, type, row) =>
        `<input type="checkbox" class="lead-checkbox" data-leadgent_task_id="${row.leadgent_task_id}" data-lead_id="${row.lead_id}" checked>`,
    },
    // Additional columns can be added here
  ],
  drawCallback: function() {
    // Add event listener to rows after each draw (to handle dynamic row rendering)
    $('#agent_taskmodaldatatable tbody').on('click', 'tr', function() {
      // Remove the highlight (background color) from all rows
      $('#agent_taskmodaldatatable tbody tr').css('background-color', '');

      // Set the background color of the clicked row to highlight it
      $(this).css('background-color', 'rgb(211, 234, 253)');  // Change the color as needed (e.g., light green)
    });
  }
});
// Event listener for the custom "Show entries" input
$("#entries_4").on("change", function () {
  var newLength = parseInt($(this).val(), 10);
  if (!isNaN(newLength) && newLength > 0) {
    agenttask_table.page.len(newLength).draw(); // Update page length and redraw table
  }
});
// Event listener for the custom search input
$("#search").on("keyup", function () {
  agenttask_table.search(this.value).draw(); // Update table based on search input
});
// $(".leadgent_statusfilter").on("change", function () {
//   var leadgent_selectLead_Status = $(this).val();
//   agenttask_table.ajax
//     .url(
//       base_url +
//         "leads/fetch_leadgen_limit_data?lead_status=" +
//         leadgent_selectLead_Status
//     )
//     .load();
// });

// start save agent multipletaskform
$("#savemultiplelagentform").on("submit", function (e) {
  e.preventDefault();
  let lead_ids = [];
  let leadgent_task_id = [];
  var checkedCount = $(".lead-checkbox:checked").length;

  if (checkedCount > 0) {
    $(".lead-checkbox:checked").each(function () {
      lead_ids.push($(this).data("lead_id"));
      leadgent_task_id.push($(this).data("leadgent_task_id"));
    });
    $.ajax({
      url: `${base_url}leadgent/sales_agent/save_agent_tasks`,
      type: "POST",
      data: {
        lead_ids: lead_ids,
        leadgent_task_id: leadgent_task_id,
        assign_to: $("#user_id").val(),
        remarks: $("#remarks").val(),
        total_leads: checkedCount,
      },
      success: function (response) {
        let res = JSON.parse(response);
        if (res.response == "success") {
          $("#addmultipleleadgentsTaskModal").animate({ scrollTop: 0 }, "slow");
          //   $("#savemultiplelagentform .alert-danger").removeClass("alert-danger").addClass("alert-success");

          //     $("#savemultiplelagentform .alert-success").css("display", "block");

          // $("#savemultiplelagentform .alert-success p").html(res.message);

          swal({
            title: "Lead Successfully Assigned",
            text: res.message,
            icon: "success",
            buttons: false,
            timer: 2000,
          }).then(() => {
            $("#AssignSalesToLeadgentModal").modal().hide();
            $("body").removeClass("modal-open");
            $(".modal-backdrop").remove();
            setTimeout(function () {
              location.reload();
            }, 1);
          });

          // setTimeout(function(){
          //       location.reload();
          //     }, 1000);
        } else {
          $("#addmultipleleadgentsTaskModal").animate({ scrollTop: 0 }, "slow");

          $("#savemultiplelagentform .alert-success")
            .removeClass("alert-success")
            .addClass("alert-danger");

          $("#savemultiplelagentform .alert-danger").css("display", "block");

          $("#savemultiplelagentform .alert-danger p").html(res.message);

          setTimeout(function () {
            $("#savemultiplelagentform .alert-danger").css("display", "none");
          }, 4000);
        }
      },
    });
  } else {
    $("#addmultipleTaskModal").animate({ scrollTop: 0 }, "slow");
    $("#savemultipleleadgenttaskform .alert-success")
      .removeClass("alert-success")
      .addClass("alert-danger");

    $("#savemultipleleadgenttaskform .alert-danger").css("display", "block");

    $("#savemultipleleadgenttaskform .alert-danger p").html(
      "Please check at least one lead to assign leadgent"
    );

    setTimeout(function () {
      $("#savemultipleleadgenttaskform .alert-danger").css("display", "none");
    }, 4000);
  }

});

var taskstable_agent = $("#taskagentdatatable").DataTable({
  processing: true,
  serverSide: true,
  pageLength: 100, // Default number of entries
  lengthMenu: [100, 200, 500, 1000, 2000, 3000], // Options for entries per page
  fixedColumns: {
    start: 1,
    end: 1,
  },
  scrollCollapse: true,
  scrollX: true,

  ajax: {
    url: base_url + "tasks/fetch_lead_agent_task_limit_data",
    type: "GET",
  },
  columns: [
    {
      data: "lead_id",
      render: function (data) {
        return `Lead${String(data).padStart(4, "0")}`;
      },
    },
    // { data: "brand_name" },
    {
      data: null,
      render: function (data, type, row) {
        return (
          '<a href="javascript::void();" class="OpenModal view_lead_activity" data-lead_id=' +
          row.lead_id +
          ' data-toggle="modal" data-target="#activityModal">' +
          row.title +
          "</a>"
        );
      },
    },
    // { d
    // { data: "description" },
    // { data: "lead_value" },
    {
      data: "book_link",
      render: function (data, type, row) {
        return (
          '<a href="' +
          data +
          '" target="_blank" rel="noopener noreferrer">' +
          data.substring(0, 15) +
          "</a>"
        );
      },
    },
    { data: "source" },
    { data: "customer_name" },
    {
      data: "customer_contact",
      render: function (data) {
        return data
          .split(",")
          .map(
            (contact) => `<a href="tel:${contact.trim()}">${contact.trim()}</a>`
          )
          .join("<br>"); // Converts contact numbers into clickable links
      },
    },
    {
      data: "customer_email",
      render: function (data) {
        return data
          .split(",")
          .map((email) => {
            const trimmedEmail = email.trim();
            return `<a href="https://mail.google.com/mail/?view=cm&fs=1&to=${trimmedEmail}" target="_blank">${trimmedEmail}</a>`;
          })
          .join("<br>");
      },
    },
    {
      data: "customer_address",
      render: function (data, type, row) {
        return data.substring(0, 15);
      },
    },
    { data: "priority" },
    {
      data: null,
      render: function (data) {
        return `${data.agent_fname} ${data.agent_lname}`; // Combine first and last name
      },
    },
    { data: "lead_status" },
    { data: "agent_priority" },
    { data: "services_status" },
    { data: "agent_remarks" },

    // { data: "status_services" },
    { data: "agent_date_assigned", render: formatDate },
    {
      data: "remark_tasks",
      render: function (data, type, row) {
        return data
          ? '<textarea class="form-control edit_remark" style="width: 250px;"  data-lead_id="' +
              row.lead_id +
              '" rows="2" id="comment">' +
              data +
              "</textarea>"
          : '<textarea class="form-control edit_remark"  data-lead_id="' +
              row.lead_id +
              '" rows="4" id="comment"></textarea>';
      },
    },
  ],
  drawCallback: function() {
    // Add event listener to rows after each draw (to handle dynamic row rendering)
    $('#recycledataTable tbody').on('click', 'tr', function() {
      // Remove the highlight (background color) from all rows
      $('#recycledataTable tbody tr').css('background-color', '');

      // Set the background color of the clicked row to highlight it
      $(this).css('background-color', 'rgb(211, 234, 253)');  // Change the color as needed (e.g., light green)
    });
  }
});

function formatDatE_assigned(data) {
  if (!data) return "";
  const date = new Date(data);
  return moment(date).format("YYYY/MM/DD HH:mm:ss");
}

$("#status_task_agent_filters").on("change", function () {
  var selectLead_Status = $(this).val();
  taskstable_agent.ajax
    .url(
      base_url +
        "Tasks/tasks/fetch_lead_agent_task_limit_data?lead_status=" +
        selectLead_Status
    )
    .load();
});

$(document).on("blur ", "#taskagentdatatable .edit_remark", function (e) {
  var lead_id = $(this).data("lead_id");
  var remark = $(this).val();
  $("#dialog").dialog({
    resizable: false,
    height: "auto",
    width: 500,
    modal: true,
    buttons: {
      Yes: function () {
        // Code to delete the item
        $.ajax({
          url: base_url + "tasks/tasks/add_remark",
          type: "POST",
          dataType: "json",
          data: { lead_id: lead_id, remark: remark },
          success: function (response) {
            console.log("Data updated successfully");
          },
          error: function () {
            console.log("Error updating data");
          },
        });
        $(this).dialog("close");
      },
      No: function () {
        $(this).dialog("close");
      },
    },
  });
});

// $(document).ready(function () {
//   $(".add_more_services").on("click", function () {
//     // Create a new row of input fields
//     let newServiceRow = `
//     <div class=" additional-service">
//             <div class="form-row mb-1">
//                 <div class="form-group col-md-4">
//                     <label for="priority">Priority</label>
//                     <select class="form-control agents_priority" name="agents_priority" id="agents_priority">
//                     <option value="" disabled selected>Select a Priority</option>
//                     <option value="Pipe">Pipe</option>
//                     <option value="Closed">Closed</option>
//                     </select>
//                 </div>
//                 <div class="form-group col-md-4">
//                     <label for="ServicesStatus">Services Status</label>
//                     <select class="form-control status_services" name="status_services[]">
//                         <option value="" disabled selected>Select service status</option>
//                         <option value="Publishing">Publishing</option>
//                         <option value="Marketing">Marketing</option>
//                         <option value="Package">Package</option>
//                     </select>
//                 </div>
//                 <div class="form-group col-md-4">
//                     <label for="Remarks">Service Remarks</label>
//                     <select class="form-control agents_remarks" name="agents_remarks[]">
//                         <option value="" disabled selected>Select a Remark</option>
//                         <option value="On Process">On Process</option>
//                         <option value="Completed">Completed</option>
//                     </select>
//                 </div>
//             </div>
//             <div class="form-row mb-1">
//                 <div class="form-group col-md-4">
//                     <label for="PaymentsStatus">Payment Status</label>
//                     <select class="form-control payments_status" name="payments_status[]" id="paymentsStatus">
//                     <option value="" disabled selected>Select a Payment Status</option>
//                     <option value="Initial payment">Initial payment</option>
//                     <option value="Full payment">Full payment</option>
//                     </select>
//                 </div>
//                 <div class="form-group col-md-4">
//                     <label for="PitchedPrices">Pitched Price</label>
//                     <input type="number" class="form-control pitched_prices" placeholder="$0.00" name="pitched_prices[]" id="pitchedPrices">
//                 </div>               
//                 <div class="form-group col-md-4" id="amountContainer">
//                     <label for="Amounts">Amount</label>
//                     <input type="number" class="form-control amounts" name="amounts[]" placeholder="$0.00" id="amounts">
//                 </div>
//                 <input type="hidden" class="current_status_payments" name="current_status_payments" readonly>
//                 <input type="hidden" class="form-control balance " name="balances" id="balances">
                                
//             </div>                

//             <div class="form-row mb-1">
//                 <div class="form-group col-md-8">
//                     <label for="Recordings">Recording URL</label>
//                     <input type="recording" class="form-control recordings" required placeholder="Recording URL" name="recordings"
//                         id="recording" disabled id="recordings">
//                 </div>
//                       <div class="form-group col-md-1 d-flex align-items-end">
//                 <button type="button" class="btn btn-danger remove-service"><i class="fas fa-trash"></i> </button>
                            
//             </div>          
//             </div>
            
                    
// </div>
               
            
//         `;

//     // Prepend the new input fields to the form
//     $("#edit_agent_detail_form").after(newServiceRow);
//   });


// });




$(document).ready(function () {

  $("#editaskagentdataTable").DataTable();
});
// start list of tasks
function get_task_data(user_id = 0, date_assigned = "") {
  let id = user_id;
  let date = date_assigned;
  const dataTableElement = $("#editaskagentdataTable");

  // Destroy existing DataTable instance if it exists
  if ($.fn.DataTable.isDataTable(dataTableElement)) {
    dataTableElement.DataTable().destroy();
  }

  var editagenttask_table = dataTableElement.DataTable({
    processing: true,
    serverSide: true,
    fixedColumns: {
      start: 2,
      end: 1,
    },
    scrollCollapse: true,
    scrollX: true,

    dom: 'rt<"d-flex mt-2 mb-2 justify-content-between align-items-center"ip>',
    ajax: {
      url: `${base_url}leadgent/sales_agent/fetch_agent_view_data/${id}/${date}`,
      type: "GET",
    },
    columns: [
      {
        data: "lead_id",
        render: (data) => `Lead${String(data).padStart(4, "0")}`,
      },
      { data: "customer_name" },
      {
        data: "customer_contact",
        render: function (data) {
          return data
            .split(",")
            .map(
              (contact) =>
                `<a href="tel:${contact.trim()}">${contact.trim()}</a>`
            )
            .join("<br>"); // Converts contact numbers into clickable links
        },
      },
      {
        data: "customer_email",
        render: function (data) {
          return data
            .split(",")
            .map((email) => {
              const trimmedEmail = email.trim();
              return `<a href="https://mail.google.com/mail/?view=cm&fs=1&to=${trimmedEmail}" target="_blank">${trimmedEmail}</a>`;
            })
            .join("<br>");
        },
      },
      {
        data: "customer_address",
        render: function (data, type, row) {
          return data.substring(0, 15);
        },
      },
      { data: "brand_name" },

      {
        data: null,
        render: function (data, type, row) {
          return (
            '<a href="javascript::void();" class="OpenModal view_lead_activity" data-lead_id=' +
            row.lead_id +
            ' data-toggle="modal" data-target="#activityModal">' +
            row.title +
            "</a>"
          );
        },
      },
      {
        data: "book_link",
        render: function (data, type, row) {
          return (
            '<a href="' +
            data +
            '" target="_blank" rel="noopener noreferrer">' +
            data.substring(0, 15) +
            "</a>"
          );
        },
      },
      { data: "source" },
      { data: "agent_priority" },
      { data: "lead_status" },

      {
        data: "agent_date_assigned",
        render: formatDate,
      },
      {
        data: null,
        render: (data, type, row) =>
          `<input type="checkbox" class="task-checkbox" data-lead_id="${row.lead_id}" data-task_id="${row.agent_task_id}" checked><input type="hidden" readonly name="get_agent_task_id[]" value ="${row.agent_task_id}"><input type="hidden" name="lead_id[]" readonly value="${row.lead_id}">`,
      },
    ],
  });
  // Event listener for the custom "Show entries" input
  $("#entries_5").on("change", function () {
    var newLength = parseInt($(this).val(), 10);
    if (!isNaN(newLength) && newLength > 0) {
      editagenttask_table.page.len(newLength).draw(); // Update page length and redraw table
    }
  });
  // Event listener for the custom search input
  $("#search").on("keyup", function () {
    editagenttask_table.search(this.value).draw(); // Update table based on search input
  });
}

$(document).ready(function () {
  $("#recycledataTable").DataTable();
});
// start list of tasks
function get_task_recycle_data(user_id = 0, date_assigned = "") {
  let id = user_id;
  let date = date_assigned;
  const dataTableElement2 = $("#recycledataTable");

  // Destroy existing DataTable instance if it exists
  if ($.fn.DataTable.isDataTable(dataTableElement2)) {
    dataTableElement2.DataTable().destroy();
  }

  var recycle_table = dataTableElement2.DataTable({
    processing: true,
    serverSide: false,
    fixedColumns: {
      start: 2,
      end: 1,
    },
    scrollCollapse: true,
    scrollX: true,

    dom: 'rt<"d-flex mt-2 mb-2 justify-content-between align-items-center"ip>',
    ajax: {
      url: `${base_url}leadgent/sales_agent/fetch_agent_view_recycle_data/${id}/${date}`,
      type: "GET",
    },
    columns: [
      {
        data: "lead_id",
        render: (data) => `Lead${String(data).padStart(4, "0")}`,
      },
      { data: "customer_name" },
      {
        data: "customer_contact",
        render: function (data) {
          return data
            .split(",")
            .map(
              (contact) =>
                `<a href="tel:${contact.trim()}">${contact.trim()}</a>`
            )
            .join("<br>"); // Converts contact numbers into clickable links
        },
      },
      {
        data: "customer_email",
        render: function (data) {
          return data
            .split(",")
            .map((email) => {
              const trimmedEmail = email.trim();
              return `<a href="https://mail.google.com/mail/?view=cm&fs=1&to=${trimmedEmail}" target="_blank">${trimmedEmail}</a>`;
            })
            .join("<br>");
        },
      },
      {
        data: "customer_address",
        render: function (data, type, row) {
          return data.substring(0, 15);
        },
      },
      { data: "brand_name" },

      {
        data: null,
        render: function (data, type, row) {
          return (
            '<a href="javascript::void();" class="OpenModal view_lead_activity" data-lead_id=' +
            row.lead_id +
            ' data-toggle="modal" data-target="#activityModal">' +
            row.title +
            "</a>"
          );
        },
      },
      {
        data: "book_link",
        render: function (data, type, row) {
          return (
            '<a href="' +
            data +
            '" target="_blank" rel="noopener noreferrer">' +
            data.substring(0, 15) +
            "</a>"
          );
        },
      },
      { data: "source" },
      { data: "agent_priority" },
      { data: "lead_status" },

      {
        data: "agent_date_assigned",
        render: formatDate,
      },
      { data: "sales_remarks" },

      {
        data: null,
        render: (data, type, row) =>
          `<input type="checkbox" class="task-checkbox" data-lead_id="${row.lead_id}" data-task_id="${row.agent_task_id}" check><input type="hidden" readonly name="get_agent_task_id[]" value ="${row.agent_task_id}"><input type="hidden" name="lead_id[]" readonly value="${row.lead_id}">`,
      },
    ],
    drawCallback: function() {
      // Add event listener to rows after each draw (to handle dynamic row rendering)
      $('#return_lead_controldataTable tbody').on('click', 'tr', function() {
        // Remove the highlight (background color) from all rows
        $('#return_lead_controldataTable tbody tr').css('background-color', '');
  
        // Set the background color of the clicked row to highlight it
        $(this).css('background-color', 'rgb(211, 234, 253)');  // Change the color as needed (e.g., light green)
      });
    }
  });
  // Event listener for the custom "Show entries" input
  $("#entriesnum_1").on("change", function () {
    var newLength = parseInt($(this).val(), 10);
    if (!isNaN(newLength) && newLength > 0) {
      recycle_table.page.len(newLength).draw(); // Update page length and redraw table
    }
  });
  // Event listener for the custom search input
  $("#search_recycle_lead").on("keyup", function () {
    recycle_table.search(this.value).draw(); // Update table based on search input
  });
}

// $(document).on("click", ".edit_agent_task", function(e){

//     e.preventDefault();

//       var taskid= $(this).data('task_id');
//       var user_id= $(this).data('user_id');
//       var date_assigned= $(this).data('date_assigned');
//       dataEdit = 'agent_task_id='+ taskid;

//        get_task_data(user_id, date_assigned);
//         $.ajax({

//         type:'GET',

//         data:dataEdit,

//         url: base_url +'leadgent/view_sales_tasks/view_agent_tasks_detail',

//         dataType: 'json',

//         success:function(data){
//             var tr ="";
//             for (var i = 0; i < data.length; i++) {

//                $(".view_editagenttask_form .assign_to").val(data[i].user_id).change();
//                $(".view_editagenttask_form .existing_user_id").val(data[i].user_id).text();

//              }
//           }
//        });
//   });
// update agent task
//    $('#updateagentask_form').on('submit', function(e) {
//     e.preventDefault(); // Prevent default form submission

//     let checkedTasks = [];
//     let uncheckedTasks = [];
//     let uncheckedLeads = [];

//     $('.task-checkbox').each(function() {
//         let taskId = $(this).data('task_id');
//         let leadId = $(this).data('lead_id');
//         if ($(this).is(':checked')) {
//             checkedTasks.push(taskId);
//         } else {
//             uncheckedTasks.push(taskId);
//             uncheckedLeads.push(leadId);
//         }
//     });

//     // $('.priority-dropdown').each(function() {
//     //     let taskId = $(this).data('task_id');
//     //     let selectedPriority = $(this).val();
//     //     priorityUpdates[taskId] = selectedPriority; // Store priority updates
//     // });

//     $.ajax({
//         url: `${base_url}leadgent/view_sales_tasks/update_agent_taskss`,
//         type: "POST",
//         data: $(this).serialize() +
//               '&checked_tasks=' + checkedTasks +
//               '&unchecked_tasks=' + uncheckedTasks +
//               '&unchecked_Lead=' + uncheckedLeads,
//         dataType: 'json',
//         success: function(res) {
//             if (res.response == 'success') {
//                 $("#editlistoftask").animate({ scrollTop: 0 }, "slow")
//                 $("#updateagentask_form .alert-danger").removeClass("alert-danger").addClass("alert-success");
//                 $("#updateagentask_form .alert-success").css("display", "block");
//                 $("#updateagentask_form .alert-success p").html(res.message);

//                 setTimeout(function(){
//                     location.reload();
//                 }, 1000);
//             } else {
//               $("#editlistoftask").animate({ scrollTop: 0 }, "slow")
//                 $("#updateagentask_form .alert-success").removeClass("alert-success").addClass("alert-danger");
//                 $("#updateagentask_form .alert-danger").css("display", "block");
//                 $("#updateagentask_form .alert-danger p").html(res.message);

//                 setTimeout(function(){
//                     $("#updateagentask_form .alert-danger").css("display", "none");
//                 }, 4000);
//             }
//         }
//     });
// });
// end save multipletaskform
$(document).on("click", ".edit_agent_task", function (e) {
  e.preventDefault();

  var taskid = $(this).data("task_id");
  var user_id = $(this).data("user_id");
  var date_assigned = $(this).data("date_assigned");
  dataEdit = "agent_task_id=" + taskid;

  get_task_data(user_id, date_assigned);
  $.ajax({
    type: "GET",

    data: dataEdit,

    url: base_url + "leadgent/sales_agent/view_agent_task_detail",

    dataType: "json",

    success: function (data) {
      var tr = "";
      for (var i = 0; i < data.length; i++) {
        $(".editagenttask_form .assign_to").val(data[i].user_id).change();
        $(".editagenttask_form .existing_user_id").val(data[i].user_id).text();
      }
    },
  });
});

$(document).on("click", ".recycle", function (e) {
  e.preventDefault();

  var taskid = $(this).data("task_id");
  var user_id = $(this).data("user_id");
  // var leadgent_user_id = $(this).data('leadgent_user_id');
  var date_assigned = $(this).data("date_assigned");
  dataEdit = "agent_task_id=" + taskid;

  get_task_recycle_data(user_id, date_assigned);
  $.ajax({
    type: "GET",

    data: dataEdit,

    url: base_url + "leadgent/sales_agent/view_agent_recycle_task_detail",

    dataType: "json",

    success: function (data) {
      var tr = "";
      for (var i = 0; i < data.length; i++) {
        $(".recycle_form .assign_to").val(data[i].user_id).change();
        $(".recycle_form .existing_user_id").val(data[i].user_id).text();
        $(".recycle_form .lead_id").val(data[i].lead_id).text();
        $(".recycle_form [name='leadgent_user_id']").val(
          data[i].leadgent_user_id
        );
        $(".recycle_form [name='previous_agent']").val(
          data[i].fname + " " + data[i].lname
        );
        $(".recycle_form .agent_task_id").val(data[i].agent_task_id).text();
      }
    },
  });
});

// update agent task
$("#updateagentask_form").on("submit", function (e) {
  e.preventDefault(); // Prevent default form submission

  let checkedTasks = [];
  let uncheckedTasks = [];
  let uncheckedLeads = [];

  $(".task-checkbox").each(function () {
    let taskId = $(this).data("task_id");
    let leadId = $(this).data("lead_id");
    if ($(this).is(":checked")) {
      checkedTasks.push(taskId);
    } else {
      uncheckedTasks.push(taskId);
      uncheckedLeads.push(leadId);
    }
  });

  // $('.priority-dropdown').each(function() {
  //     let taskId = $(this).data('task_id');
  //     let selectedPriority = $(this).val();
  //     priorityUpdates[taskId] = selectedPriority; // Store priority updates
  // });

  $.ajax({
    url: `${base_url}leadgent/sales_agent/update_agent_tasks`,
    type: "POST",
    data:
      $(this).serialize() +
      "&checked_tasks=" +
      checkedTasks +
      "&unchecked_tasks=" +
      uncheckedTasks +
      "&unchecked_Lead=" +
      uncheckedLeads,
    dataType: "json",
    success: function (res) {
      if (res.response == "success") {
        $("#editlistoftask").animate({ scrollTop: 0 }, "slow");
        // $("#updateagentask_form .alert-danger").removeClass("alert-danger").addClass("alert-success");
        // $("#updateagentask_form .alert-success").css("display", "block");
        // $("#updateagentask_form .alert-success p").html(res.message);

        swal({
          title: "Lead Successfully Updated",
          text: res.message,
          icon: "success",
          buttons: false,
          timer: 2000,
        }).then(() => {
          $("body").removeClass("modal-open");
          $(".modal-backdrop").remove();
          setTimeout(function () {
            location.reload();
          }, 1);
        });

        // setTimeout(function(){
        //     location.reload();
        // }, 1000);
      } else {
        $("#editlistoftask").animate({ scrollTop: 0 }, "slow");
        $("#updateagentask_form .alert-success")
          .removeClass("alert-success")
          .addClass("alert-danger");
        $("#updateagentask_form .alert-danger").css("display", "block");
        $("#updateagentask_form .alert-danger p").html(res.message);

        setTimeout(function () {
          $("#updateagentask_form .alert-danger").css("display", "none");
        }, 4000);
      }
    },
  });
});

// insert to tbl recycle agent task
$("#save_recycle_lead_form").on("submit", function (e) {
  e.preventDefault(); // Prevent default form submission

  let checkedTasks = [];
  let uncheckedTasks = [];
  let uncheckedLeads = [];
  let checkedLeads = [];

  $(".task-checkbox").each(function () {
    let taskId = $(this).data("task_id");
    let leadId = $(this).data("lead_id");

    if ($(this).is(":checked")) {
      checkedTasks.push(taskId);
      uncheckedLeads.push(leadId);
      checkedLeads.push(leadId);
    } else {
      uncheckedTasks.push(taskId);
      uncheckedLeads.push(leadId);
      uncheckedLeads.push(leadId);
    }
  });

  // $('.priority-dropdown').each(function() {
  //     let taskId = $(this).data('task_id');
  //     let selectedPriority = $(this).val();
  //     priorityUpdates[taskId] = selectedPriority; // Store priority updates
  // });

  $.ajax({
    url: `${base_url}leadgent/sales_agent/save_recyle`,
    type: "POST",
    data:
      $(this).serialize() +
      "&checked_tasks=" +
      checkedTasks +
      "&unchecked_tasks=" +
      uncheckedTasks +
      "&unchecked_Lead=" +
      uncheckedLeads +
      "&checked_Lead=" +
      checkedLeads,
    dataType: "json",
    success: function (res) {
      if (res.response == "success") {
        $("#recycle").animate({ scrollTop: 0 }, "slow");
        // $("#updateagentask_form .alert-danger").removeClass("alert-danger").addClass("alert-success");
        // $("#updateagentask_form .alert-success").css("display", "block");
        // $("#updateagentask_form .alert-success p").html(res.message);

        swal({
          title: "Lead Successfully Updated",
          text: res.message,
          icon: "success",
          buttons: false,
          timer: 2000,
        }).then(() => {
          $("body").removeClass("modal-open");
          $(".modal-backdrop").remove();
          setTimeout(function () {
            location.reload();
          }, 1);
        });


        // setTimeout(function(){
        //     location.reload();
        // }, 1000);
      } else {
        $("#recycle").animate({ scrollTop: 0 }, "slow");
        $("#save_recycle_lead_form .alert-success")
          .removeClass("alert-success")
          .addClass("alert-danger");
        $("#save_recycle_lead_form .alert-danger").css("display", "block");
        $("#save_recycle_lead_form .alert-danger p").html(res.message);


        setTimeout(function () {
          $("#save_recycle_lead_form .alert-danger").css("display", "none");
        }, 4000);
      }
    },
  });
});

// var taskstable_agent = $("#taskagentdatatable").DataTable({
//   processing: true,
//   serverSide: true,
//   pageLength: 100, // Default number of entries
//   lengthMenu: [100, 200, 500, 1000, 2000, 3000], // Options for entries per page
//   fixedColumns: {
//     start: 2,
//     end: 2,
//   },
//   scrollCollapse: true,
//   scrollX: true,

//   ajax: {
//     url: base_url + "tasks/fetch_lead_agent_task_limit_data",
//     type: "GET",
//   },
//   columns: [
//     {
//       data: "lead_id",
//       render: function (data) {
//         return `Lead${String(data).padStart(4, "0")}`;
//       },
//     },
//     { data: "brand_name" },
//     {
//       data: null,
//       render: function (data, type, row) {
//         return (
//           '<a href="javascript::void();" class="OpenModal view_lead_activity" data-lead_id=' +
//           row.lead_id +
//           ' data-toggle="modal" data-target="#activityModal">' +
//           row.title +
//           "</a>"
//         );
//       },
//     },
//     // { d
//     // { data: "description" },
//     // { data: "lead_value" },
//     {
//       data: "book_link",
//       render: function (data, type, row) {
//         return (
//           '<a href="' +
//           data +
//           '" target="_blank" rel="noopener noreferrer">' +
//           data.substring(0, 15) +
//           "</a>"
//         );
//       },
//     },
//     { data: "source" },
//     { data: "customer_name" },
//     {
//       data: "customer_contact",
//       render: function (data) {
//         return data
//           .split(",")
//           .map(
//             (contact) => `<a href="tel:${contact.trim()}">${contact.trim()}</a>`
//           )
//           .join("<br>"); // Converts contact numbers into clickable links
//       },
//     },
//     {
//       data: "customer_email",
//       render: function (data) {
//         return data
//           .split(",")
//           .map((email) => {
//             const trimmedEmail = email.trim();
//             return `<a href="https://mail.google.com/mail/?view=cm&fs=1&to=${trimmedEmail}" target="_blank">${trimmedEmail}</a>`;
//           })
//           .join("<br>");
//       },
//     },
//     {
//       data: "customer_address",
//       render: function (data, type, row) {
//         return data.substring(0, 15);
//       },
//     },
//     { data: "priority" },
//     {
//       data: null,
//       render: function (data) {
//         return `${data.agent_fname} ${data.agent_lname}`; // Combine first and last name
//       },
//     },
//     { data: "lead_status" },
//     { data: "agent_priority" },
//     { data: "services_status" },
//     { data: "agent_remarks" },

//     // { data: "status_services" },
//     { data: "agent_date_assigned", render: formatDate },
//     {
//       data: "remark_tasks",
//       render: function (data, type, row) {
//         return data
//           ? '<textarea class="form-control edit_remark" style="width: 250px;"  data-lead_id="' +
//               row.lead_id +
//               '" rows="4" id="comment">' +
//               data +
//               "</textarea>"
//           : '<textarea class="form-control edit_remark"  data-lead_id="' +
//               row.lead_id +
//               '" rows="4" id="comment"></textarea>';
//       },
//     },
//   ],
//   drawCallback: function() {
//     // Add event listener to rows after each draw (to handle dynamic row rendering)
//     $('#return_lead_controldataTable tbody').on('click', 'tr', function() {
//       // Remove the highlight (background color) from all rows
//       $('#return_lead_controldataTable tbody tr').css('background-color', '');

//       // Set the background color of the clicked row to highlight it
//       $(this).css('background-color', 'rgb(211, 234, 253)');  // Change the color as needed (e.g., light green)
//     });
//   }
// });

function formatDatE_assigned(data) {
  if (!data) return "";
  const date = new Date(data);
  return moment(date).format("YYYY/MM/DD HH:mm:ss");
}

$("#status_task_agent_filters").on("change", function () {
  var selectLead_Status = $(this).val();
  taskstable_agent.ajax
    .url(
      base_url +
        "Tasks/tasks/fetch_lead_agent_task_limit_data?lead_status=" +
        selectLead_Status
    )
    .load();
});

// $(document).on("blur ", "#taskagentdatatable .edit_remark", function (e) {
//   var lead_id = $(this).data("lead_id");
//   var remark = $(this).val();
//   $("#dialog").dialog({
//     resizable: false,
//     height: "auto",
//     width: 500,
//     modal: true,
//     buttons: {
//       Yes: function () {
//         // Code to delete the item
//         $.ajax({
//           url: base_url + "tasks/tasks/add_remark",
//           type: "POST",
//           dataType: "json",
//           data: { lead_id: lead_id, remark: remark },
//           success: function (response) {
//             console.log("Data updated successfully");
//           },
//           error: function () {
//             console.log("Error updating data");
//           },
//         });
//         $(this).dialog("close");
//       },
//       No: function () {
//         $(this).dialog("close");
//       },
//     },
//   });
// });

// $(document).ready(function () {
//   $(".add_more_services").on("click", function () {
//     // Create a new row of input fields
//     let newServiceRow = `
//     <div class=" additional-service">
//             <div class="form-row mb-1">
//                 <div class="form-group col-md-4">
//                     <label for="priority">Priority</label>
//                     <select class="form-control agents_priority" name="agents_priority" id="agents_priority">
//                     <option value="" disabled selected>Select a Priority</option>
//                     <option value="Pipe">Pipe</option>
//                     <option value="Closed">Closed</option>
//                     </select>
//                 </div>
//                 <div class="form-group col-md-4">
//                     <label for="ServicesStatus">Services Status</label>
//                     <select class="form-control status_services" name="status_services[]">
//                         <option value="" disabled selected>Select service status</option>
//                         <option value="Publishing">Publishing</option>
//                         <option value="Marketing">Marketing</option>
//                         <option value="Package">Package</option>
//                     </select>
//                 </div>
//                 <div class="form-group col-md-4">
//                     <label for="Remarks">Service Remarks</label>
//                     <select class="form-control agents_remarks" name="agents_remarks[]">
//                         <option value="" disabled selected>Select a Remark</option>
//                         <option value="On Process">On Process</option>
//                         <option value="Completed">Completed</option>
//                     </select>
//                 </div>
//             </div>
//             <div class="form-row mb-1">
//                 <div class="form-group col-md-4">
//                     <label for="PaymentsStatus">Payment Status</label>
//                     <select class="form-control payments_status" name="payments_status[]" id="paymentsStatus">
//                     <option value="" disabled selected>Select a Payment Status</option>
//                     <option value="Initial payment">Initial payment</option>
//                     <option value="Full payment">Full payment</option>
//                     </select>
//                 </div>
//                 <div class="form-group col-md-4">
//                     <label for="PitchedPrices">Pitched Price</label>
//                     <input type="number" class="form-control pitched_prices" placeholder="$0.00" name="pitched_prices[]" id="pitchedPrices">
//                 </div>               
//                 <div class="form-group col-md-4" id="amountContainer">
//                     <label for="Amounts">Amount</label>
//                     <input type="number" class="form-control amounts" name="amounts[]" placeholder="$0.00" id="amounts">
//                 </div>
//                 <input type="hidden" class="current_status_payments" name="current_status_payments" readonly>
//                 <input type="hidden" class="form-control balance " name="balances" id="balances">
                                
//             </div>                

//             <div class="form-row mb-1">
//                 <div class="form-group col-md-8">
//                     <label for="Recordings">Recording URL</label>
//                     <input type="recording" class="form-control recordings" required placeholder="Recording URL" name="recordings"
//                         id="recording" disabled id="recordings">
//                 </div>
//                       <div class="form-group col-md-1 d-flex align-items-end">
//                 <button type="button" class="btn btn-danger remove-service"><i class="fas fa-trash"></i> </button>
                            
//             </div>          
//             </div>
            
                    
// </div>
               
            
//         `;

//     // Prepend the new input fields to the form
//     $("#edit_agent_detail_form").after(newServiceRow);
//   });

//   // Function to remove dynamically added service rows
//   $(document).on("click", ".remove-service", function () {
//     $(this).closest(".additional-service").remove();
//   });
// });

$(document).ready(function () {
    $('#return_lead_controldataTable').DataTable();
})
// start list of tasks
function get_return_to_lead_control_data(user_id = 0, date_assigned = "") {
    let id = user_id;
    let date = date_assigned;
    const dataTableElement8 = $('#return_lead_controldataTable');

    // Destroy existing DataTable instance if it exists
    if ($.fn.DataTable.isDataTable(dataTableElement8)) {
        dataTableElement8.DataTable().destroy();
    }

    var get_return_to_lead_control = dataTableElement8.DataTable({
        processing: true,
        serverSide: false,
        fixedColumns: {
            start: 2,
            end: 1
        },
        scrollCollapse: true,
        scrollX: true,

        "dom": 'rt<"d-flex mt-2 mb-2 justify-content-between align-items-center"ip>',
        ajax: {
            url: `${base_url}leadgent/sales_agent/fetch_agent_view_recycle_data/${id}/${date}`,
            type: "GET"
        },
        columns: [
            {
                data: "lead_id",
                render: data => `Lead${String(data).padStart(4, '0')}`
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
            { data: "source" },
            { data: "agent_priority" },
            { data: "lead_status" },

            {
                data: "agent_date_assigned",
                render: formatDate
            },
            { data: "sales_remarks" },
            {
                data: null,
                render: (data, type, row) =>
                    `<input type="checkbox" class="task-checkbox" data-lead_id="${row.lead_id}" data-task_id="${row.agent_task_id}" checked><input type="hidden" readonly name="get_agent_task_id[]" value ="${row.agent_task_id}"><input type="hidden" name="lead_id[]" readonly value="${row.lead_id}">`
            }
        ],
        drawCallback: function() {
          // Add event listener to rows after each draw (to handle dynamic row rendering)
          $('#return_lead_controldataTable tbody').on('click', 'tr', function() {
            // Remove the highlight (background color) from all rows
            $('#return_lead_controldataTable tbody tr').css('background-color', '');
      
            // Set the background color of the clicked row to highlight it
            $(this).css('background-color', 'rgb(211, 234, 253)');  // Change the color as needed (e.g., light green)
          });
        }

    });
    // Event listener for the custom "Show entries" input
    $('#entriesnum_10').on('change', function () {
        var newLength = parseInt($(this).val(), 10);
        if (!isNaN(newLength) && newLength > 0) {
            get_return_to_lead_control.page.len(newLength).draw(); // Update page length and redraw table
        }
    });
    // Event listener for the custom search input
    $('#search_return_lead_control').on('keyup', function () {
        get_return_to_lead_control.search(this.value).draw(); // Update table based on search input
    });

}



$(document).on("click", ".return_lead_control", function (e) {

    e.preventDefault();

    var taskid = $(this).data('task_id');
    var user_id = $(this).data('user_id');
    // var leadgent_user_id = $(this).data('leadgent_user_id');
    var date_assigned = $(this).data('date_assigned');
    dataEdit = 'agent_task_id=' + taskid;

    get_return_to_lead_control_data(user_id, date_assigned);
    $.ajax({

        type: 'GET',

        data: dataEdit,

        url: base_url + 'leadgent/sales_agent/view_agent_recycle_task_detail',

        dataType: 'json',

        success: function (data) {
            var tr = "";
            for (var i = 0; i < data.length; i++) {

                $(".return_lead_control_form .assign_to").val(data[i].user_id).change();
                $(".return_lead_control_form .existing_user_id").val(data[i].user_id).text();
                $(".return_lead_control_form .lead_id").val(data[i].lead_id).text();
                $(".return_lead_control_form [name='leadgent_user_id']").val(data[i].leadgent_user_id);
                $(".return_lead_control_form [name='previous_agent']").val(data[i].fname +' '+ data[i].lname);
                $(".return_lead_control_form .agent_task_id").val(data[i].agent_task_id).text();

            }
        }
    });
});




// insert
$('#save_return_lead_control_form').on('submit', function (e) {
    e.preventDefault(); // Prevent default form submission

    let checkedTasks = [];
    let uncheckedTasks = [];
    let uncheckedLeads = [];
    let checkedLeads = [];

    $('.task-checkbox').each(function () {
        let taskId = $(this).data('task_id');
        let leadId = $(this).data('lead_id');

        if ($(this).is(':checked')) {
            checkedTasks.push(taskId);
            uncheckedLeads.push(leadId);
            checkedLeads.push(leadId);

        } else {
            uncheckedTasks.push(taskId);
            uncheckedLeads.push(leadId);
            uncheckedLeads.push(leadId);

        }
    });

    // $('.priority-dropdown').each(function() {
    //     let taskId = $(this).data('task_id');
    //     let selectedPriority = $(this).val();
    //     priorityUpdates[taskId] = selectedPriority; // Store priority updates
    // });

    $.ajax({
        url: `${base_url}recycle/recycled_leads/save_return_lead_control_form`,
        type: "POST",
        data: $(this).serialize() +
            '&checked_tasks=' + checkedTasks +
            '&unchecked_tasks=' + uncheckedTasks +
            '&unchecked_Lead=' + uncheckedLeads+
            '&checked_Lead=' + checkedLeads,
        dataType: 'json',
        success: function (res) {
            if (res.response == 'success') {
                $("#return-lead-control").animate({ scrollTop: 0 }, "slow")
                // $("#updateagentask_form .alert-danger").removeClass("alert-danger").addClass("alert-success");
                // $("#updateagentask_form .alert-success").css("display", "block");
                // $("#updateagentask_form .alert-success p").html(res.message);

                swal({
                    title: "Lead Successfully Returned",
                    text: res.message,
                    icon: "success",
                    buttons: false,
                    timer: 2000
                }).then(() => {
                    $('body').removeClass('modal-open');
                    $('.modal-backdrop').remove();
                    setTimeout(function () {
                        location.reload();
                    }, 1);
                });

                // setTimeout(function(){
                //     location.reload();
                // }, 1000);
            } else {
                $("#return-lead-control").animate({ scrollTop: 0 }, "slow")
                $("#save_return_lead_control_form .alert-success").removeClass("alert-success").addClass("alert-danger");
                $("#save_return_lead_control_form .alert-danger").css("display", "block");
                $("#save_return_lead_control_form .alert-danger p").html(res.message);

                setTimeout(function () {
                    $("#save_return_lead_control_form .alert-danger").css("display", "none");
                }, 4000);
            }
        }
    });
});



$(document).ready(function () {
    $('#return_lead_backetdataTable').DataTable();
})
// start list of tasks
function get_return_to_backet_data(user_id = 0, date_assigned = "") {
    let id = user_id;
    let date = date_assigned;
    const dataTableElement10 = $('#return_lead_backetdataTable');

    // Destroy existing DataTable instance if it exists
    if ($.fn.DataTable.isDataTable(dataTableElement10)) {
        dataTableElement10.DataTable().destroy();
    }

    var get_return_to_backet = dataTableElement10.DataTable({
        processing: true,
        serverSide: false,
        fixedColumns: {
            start: 2,
            end: 1
        },
        scrollCollapse: true,
        scrollX: true,

        "dom": 'rt<"d-flex mt-2 mb-2 justify-content-between align-items-center"ip>',
        ajax: {
            url: `${base_url}recycle/recycled_leads/fetch_recycled_leads_data/${id}/${date}`,
            type: "GET"
        },
        columns: [
            {
                data: "lead_id",
                render: data => `Lead${String(data).padStart(4, '0')}`
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
            { data: "source" },
            // { data: "agent_priority" },
            { data: "lead_status" },

            {
                data: "agent_date_assigned",
                render: formatDate
            },
            {
                data: null,
                render: (data, type, row) =>
                    `<input type="checkbox" class="task-checkbox" data-lead_id="${row.lead_id}" data-return_to_lead_control_id="${row.return_to_lead_control_id}" checked><input type="hidden" readonly name="get_agent_task_id[]" value ="${row.agent_task_id}"><input type="hidden" name="lead_id[]" readonly value="${row.lead_id}">`
            }
        ]

    });
    // Event listener for the custom "Show entries" input
    $('#entriesnum_1').on('change', function () {
        var newLength = parseInt($(this).val(), 10);
        if (!isNaN(newLength) && newLength > 0) {
            get_return_to_backet.page.len(newLength).draw(); // Update page length and redraw table
        }
    });
    // Event listener for the custom search input
    $('#search_recycle').on('keyup', function () {
        get_return_to_backet.search(this.value).draw(); // Update table based on search input
    });

}


$(document).on("click", ".return_to_backet", function (e) {

    e.preventDefault();

    var taskid = $(this).data('task_id');
    var user_id = $(this).data('user_id');
    // var leadgent_user_id = $(this).data('leadgent_user_id');
    var date_assigned = $(this).data('date_assigned');
    dataEdit = 'agent_task_id=' + taskid;

    get_return_to_backet_data(user_id, date_assigned);
    $.ajax({

        type: 'GET',

        data: dataEdit,

        url: base_url + 'recycle/recycled_leads/view_recycled_lead_details',

        dataType: 'json',

        success: function (data) {
            var tr = "";
            for (var i = 0; i < data.length; i++) {

                // $(".return_lead_backet_form .assign_to").val(data[i].user_id).change();
                // $(".return_lead_backet_form .existing_user_id").val(data[i].user_id).text();
                $(".return_lead_backet_form .lead_id").val(data[i].lead_id).text();
                // $(".return_lead_backet_form [name='leadgent_user_id']").val(data[i].leadgent_user_id);
                // $(".return_lead_backet_form [name='previous_agent']").val(data[i].fname +' '+ data[i].lname);
                $(".return_lead_backet_form .return_to_lead_control_id").val(data[i].return_to_lead_control_id).text();

            }
        }
    });
});


//update recycled leads
$('#update_return_lead_backet_form').on('submit', function (e) {
    e.preventDefault(); // Prevent default form submission

    let checkedTasks = [];
    let uncheckedTasks = [];
    let uncheckedLeads = [];
    let checkedLeads = [];

    $('.task-checkbox').each(function () {
        let taskId = $(this).data('return_to_lead_control_id');
        let leadId = $(this).data('lead_id');

        if ($(this).is(':checked')) {
            checkedTasks.push(taskId);
            uncheckedLeads.push(leadId);
            checkedLeads.push(leadId);

        } else {
            uncheckedTasks.push(taskId);
            uncheckedLeads.push(leadId);
            uncheckedLeads.push(leadId);

        }
    });

    // $('.priority-dropdown').each(function() {
    //     let taskId = $(this).data('task_id');
    //     let selectedPriority = $(this).val();
    //     priorityUpdates[taskId] = selectedPriority; // Store priority updates
    // });

    $.ajax({
        url: `${base_url}recycle/recycled_leads/update_return_lead_backet_data`,
        type: "POST",
        data: $(this).serialize() +
            '&checked_tasks=' + checkedTasks +
            '&unchecked_tasks=' + uncheckedTasks +
            '&unchecked_Lead=' + uncheckedLeads+
            '&checked_Lead=' + checkedLeads,
        dataType: 'json',
        success: function (res) {
            if (res.response == 'success') {
                $("#view-return-lead-control").animate({ scrollTop: 0 }, "slow")
                // $("#updateagentask_form .alert-danger").removeClass("alert-danger").addClass("alert-success");
                // $("#updateagentask_form .alert-success").css("display", "block");
                // $("#updateagentask_form .alert-success p").html(res.message);

                swal({
                    title: "Lead Successfully Returned",
                    text: res.message,
                    icon: "success",
                    buttons: false,
                    timer: 2000
                }).then(() => {
                    $('body').removeClass('modal-open');
                    $('.modal-backdrop').remove();
                    setTimeout(function () {
                        location.reload();
                    }, 1);
                });

                // setTimeout(function(){
                //     location.reload();
                // }, 1000);
            } else {
                $("#view-return-lead-control").animate({ scrollTop: 0 }, "slow")
                $("#update_return_lead_control_form .alert-success").removeClass("alert-success").addClass("alert-danger");
                $("#update_return_lead_control_form .alert-danger").css("display", "block");
                $("#update_return_lead_control_form .alert-danger p").html(res.message);

                setTimeout(function () {
                    $("#update_return_lead_control_form .alert-danger").css("display", "none");
                }, 4000);
            }
        }
    });
});

