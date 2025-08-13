var table = $("#leaddatatable").DataTable({
  processing: true,
  serverSide: true,
  "pageLength": 10,  //\\ Default number of entries
  "lengthMenu": [10, 30, 50, 100, 200, 300, 400, 500, 2000],  // Options for entries per page
  // dom: 'rt<"d-flex mt-2 mb-2 justify-content-between align-items-center"ip>', // Removes the default length menu control
  ajax: {
    url: base_url + "leads/fetch_lead_limit_data",
    type: "GET",
  },
  fixedColumns: {
      start: 2,
      end: 1,
  },
  scrollCollapse: true,
  scrollX: true,
  
  columns: [
    {
      data: "lead_id",
      render: function (data, type, row, meta) {
        // Add background color if lead_status_assign is 1
        var leadIdMarkup = 'Lead' + String(data).padStart(4, "0");
        
        // Return the formatted lead_id as usual
        if (row.lead_status_assign == 1) {
          return '<span class="highlighted-lead">' + leadIdMarkup + '</span>';
        }
        return leadIdMarkup;
      },
      createdCell: function (td, cellData, rowData, row, col) {
        // Check if lead_status_assign is 1, then apply background color to the entire td
        if (rowData.lead_status_assign == 1) {
          $(td).css('background-color', 'rgb(169, 232, 183');  // Apply background color
        }
      }
    },
      {
          data: "customer_name",
      },

    {
      data: "customer_contact",
      render: function(data, type, row) {
        return data.split(',').map(function(item) {
          return item.trim(); // Trimming whitespace
        }).join('<br>'); // Joining with line breaks for better readability
      }
    },
    {
      data: "customer_email",
      render: function(data, type, row) {
        return data.split(',').map(function(item) {
          return item.trim(); // Trimming whitespace
        }).join('<br>'); // Joining with line breaks for better readability
      }
    },
    // {
    //   data: "customer_email",
    //   render: function (data) {
    //     const emails = data
    //       .split(",")
    //       .map((email) => email.trim())
    //       .slice(0, 10);
    //     return emails
    //       .map(
    //         (email) =>
    //           `<a href="https://mail.google.com/mail/?view=cm&fs=1&to=${email}" target="_blank">${email}</a>`
    //       )
    //       .join("<br>");
    //   },
    // },
    {
      data: "customer_address",
      render: function (data, type, row) {
        return data.substring(0, 15);
      },
    },
    { data: "brand_name" },
    // {
    //   data: null,
    //   render: function (data, type, row) {
    //     return (
    //       '<a href="javascript::void();" class="OpenModal view_lead_activity" data-lead_id=' +
    //       row.lead_id +
    //       ' data-toggle="modal" data-target="#activityModal">' +
    //       row.title +
    //       "</a>"
    //     );
    //   },
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
    // { data: "description" },
    // { data: "lead_value" },
    {
      data: "book_link",
      render: function (data, type, row) {
        const bookLink = data
          .split(",")
          .map((booklink) => booklink.trim())
          .slice(0, 10);
        return bookLink
          .map(
            (booklink) =>
              '<a href="' +
              booklink +
              '" target="_blank" rel="noopener noreferrer">' +
              booklink.substring(0, 15) +
              "</a>"
          )
          .join("<br>");


      },
    },
    { data: "source" },

    { data: "lead_status" },
    { data: "sales_remarks" },


    // { data: "status_services" },
    { data: "date_created", render: formatDate },
    // {
    //   data: null,
    //   render: function (data, type, row) {
    //     return (
    //       '<button type="button" class="btn btn-md btn-danger edit_leads" data-lead_id=' +
    //       row.lead_id +
    //       ' data-toggle="modal" data-target="#editLeadsModal">Edit</button>'
    //     );
    //   },
    // },
    {
      data: null,
      render: function (data, type, row) {
        return (
          '<button type="button" class="btn btn-md btn-success edit_leads "  data-lead_id=' + 
          row.lead_id + 
          ' data-toggle="modal" data-target="#editLeadsModal" style="margin-right: 16px;">Edit</button>' + 
          '<button type="button" class="btn btn-md btn-danger delete_leads" data-lead_id=' + 
          row.lead_id + 
          ' data-agent_task_id='+row.agent_task_id+' >Delete</button>'
        );
      },
    }
    // Add more columns as needed
  ],
  drawCallback: function() {
    // Add event listener to rows after each draw (to handle dynamic row rendering)
    $('#leaddatatable tbody').on('click', 'tr', function() {
      // Remove the highlight (background color) from all rows
      $('#leaddatatable tbody tr').css('background-color', '');

      // Set the background color of the clicked row to highlight it
      $(this).css('background-color', 'rgb(211, 234, 253)');  // Change the color as needed (e.g., light green)
    });
  }
//   "createdRow": function(row, data, dataIndex) {
//     // Highlight duplicates in the 'email' column
//     var customer_name = data.customer_name;
//     var customeraccount = table.column(1).data().filter(function(value) {
//         return value === customer_name;
//     }).length;

    
//   var customer_contact = data.customer_contact;
//   var contactaccount = table.column(2).data().filter(function(value) {
//       return value === customer_contact;
//   }).length;


//     if (customeraccount > 1) {
//         $('td:eq(1)', row).css('color', 'red');

//     }
//     if (contactaccount > 1) {
//       $('td:eq(2)', row).css('color', 'red');

//   }
// },
});
// $("#entries").on("change", function () {
//   var newLength = parseInt($(this).val(), 10);
//   if (!isNaN(newLength) && newLength > 0) {
//     table.page.len(newLength).draw(); // Update page length and redraw table
//   }
// });
// Event listener for the custom search input
$("#search").on("keyup", function () {
  table.search(this.value).draw(); // Update table based on search input
});

$(document).on("click", ".delete_leads", function (e) {

  // Event listener for delete button
      var lead_id = $(this).data('lead_id');
      var agent_task_id = $(this).data('agent_task_id');
    

      // Confirm deletion
      if (confirm('Are you sure you want to delete this lead?')) {
        $("#loadingSpinner").show();
          $.ajax({
              url: 'leads/delete', // URL to the delete method in the Lead controller
              type: 'POST',
              data: { lead_id: lead_id, agent_task_id: agent_task_id },
              dataType: 'json',
              success: function(response) {
                $("#loadingSpinner").hide();
                $("#leaddatatable").DataTable().ajax.reload();
                $("#leadgentdatatable").DataTable().ajax.reload();

                  if (response.status === 'success') {
                      alert(response.message);
                      // Optionally, refresh the page or remove the deleted lead from the UI
                    // Reload the page

                  }
              },
              error: function() {
                  alert('An error occurred while trying to delete the lead.');
              }
          });
      }
  });

$(".statusfilter").on("change", function () {
  var selectLead_Status = $(this).val();
  table.ajax
    .url(
      base_url + "leads/fetch_lead_limit_data?lead_status=" + selectLead_Status
    )
    .load();
});

$(".agent_extension_display").on("change", function () {
  var selectLead_Status = $(this).val();
  ListOfSoldAuthorsAd_datatable
    .url(
      base_url + "leads/fetch_lead_limit_data?lead_status=" + selectLead_Status
    )
    .load();
});

// leadgent task data
var table_leadgent = $("#leadgentdatatable").DataTable({
  processing: true,
  serverSide: true,

  fixedColumns: {
    start: 2,
    end: 1,
  },
  scrollCollapse: true,
  scrollX: true,

  // "pageLength": 500, // Default number of entries
  // "lengthMenu": [500, 1000, 2000, 3000], // Options for entries per page
  dom: 'rt<"d-flex mt-2 mb-2 justify-content-between align-items-center"ip>',
  ajax: {
    url: base_url + "leads/fetch_lead_limit_leadgent_data",
    type: "GET",
  },

  columns: [
    {
      data: "lead_id",
      render: function (data, type, row, meta) {
        // Add background color if lead_status_assign is 1
        var leadIdMarkup = 'Lead' + String(data).padStart(4, "0");
        
        // Return the formatted lead_id as usual
        if (row.lead_status_assign == 1) {
          return '<span class="highlighted-lead">' + leadIdMarkup + '</span>';
        }
        return leadIdMarkup;
      },
      createdCell: function (td, cellData, rowData, row, col) {
        // Check if lead_status_assign is 1, then apply background color to the entire td
        if (rowData.lead_status_assign == 1) {
          $(td).css('background-color', 'rgb(169, 232, 183');  // Apply background color
        }
      }
    },
    { data: "customer_name" },
    {
      data: "customer_contact",
      render: function(data, type, row) {
        return data.split(',').map(function(item) {
          return item.trim(); // Trimming whitespace
        }).join('<br>'); // Joining with line breaks for better readability
      }
    },
    {
      data: "customer_email",
      render: function(data, type, row) {
        return data.split(',').map(function(item) {
          return item.trim(); // Trimming whitespace
        }).join('<br>'); // Joining with line breaks for better readability
      }
    },
     {
      data: "book_link",
      render: function (data, type, row) {
        const bookLink = data
          .split(",")
          .map((booklink) => booklink.trim())
          .slice(0, 10);
        return bookLink
          .map(
            (booklink) =>
              '<a href="' +
              booklink +
              '" target="_blank" rel="noopener noreferrer">' +
              booklink.substring(0, 15) +
              "</a>"
          )
          .join("<br>");

      },
    },
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
    // { data: "description" },
    // { data: "lead_value" },
   
    // {
    //   data: "customer_contact",
    //   render: function (data) {
    //     return data
    //       .split(",")
    //       .map(
    //         (contact) => `<a href="tel:${contact.trim()}">${contact.trim()}</a>`
    //       )
    //       .join("<br>"); // Converts contact numbers into clickable links
    //   },
    // },
    // {
    //   data: "customer_email",
    //   render: function (data) {
    //     return data
    //       .split(",")
    //       .map((email) => {
    //         const trimmedEmail = email.trim();
    //         return `<a href="https://mail.google.com/mail/?view=cm&fs=1&to=${trimmedEmail}" target="_blank">${trimmedEmail}</a>`;
    //       })
    //       .join("<br>");
    //   },
    // },
    {
      data: "customer_address",
      render: function (data, type, row) {
        return data.substring(0, 15);
      },
    },
    // { data: "brand_name" },
    // {
    //   data: null,
    //   render: function (data, type, row) {
    //     return (
    //       '<a href="javascript::void();" class="OpenModal view_lead_activity" data-lead_id=' +
    //       row.lead_id +
    //       ' data-toggle="modal" data-target="#activityModal">' +
    //       row.title +
    //       "</a>"
    //     );
    //   },
    // },
  
    { data: "source" },
    { data: "lead_status" },
    { data: "sales_remarks" },

    // { data: "status_services" },
    { data: "date_created", render: formatDate },
    // {
    //   data: null,
    //   render: function (data, type, row) {
    //     return (
    //       '<button type="button" class="btn btn-md btn-danger edit_leads" data-lead_id=' +
    //       row.lead_id +
    //       ' data-toggle="modal" data-target="#editLeadsModal">Edit</button>'
    //     );
    //   },
    // },
    {
      data: null,
      render: function (data, type, row) {
        return (
          '<button type="button" class="btn btn-md btn-success edit_leads "  data-lead_id=' + 
          row.lead_id + 
          ' data-toggle="modal" data-target="#editLeadsModal" style="margin-right: 16px;">Edit</button>' + 
          '<button type="button" class="btn btn-md btn-danger delete_leads" data-lead_id=' + 
          row.lead_id + 
          ' data-agent_task_id=' + 
          row.agent_task_id + 
          ' >Delete</button>'
        );
      },
    },
    // Add more columns as needed
  ],
  drawCallback: function() {
    // Add event listener to rows after each draw (to handle dynamic row rendering)
    $('#leadgentdatatable tbody').on('click', 'tr', function() {
      // Remove the highlight (background color) from all rows
      $('#leadgentdatatable tbody tr').css('background-color', '');

      // Set the background color of the clicked row to highlight it
      $(this).css('background-color', 'rgb(211, 234, 253)');  // Change the color as needed (e.g., light green)
    });
  }

});

$(document).ready(function() {
  $('#export_csv').on('click', function() {
      window.location.href = "leads/export_csv";
  });
});
$(document).ready(function() {
  $('#export_csv_leadgent').on('click', function() {
      window.location.href = "leads/export_csv_leadgent";
  });
});



$(".leadgent_statusfilter").on("change", function () {
  var leadgent_selectLead_Status = $(this).val();
  table_leadgent.ajax
    .url(
      base_url +
      "leads/fetch_lead_limit_leadgent_data?lead_status=" +
      leadgent_selectLead_Status
    )
    .load();
});

$(".leadgent_assign_statusfilter").on("change", function () {
  var leadgent_assign_selectLead_Status = $(this).val();
  agenttask_table.ajax
    .url(
      base_url +
      "leads/fetch_lead_limit_leadgent_data_lead_status?lead_status=" +
      leadgent_assign_selectLead_Status
    )
    .load();
});
// Event listener for the custom "Show entries" input
$("#entries_8").on("change", function () {
  var newLength = parseInt($(this).val(), 10);
  if (!isNaN(newLength) && newLength > 0) {
    table_leadgent.page.len(newLength).draw(); // Update page length and redraw table
  }
});
// Event listener for the custom search input
$("#search").on("keyup", function () {
  table_leadgent.search(this.value).draw(); // Update table based on search input
});

//agent task data
var table_agent = $("#agentsdatatable").DataTable({
  processing: true,
  serverSide: true,
  pageLength: 100, // Default number of entries
  lengthMenu: [100,500, 1000, 2000, 3000], // Options for entries per page

  fixedColumns: {
    start: 2,
    end: 1,
  },
  scrollCollapse: true,
  scrollX: true,
  ajax: {
    url: base_url + "leads/fetch_lead_limit_agent_data",
    type: "GET",
  },

  columns: [
    {
      data: "lead_id",
      render: function (data) {
        return `Lead <br>${String(data).padStart(4, "0")}`;
      },
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
    
    // { data: "brand_name" },
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
    // {
    //   data: null,
    //   render: function (data, type, row) {
    //     return (
    //       '<a href="javascript::void();" class="OpenModal view_lead_activity" data-lead_id=' +
    //       row.lead_id +
    //       ' data-toggle="modal" data-target="#activityModal">' +
    //       row.title +
    //       "</a>"
    //     );
    //   },
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
    // { data: "description" },
    // { data: "lead_value" },
    {
      data: "customer_address",
      render: function (data, type, row) {
        return data.substring(0, 15);
      },
    },
    { data: "source" },

    { data: "lead_status" },

    // { data: "status_services" },
    { data: "date_created", render: formatDate },
    { data: "agent_priority" },
    { data: "services_status" },
    // { data: "service_purchased" },
    {
      data: "service_purchased",
      render: function (data, type, row) {
        const leadId = row.lead_id;
        const textareaContent = data ? data : "";
        return `<textarea class="form-control col" readonly style="width: 250px;" data-lead_id="${leadId}" rows="2">${textareaContent}</textarea>`;
      },
    },
    { data: "agent_remarks" },
    {
      data: "0.00",
      render: function (data, type, row) {
        const pitched_price = (
          row.p_price ? parseFloat(row.p_price) : 0
        ).toFixed(2);
        return `$${pitched_price.replace(/\B(?=(\d{3})+(?!\d))/g, ",")}`;
      },
    },
    { data: "payment_status" },
    { 
      data: "total_payment",
      render: function (data, type, row) {
        const totalPayment = parseFloat(data) || 0;
        return `$${totalPayment.toFixed(2).replace(/\B(?=(\d{3})+(?!\d))/g, ",")}`;
    },
  },
    {
      data: "balance",
      render: function (data, type, row) {
        const totalPayment = parseFloat(data) || 0;
        return `$${totalPayment.toFixed(2).replace(/\B(?=(\d{3})+(?!\d))/g, ",")}`;
    },
    },
    //   {

    //     data: 'file_name',
    //     render: function(data) {
    //         return data != '' ?'<audio controls><source src="'+base_url+'/ringcentral_recording/'+data+'" type="audio/mpeg"></audio>' : '';

    //     }
    // },
    {
      data: "recording",
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

    {
      data: null,
      render: function (data, type, row) {
        const pitchedPrice = row.pitched_price;
        const total_payment = row.total_payment;
        let balance = 0;

        // alert(total_payment);
        // const totalPayment = row.total_payment;
       if (row.agent_services_status == "Publishing"){
        balance = row.pitched_price - total_payment ; // Calculate balance

       }
       else if (row.agent_services_status == "Marketing"){
        balance = row.pitched_price_marketing - total_payment ; // Calculate balance

       }
       else if (row.agent_services_status == "Package"){
         balance =row.pitched_price_packages - total_payment ; // Calculate balance

       }
        return (
          '<button type="button" class="btn btn-md btn-primary view_agent_leads" style="margin-right:10px" data-lead_id=' +
          row.lead_id +
          "  data-agent_task_id=" +
          row.agent_task_id +
          "  data-transaction_id=" +
          row.agent_task_id +
          ' data-current_status_payment="' +
          row.payment_status +
          '" data-balance="' +
          balance +
          'data-service_status="' +
          row.agent_services_status +
          ' data-toggle="modal" data-target="#editLeadsModal"><i class="bi bi-plus"></i></button>' +

          '<button type="button" class="btn btn-md btn-success edit_agents_payment_leads" style="margin-right:10px" data-lead_id=' +
          row.lead_id +
          "  data-agent_task_id=" +
          row.agent_task_id +
          "  data-transaction_id=" +
          row.agent_task_id +
          ' data-current_status_payment="' +
          row.payment_status +
          '" data-balance="' +
          balance +
          'data-service_status="' +
          row.agent_services_status +
          ' data-toggle="modal" data-target="#edit_agentLeadsModal"><i class="bi bi-pencil-square"></i></button>' +
          // '<button type="button" class="btn btn-md btn-info" style="margin-right:10px" onclick="openPaymentForm()"><i class="bi bi-file-earmark-text"></i></button>' +
          '<button type="button" class="btn btn-md  view_payment_history" style="background-color:teal; color:white"  data-lead_id=' +
          row.lead_id +
          "  data-agent_task_id=" +
          row.agent_task_id +
          " data-balance=" +
          balance +
          ' data-toggle="modal" data-target="#view_history"><i class="bi bi-clock-history"></i></button>'
        );
      },
    },
  ],
  drawCallback: function() {
    // Add event listener to rows after each draw (to handle dynamic row rendering)
    $('#agentsdatatable tbody').on('click', 'tr', function() {
      // Remove the highlight (background color) from all rows
      $('#agentsdatatable tbody tr').css('background-color', '');

      // Set the background color of the clicked row to highlight it
      $(this).css('background-color', 'rgb(211, 234, 253)');  // Change the color as needed (e.g., light green)
    });
  }
});

function formatCurrency(value) {
  return `$${value.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",")}`;
}
function openPaymentForm() {
  window.open(
    "https://docs.google.com/forms/d/e/1FAIpQLSf_sa0sw_yCflse8js5C1x0IJKCx5cg26FoexwOaU2hkr4BIg/viewform",
    "_blank"
  );
}

$(document).on("click", ".view_payment_history", function (e) {
  e.preventDefault();

  var lead_id = $(this).data("lead_id");

  dataEdit = "lead_id=" + lead_id;

  $.ajax({
    type: "GET",

    data: dataEdit,

    url: base_url + "history/view_agent_history",

    dataType: "json",

    success: function (data) {
      var tr = "";

      let n = 1;
      var date_paid = "";

      for (var i = 0; i < data.length; i++) {
        date_paid =
          data[i].date_paid == null ? "Await Confirmation!" : data[i].date_paid;
          var recordingLink = data[i].recording
          ? '<a href="' + data[i].recording + '" target="_blank" rel="noopener noreferrer">' +
            data[i].recording.substring(0, 15) + '...</a>'
          : 'No Recording Available';
        tr +=
          "<tr>" +
          "<td>" +
          n++ +
          "</td>" +
          "<td>" +
          data[i].title +
          "</td>" +
          "<td>" +
          data[i].additional_book +
          "</td>" +
          "<td>" +
          data[i].pitched_price +
          "</td>" +
          "<td>" +
          data[i].amount +
          "</td>" +
          "<td>" +
          data[i].payment_status +
          "</td>" +
          "<td>" +
          data[i].services_status +
          "</td>" +
          "<td>" +
          "<textarea disabled>" +
            data[i].service_purchased +
          "</textarea>" +
        "</td>" +
          "<td>" +
          data[i].agent_remarks +
          "</td>" +
          "<td>" +
          data[i].agent_priority +
          "</td>" +
          "<td>" +
          recordingLink +
          "</td>" +
          "<td>" +
          date_paid +
          "</td>" +
          "<td>" +
          formatDate(data[i].date) +
          "</td>" +
          "</tr>";
      }
      $(".details_history").html(tr);
      $("#paymenthistorydataTable").DataTable();
    },
  });
});

// $("#agentstatusfilters").on("change", function () {
//   var agent_selectLead_Status = $(this).val();
//   table_agent.ajax
//     .url(
//       base_url +
//       "leads/fetch_lead_limit_agent_data?lead_status=" +
//       agent_selectLead_Status
//     )
//     .load();
// });

//Assign mutiple task
$("#taskmodaldatatable").DataTable({
  processing: true,
  serverSide: true,
  fixedColumns: {
    start: 2,
    end: 1,
  },
  scrollCollapse: true,
  scrollX: true,
  ajax: {
    url: base_url + "leads/fetch_lead_limit_data_modal",
    type: "GET",
  },
  columns: [
    {
      data: "lead_id",
      render: function (data) {
        return `Lead${String(data).padStart(4, "0")}`;
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
    { data: "lead_status" },

    // { data: "status_services"},

    { data: "date_created", render: formatDate },

    {
      data: null,
      render: function (data, type, row) {
        return (
          '<input type="checkbox" class="lead-checkbox" data-lead_id="' +
          row.lead_id +
          '">'
        );
      },
    },
    // Add more columns as needed
  ],
});

// Count checked checkboxes
$(document).on("change", ".lead-checkbox", function () {
  var checkedCount = $(".lead-checkbox:checked").length;
  $("#checkedCountDisplay").text("(" + checkedCount + ")");
});

function formatDate(data) {
  if (!data) return "";
  const date = new Date(data);
  return moment(date).format("YYYY/MM/DD HH:mm:ss");
}

$(document).ready(function () {
  $(".custom-file-input").on("change", function (e) {
    var name = $(this).prop("files")[0].name;
    $(this).next("label").text(name);
  });
});

// Book Tittle add more
$(document).ready(function () {
  // add lead contact person form
  function addLeadDeleteTitleButtons() {
    $("#detail_form .removeFields_1").prop("disabled", false);
    if ($("#detail_form #inputFields3 .field-container").length === 1) {
      $("#detail_form .removeFields_1").prop("disabled", true);
    }
  }
  $("#detail_form #addMoreTitle").click(function () {
    $("#detail_form #inputFields3").append(
      '<div class="mb-3 field-container d-flex gap-1"><input type="text" class="form-control" name="title[]" placeholder="Enter title"><button type="button" class="btn btn-danger removeFields_1"><i class="ti ti-trash"></i></button></div>'
    );
    addLeadDeleteTitleButtons();
  });
  $("#edit_detail_form #addMoreTitle").click(function () {
    $("#edit_detail_form #inputFields3").append(
      '<div class="mb-3 field-container d-flex gap-1"><input type="text" class="form-control" name="title[]" placeholder="Add title"><button type="button" class="btn btn-danger removeFields_1"><i class="ti ti-trash"></i></button></div>'
    );
    updateDeleteTitleButtons();
  });

  $("#detail_form").on("click", ".removeFields_1", function () {
    $(this).closest("#inputFields3 .field-container").remove();
    addLeadDeleteTitleButtons();
  });

  $("#edit_detail_form").on("click", ".removeFields_1", function () {
    $(this).closest("#inputFields3 .field-container").remove();
    addLeadDeleteTitleButtons();
  });
  updateDeleteTitleButtons();
  addLeadDeleteTitleButtons();
});
function updateDeleteTitleButtons() {
  $("#edit_detail_form .removeFields_1").prop("disabled", false);
  if ($("#edit_detail_form #inputFields3 .field-container").length === 1) {
    $("#edit_detail_form .removeFields_1").prop("disabled", true);
  }
}
// Book Link add more
$(document).ready(function () {
  // add lead contact person form
  function addLeadDeleteBookLinkButtons() {
    $("#detail_form .removeFields_2").prop("disabled", false);
    if ($("#detail_form #inputFields4 .field-container").length === 1) {
      $("#detail_form .removeFields_2").prop("disabled", true);
    }
  }
  $("#detail_form #addMoreBookLink").click(function () {
    $("#detail_form #inputFields4").append(
      '<div class="mb-3 field-container d-flex gap-1"><input type="text" class="form-control" name="bookLink[]" placeholder="Enter book link"><button type="button" class="btn btn-danger removeFields_2"><i class="ti ti-trash"></i></button></div>'
    );
    addLeadDeleteBookLinkButtons();
  });

  $("#edit_detail_form #addMoreBookLink").click(function () {
    $("#edit_detail_form #inputFields4").append(
      '<div class="mb-3 field-container d-flex gap-1"><input type="text" class="form-control" name="bookLink[]" placeholder="Add book link"><button type="button" class="btn btn-danger removeFields_2"><i class="ti ti-trash"></i></button></div>'
    );
    addLeadDeleteBookLinkButtons();
  });

  $("#edit_detail_form").on("click", ".removeFields_2", function () {
    $(this).closest("#inputFields4 .field-container").remove();
    addLeadDeleteBookLinkButtons();
  });

  $("#detail_form").on("click", ".removeFields_2", function () {
    $(this).closest("#inputFields4 .field-container").remove();
    addLeadDeleteBookLinkButtons();
  });
  updateDeleteBookLinkButtons();
  addLeadDeleteBookLinkButtons();
});
function updateDeleteBookLinkButtons() {
  $("#edit_detail_form .removeFields_2").prop("disabled", false);
  if ($("#edit_detail_form #inputFields4 .field-container").length === 1) {
    $("#edit_detail_form .removeFields_2").prop("disabled", true);
  }
}

// EMAIL ADDRESS add more
$(document).ready(function () {
  // add lead contact person form
  function addLeadDeleteEmailButtons() {
    $("#contactcustomer_form .removeFields").prop("disabled", false);
    if ($("#contactcustomer_form #inputFields .field-container").length === 1) {
      $("#contactcustomer_form .removeFields").prop("disabled", true);
    }
  }
  $("#contactcustomer_form #addMoreEmail").click(function () {
    $("#contactcustomer_form #inputFields").append(
      '<div class="mb-3 field-container d-flex gap-1"><input type="text" class="form-control" name="customer_email[]" placeholder="Add new email address"><button type="button" class="btn btn-danger removeFields"><i class="ti ti-trash"></i></button></div>'
    );
    addLeadDeleteEmailButtons();
  });
  $("#contactcustomer_form").on("click", ".removeFields", function () {
    $(this).closest("#inputFields .field-container").remove();
    addLeadDeleteEmailButtons();
  });
  updateDeleteEmailButtons();
  addLeadDeleteEmailButtons();
});

function updateDeleteEmailButtons() {
  $("#edit_contactcustomer_form .removeFields").prop("disabled", false);
  if (
    $("#edit_contactcustomer_form #inputFields .field-container").length === 1
  ) {
    $("#edit_contactcustomer_form .removeFields").prop("disabled", true);
  }
}

function updateLeadContactDeleteButtons() {
  // Enable all delete buttons
  $("#edit_contactcustomer_form .removeField").prop("disabled", false);

  // If only one field is left, disable the delete button for that field

  if (
    $("#edit_contactcustomer_form #inputFields2 .field-container").length === 1
  ) {
    $("#edit_contactcustomer_form .removeField").prop("disabled", true);
  }
}

// CONTACT add more
$(document).ready(function () {
  function addLeadContactDeleteButtons() {
    // Enable all delete buttons
    $("#contactcustomer_form .removeField").prop("disabled", false);

    // If only one field is left, disable the delete button for that field
    if (
      $("#contactcustomer_form #inputFields2 .field-container").length === 1
    ) {
      $("#contactcustomer_form .removeField").prop("disabled", true);
    }
  }

  $("#contactcustomer_form #addMoreContact").click(function () {
    $("#contactcustomer_form #inputFields2").append(
      '<div class="mb-3 field-container d-flex gap-1"><input type="text" class="form-control" name="customer_contact[]" placeholder="Add new contact"><button type="button" class="btn btn-danger removeField"><i class="ti ti-trash"></i></button></div>'
    );
    addLeadContactDeleteButtons();
  });

  // Delegate event handler for dynamically added delete buttons
  $("#contactcustomer_form").on("click", ".removeField", function () {
    $(this).closest("#inputFields2  .field-container").remove();
    addLeadContactDeleteButtons();
  });

  // Initial check on page load
  updateLeadContactDeleteButtons();
  addLeadContactDeleteButtons();
});

$(document).ready(function () {
  $("#edit_contactcustomer_form #addMore").click(function () {
    $("#edit_contactcustomer_form #inputFields").append(
      '<div class="mb-3 field-container d-flex gap-1"><input type="text" class="form-control" name="customer_email[]" placeholder="Add new email address"><button type="button" class="btn btn-danger removeFields"><i class="ti ti-trash"></i></button></div>'
    );
    updateDeleteEmailButtons();
  });

  $("#edit_contactcustomer_form").on("click", ".removeFields", function () {
    $(this).closest("#inputFields .field-container").remove();
    var lead_id = $(this).data("lead_id");
    var customer_email = $(this).data("customer_email");

    dataEdit = "lead_id=" + lead_id + "&customer_email=" + customer_email;

    $.ajax({
      type: "GET",

      data: dataEdit,

      url: base_url + "leads/delete_lead_email",

      dataType: "json",

      success: function (res) {
        $("#leaddatatable").DataTable().ajax.reload();

        // console.log(res.response);

        swal({
          title: "Email Successfully Deleted",
          text: res.response,
          icon: "success",
          buttons: false,
          timer: 2000,
        }).then(() => {
          // $('#editLeadsModal').modal().hide();
          $("body").removeClass("modal-open");
          $(".modal-backdrop").remove();
          // location.reload();
        });
      },
    });
    updateDeleteEmailButtons();
  });
  $("#edit_contactcustomer_form #addMoreContact").click(function () {
    $("#edit_contactcustomer_form #inputFields2").append(
      '<div class="mb-3 field-container d-flex gap-1"><input type="text" class="form-control" name="customer_contact[]" placeholder="Add new contact"><button type="button" class="btn btn-danger removeField"><i class="ti ti-trash"></i></button></div>'
    );
    updateLeadContactDeleteButtons();
  });
  // Delegate event handler for dynamically added delete buttons
  $("#edit_contactcustomer_form").on("click", ".removeField", function () {
    $(this).closest("#inputFields2  .field-container").remove();
    var lead_id = $(this).data("lead_id");
    var customer_contact = $(this).data("customer_contact");

    dataEdit = "lead_id=" + lead_id + "&customer_contact=" + customer_contact;

    $.ajax({
      type: "GET",

      data: dataEdit,

      url: base_url + "leads/delete_lead_contact",

      dataType: "json",

      success: function (res) {
        $("#leaddatatable").DataTable().ajax.reload();

        // console.log(res.response);
        swal({
          title: "Contact Successfully Deleted",
          text: res.response,
          icon: "success",
          buttons: false,
          timer: 2000,
        }).then(() => {
          // $('#editLeadsModal').modal().hide();
          $("body").removeClass("modal-open");
          $(".modal-backdrop").remove();
          // location.reload();
        });
      },
    });

    updateLeadContactDeleteButtons();
  });
});

// CONTACT add more

// Prevent switching to the second tab if the first tab is not filled out
//  $('#pills-contact-tab').on('click', function(event) {
//   if ($(this).hasClass('disabled')) {
//       event.preventDefault();
//       event.stopPropagation();
//   }
// });

// add lead function
$(document).ready(function () {
  $("#add_lead").click(function (e) {
    e.preventDefault(); // Prevent default form submission

    let isValid = true;

    var formData_detail = $("#detail_form").serialize();
    var formData_contact = $("#contactcustomer_form").serialize();

    // Combine the serialized data
    var combinedData = formData_detail + "&" + formData_contact;

    $("#detail_form input").each(function () {
      if ($(this).val() === "") {
        isValid = false;
        $(this).addClass("is-invalid");
      } else {
        $(this).removeClass("is-invalid");
      }
    });

    // Validate fields in Tab 2
    $("#contactcustomer_form input").each(function () {
      if ($(this).val() === "") {
        isValid = false;
        $(this).addClass("is-invalid");
      } else {
        $(this).removeClass("is-invalid");
      }
    });

    if ($("#detail_form")[0].checkValidity()) {
      // If valid, switch to the second tab
      $("#pills-contact-tab")
        .removeClass("disabled")
        .attr("aria-disabled", "false");
      $("#pills-contact-tab").tab("show");
    }
    if ($("#contactcustomer_form")[0].checkValidity()) {
      // If valid second tab, check data php and save database

      $.ajax({
        type: "POST",
        url: base_url + "leads/add_lead",
        dataType: "json",
        data: combinedData,
        success: function (res) {
          // Handle success response
          if (res.response == "success") {
            // $("#LeadsModal .alert-danger").removeClass("alert-danger").addClass("alert-success");

            // $("#LeadsModal .alert-success").css("display", "block");

            // $("#LeadsModal .alert-success p").html(res.message);

            // $('#leaddatatable').DataTable().ajax.reload();
            // $('#leadgentdatatable').DataTable().ajax.reload();

            swal({
              title: "Lead Successfully Added",
              text: res.message,
              icon: "success",
              buttons: false,
              timer: 2000,
            }).then(() => {
              $("#LeadsModal").modal().hide();
              $("body").removeClass("modal-open");
              $(".modal-backdrop").remove();

              $("#leaddatatable").DataTable().ajax.reload();
              $("#leadgentdatatable").DataTable().ajax.reload();
              setTimeout(function () {
                location.reload();
              }, 1);
            });
          } else {
            $("#LeadsModal .alert-success")
              .removeClass("alert-success")
              .addClass("alert-danger");

            $("#LeadsModal .alert-danger").css("display", "block");

            $("#LeadsModal .alert-danger p").html(res.message);

            setTimeout(function () {
              $("#loginForm .alert-danger").css("display", "none");
            }, 1000);
          }
        },
        error: function (xhr, status, error) {
          // Handle error response
          $("#LeadsModal .alert-danger p").html("An error occurred: " + error);
        },
      });
    }
    // $('.loadingModal').modal('show');
  });
});

// Get DATA LEAD
$(document).on("click", ".edit_leads", function (e) {
  e.preventDefault();

  var lead_id = $(this).data("lead_id");

  dataEdit = "lead_id=" + lead_id;

  $.ajax({
    type: "GET",

    data: dataEdit,

    url: base_url + "leads/view_lead_detail",

    dataType: "json",

    success: function (data) {
      var contact_string = "";
      var email_string = "";
      var title_string = "";
      var book_link_string = "";
      var get_title_field = "";
      var get_bookLink_field = "";
      var get_contact_field = "";
      var get_email_field = "";
      let get_lead_id = 0;

      for (var i = 0; i < data.length; i++) {
        title_string = data[i].title;
        book_link_string = data[i].book_link;
        contact_string = data[i].customer_contact;
        email_string = data[i].customer_email;
        let title_array = title_string.split(","); // Splitting by comma converty string to array
        let bookLink_array = book_link_string.split(","); // Splitting by comma converty string to array
        let contact_array = contact_string.split(","); // Splitting by comma converty string to array
        let email_array = email_string.split(","); // Splitting by comma converty string to array
        $(".edit_detail_form input[name='brandName']").val(data[i].brand_name);
        // $(".edit_detail_form .book_title_details").html(get_bookLink_field);
        // $(".edit_detail_form input[name='desc']").val(data[i].description);
        // $(".edit_detail_form .desc").text(data[i].description);
        // $(".edit_detail_form input[name='value']").val(data[i].lead_value);
        // $(".edit_detail_form .bookLink_details").html(data[i].book_link);
        $(".edit_detail_form input[name='source']").val(data[i].source);
        $(".edit_detail_form input[name='sales_remarks']").val(data[i].sales_remarks);
        $(".edit_detail_form select[name='statusData']").val(
          data[i].lead_status
        );
        $(".edit_contactcustomer_form .customer_address").text(
          data[i].customer_address
        );
        $(".edit_contactcustomer_form input[name='customer_name']").val(
          data[i].customer_name
        );
        $(".edit_contactcustomer_form input[name='lead_id']").val(
          data[i].lead_id
        );
        get_lead_id = data[i].lead_id;

        for (var i = 0; i < contact_array.length; i++) {
          get_contact_field +=
            '<div class="d-flex field-container mb-2 gap-1">' +
            '<input type="text" class="form-control" name="customer_contact[]" value="' +
            contact_array[i] +
            '" placeholder="Please Enter Contact Number">' +
            '<button type="button" data-lead_id="' +
            get_lead_id +
            '" data-customer_contact="' +
            contact_array[i] +
            '"  class="btn btn-danger removeField"><i class="ti ti-trash"></i></button>' +
            "</div>";
        }
        for (var i = 0; i < email_array.length; i++) {
          get_email_field +=
            '<div class="d-flex field-container mb-2 gap-1">' +
            '<input type="email" class="form-control" name="customer_email[]" value="' +
            email_array[i] +
            '" placeholder="Please Enter Email Address">' +
            '<button type="button" data-lead_id="' +
            get_lead_id +
            '" data-customer_email="' +
            email_array[i] +
            '"   class="btn btn-danger removeFields"><i class="ti ti-trash"></i></button>' +
            "</div>";
        }
        for (var i = 0; i < title_array.length; i++) {
          get_title_field +=
            '<div class="d-flex field-container mb-2 gap-1">' +
            '<input type="text" class="form-control" name="title[]" value="' +
            title_array[i] +
            '" placeholder="Please title">' +
            '<button type="button" data-lead_id="' +
            get_lead_id +
            '" data-title="' +
            title_array[i] +
            '"   class="btn btn-danger removeFields_1"><i class="ti ti-trash"></i></button>' +
            "</div>";
        }
        for (var i = 0; i < bookLink_array.length; i++) {
          get_bookLink_field +=
            '<div class="d-flex field-container mb-2 gap-1">' +
            '<input type="text" class="form-control" name="bookLink[]" value="' +
            bookLink_array[i] +
            '" placeholder="Please book link">' +
            '<button type="button" data-lead_id="' +
            get_lead_id +
            '" data-book_link="' +
            bookLink_array[i] +
            '"   class="btn btn-danger removeFields_2"><i class="ti ti-trash"></i></button>' +
            "</div>";
        }
      }
      $(".edit_contactcustomer_form .customer_contact_details").html(
        get_contact_field
      );
      $(".edit_contactcustomer_form .customer_email_details").html(
        get_email_field
      );
      $(".edit_detail_form .bookLink_details").html(
        get_bookLink_field
      );
      $(".edit_detail_form .book_title_details").html(
        get_title_field
      );

      // disableRemoveButton(".contact-row"); // Disable for contact fields
      // disableRemoveButton(".email-row");   // Disable for email fields
    },
  });
});

// update lead function
$(document).ready(function () {
  $("#update_lead").click(function (e) {
    e.preventDefault(); // Prevent default form submission

    let isValid = true;

    var formData_detail = $("#edit_detail_form").serialize();
    var formData_contact = $("#edit_contactcustomer_form").serialize();

    // Combine the serialized data
    var combinedData = formData_detail + "&" + formData_contact;

    $("#edit_detail_form input").each(function () {
      if ($(this).val() === "") {
        isValid = false;
        $(this).addClass("is-invalid");
      } else {
        $(this).removeClass("is-invalid");
      }
    });

    // Validate fields in Tab 2
    $("#edit_contactcustomer_form input").each(function () {
      if ($(this).val() === "") {
        isValid = false;
        $(this).addClass("is-invalid");
      } else {
        $(this).removeClass("is-invalid");
      }
    });

    if ($("#edit_detail_form")[0].checkValidity()) {
      // If valid, switch to the second tab
      $("#pills-contact-tab")
        .removeClass("disabled")
        .attr("aria-disabled", "false");
      $("#pills-contact-tab").tab("show");
    }
    if ($("#edit_contactcustomer_form")[0].checkValidity()) {
      // If valid second tab, check data php and save database
      $("#loadingSpinner").show();
      $.ajax({
        type: "POST",
        url: base_url + "leads/update_lead",
        dataType: "json",
        data: combinedData,
        success: function (res) {
          // Handle success response
          $("#loadingSpinner").hide();
          if (res.response == "success") {
            $("#edit_detail_form").animate({ scrollTop: 0 }, "slow");
            // $("#editLeadsModal .alert-danger").removeClass("alert-danger").addClass("alert-success");

            // $("#editLeadsModal .alert-success").css("display", "block");

            // $("#editLeadsModal .alert-success p").html(res.message);

            // $('#leaddatatable').DataTable().ajax.reload();
            // $('#leadgentdatatable').DataTable().ajax.reload();

            swal({
              title: "Lead Successfully Updated",
              text: res.message,
              icon: "success",
              buttons: false,
              timer: 2000,
            }).then(() => {
              $("#editLeadsModal").modal().hide();
              $("body").removeClass("modal-open");
              $(".modal-backdrop").remove();

              $("#leaddatatable").DataTable().ajax.reload(null, false);
              $("#leadgentdatatable").DataTable().ajax.reload(null, false);
              // setTimeout(function () {
              //   location.reload();
              // }, 1);
            });
          } else {
            $("#edit_detail_form").animate({ scrollTop: 0 }, "slow");

            $("#editLeadsModal .alert-success")
              .removeClass("alert-success")
              .addClass("alert-danger");

            $("#editLeadsModal .alert-danger").css("display", "block");

            $("#editLeadsModal .alert-danger p").html(res.message);

            setTimeout(function () {
              $("#editLeadsModal .alert-danger").css("display", "none");
            }, 4000);
          }
        },
        error: function (xhr, status, error) {
          // Handle error response
          $("#loading-spinner").hide();
          $("#editLeadsModal .alert-danger p").html(
            "An error occurred: " + error
          );
        },
      });
    }
    // $('.loadingModal').modal('show');
  });
});

function showLoader() {
  document.getElementById('loadingBackdrop').style.display = 'block';
}

function hideLoader() {
  document.getElementById('loadingBackdrop').style.display = 'none';
}


var leadgent_table_status = $("#my_leads_leadgentdatatable").DataTable({
  processing: true,
  serverSide: true,
  fixedColumns: {
    start: 2,
    end: 1,
  },
  scrollCollapse: true,
  scrollX: true,

  // "pageLength": 500, // Default number of entries
  // "lengthMenu": [500, 1000, 2000, 3000], // Options for entries per page
  dom: 'rt<"d-flex mt-2 mb-2 justify-content-between align-items-center"ip>',

  ajax: {
    url: base_url + "leads/fetch_lead_limit_leadgent_data",
    type: "GET",
  },
  columns: [
    {
      data: "lead_id",
      render: function (data) {
        return `Lead${String(data).padStart(4, "0")}`;
      },
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

    // { data: "status_services" },
    { data: "date_created", render: formatDate },
    // Add more columns as needed
  ],
});
// Event listener for the custom "Show entries" input
$("#entries_9").on("change", function () {
  var newLength = parseInt($(this).val(), 10);
  if (!isNaN(newLength) && newLength > 0) {
    leadgent_table_status.page.len(newLength).draw(); // Update page length and redraw table
  }
});
// Event listener for the custom search input
$("#search").on("keyup", function () {
  leadgent_table_status.search(this.value).draw(); // Update table based on search input
});

$('#recycledatatable').DataTable().clear().destroy();
var recycletaskstable = $('#recycledatatable').DataTable({
  "processing": true,
  "serverSide": true,
  "pageLength": 10, // Default number of entries
  "lengthMenu": [10, 20, 50, 100, 200, 500, 1000, 2000, 3000], // Options for entries per page
  "ajax": {
    "url": base_url + 'recycle/recycle/fetch_lead_limit_recycle_data',
    "type": "GET"
  },
  fixedColumns: {
    start: 2,
    end: 2
  },
  scrollCollapse: true,
  scrollX: true,

  "columns": [
    { data: "lead_id", render: function (data) { return `Lead <br>${String(data).padStart(4, '0')}`; } },
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
      {data: "previous_agent"},
      { data: "lead_status" },
      { data: "agent_services_status"},
      { data: "agent_priority"},
      { data: "agent_remarks"},
      {
        data: "0.00",
        render: function (data, type, row) {
          const pitched_price = (
            row.p_price ? parseFloat(row.p_price) : 0
          ).toFixed(2);
          return `$${pitched_price.replace(/\B(?=(\d{3})+(?!\d))/g, ",")}`;
        },
      },
      { data: "payment_status"},
      { 
        data: "total_payment",
        render: function (data, type, row) {
          const totalPayment = parseFloat(data) || 0;
          return `$${totalPayment.toFixed(2).replace(/\B(?=(\d{3})+(?!\d))/g, ",")}`;
      },
    },
      {
        data: "balance",
        render: function (data, type, row) {
          const totalPayment = parseFloat(data) || 0;
          return `$${totalPayment.toFixed(2).replace(/\B(?=(\d{3})+(?!\d))/g, ",")}`;
      },
      },
      { data: "recording", render: function(data, type, row) {
           var data_recording = data == null ?  "" : data;
          return '<a href="' + data + '" target="_blank" rel="noopener noreferrer">' + data_recording.substring(0, 15) + '</a>';
        }},
      // { data: "status_services" },
      { data: "status"},
      { data: "date_assigned" },
      { data: "agent_date_assigned", render: formatDate },
      {
          "data": "remark_tasks", "render": function (data, type, row) {
              return data ? '<textarea class="form-control edit_remark col" style="width: 250px;"  data-lead_id="' + row.lead_id + '" rows="2" id="comment">' + data + '</textarea>' :
                  '<textarea class="form-control edit_remark" style="width: 250px;"     data-lead_id="' + row.lead_id + '" rows="2" id="comment"></textarea>';
          }
      },
      {
          data: null,
          "render": function (data, type, row) {

              return '<button type="button" class="btn btn-md  view_recycle_history" style="background-color:teal; color:white;" data-user_id= '+ row.user_id +' data-recycle_id= '+ row.recycle_id +' data-lead_id=' + row.lead_id + '  data-agent_task_id=' + row.agent_task_id + ' data-toggle="modal" data-target="#viewrecyclehistory_datatable">View History</button>';
          },

      },
    {
      data: null,
      "render": function (data, type, row) {
            return '<button type="button" class="btn btn-md  return_lead" style="background-color:#003333; color:white" data-recycle_id=' + row.recycle_id + ' data-lead_id=' + row.lead_id + ' data-toggle="modal">Return</button>'


      },

    },


  ]
});


$(document).ready(function () {
  $('#viewrecycle_historydatatable').DataTable();
})
// start list of tasks
function get_view_task_recycle_data(lead_id = 0) {
  let id = lead_id;
  
  const dataTableElement = $('#viewrecycle_historydatatable');

  // Destroy existing DataTable instance if it exists
  if ($.fn.DataTable.isDataTable(dataTableElement)) {
      dataTableElement.DataTable().destroy();
  }

  var viewrecycle_table = dataTableElement.DataTable({
      processing: true,
      serverSide: true,
      fixedColumns: {
          start: 2,
          end: 1
      },
      scrollCollapse: true,
      scrollX: true,

      "dom": 'rt<"d-flex mt-2 mb-2 justify-content-between align-items-center"ip>',
      ajax: {
          url: `${base_url}recycle/recycle/fetch_agent_view_recycled_data/${id}`,
          type: "GET"
      },
      columns: [
        { data: "lead_id", render: function (data) { return `Lead <br>${String(data).padStart(4, '0')}`; } },
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
        {data: "previous_agent"},
        { data: "lead_status" },
        { data: "services_status"},
        { data: "agent_priority"},
        { data: "agent_remarks"},
        { data: "pitched_price"},
        { data: "payment_status"},
        { data: "recording", render: function(data, type, row) {
             var data_recording = data == null ?  "" : data;
            return '<a href="' + data + '" target="_blank" rel="noopener noreferrer">' + data_recording.substring(0, 15) + '</a>';
          }},
        { data: "status" },
        { data: "date_recycle" },
        { data: "date_assigned" },
        { data: "agent_date_assigned", render: formatDate },
        {
            "data": "remark_tasks", "render": function (data, type, row) {
                return data ? '<textarea class="form-control edit_remark col" style="width: 250px;"  data-lead_id="' + row.lead_id + '" rows="2" id="comment" readonly>' + data + '</textarea>' :
                    '<textarea class="form-control edit_remark" style="width: 250px;"     data-lead_id="' + row.lead_id + '" rows="2" id="comment"></textarea>';
            }
        },
        // {
        //     data: null,
        //     "render": function (data, type, row) {
  
        //         return '<button type="button" class="btn btn-md  view_recycle_history" style="background-color:teal; color:white" data-recycle_id= '+ row.recycle_id +' data-lead_id=' + row.lead_id + '  data-agent_task_id=' + row.agent_task_id + ' data-toggle="modal" data-target="#viewrecyclehistory_datatable">View History</button>'
  
        //     },
  
        // },
      ]

  });
  // Event listener for the custom "Show entries" input
  
$('#entries_75').on('change', function () {
  var newLength = parseInt($(this).val(), 10);
  if (!isNaN(newLength) && newLength > 0) {
    viewrecycle_table.page.len(newLength).draw(); // Update page length and redraw table
  }
});
// Event listener for the custom search input
$('#search').on('keyup', function () {
  viewrecycle_table.search(this.value).draw(); // Update table based on search input
});
 
}

$(document).on("click", ".view_recycle_history", function (e) {

  e.preventDefault();

  var lead_id = $(this).data('lead_id');



  dataEdit = 'lead_id=' + lead_id;

  get_view_task_recycle_data(lead_id);
  $.ajax({

    type: 'GET',

    data: dataEdit,

    url: base_url + 'recycle/view_recycled_agent_task_detail',

    dataType: 'json',

    success: function (data) {
      var tr = "";
      for (var i = 0; i < data.length; i++) {

        // $(".recycle_form .assign_to").val(data[i].user_id).change();
        $(".view_recycleform .date_assigned").val(data[i].date_assigned).text();
        $(".view_recycleform .lead_id").val(data[i].lead_id).text();
        $(".view_recycleform .recycle_id").val(data[i].recycle_id).text();
      }
    }
  });
});


$(document).on("click", ".return_lead", function (e) {
  e.preventDefault();

  var lead_id = $(this).data('lead_id');
  var recycle_id = $(this).data('recycle_id');
  $('#return-lead-dialog').dialog({
    resizable: false,
    height: "auto",
    width: 500,
    modal: true,
    buttons: {
    "Yes": function() {
  $.ajax({
      url: `${base_url}leads/update_recycle_status`,
      type: "POST",
      data: { lead_id: lead_id, recycle_id: recycle_id }, // Send as an object sakto ba? sumpay? ana ba?
      dataType: 'json',
      success: function(res) {
          if (res.response === 'success') {
              $("#recycledatatable").animate({ scrollTop: 0 }, "slow");

              swal({
                title: "Lead Returned Successfully",
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
            } else {
              $("#recycledatatable").animate({ scrollTop: 0 }, "slow");
              $("#recycledatatable .alert-success").removeClass("alert-success").addClass("alert-danger");
              $("#recycledatatable .alert-danger").css("display", "block");
              $("#recycledatatable .alert-danger p").html(res.message);

              setTimeout(function () {
                $("#recycledatatable .alert-danger").css("display", "none");
              }, 4000);
            }
          }
        })
      }
    }
  });
});



$(document).ready(function() {
  $('#restoreTable').DataTable();
})

// start list of tasks
function get_trash_leads_data(user_id = 0, date_assigned = "") {
  let  id = user_id;
  let date = date_assigned;
  const restoredataTableElement = $('#restoreTable');

  // Destroy existing DataTable instance if it exists
  if ($.fn.DataTable.isDataTable(restoredataTableElement)) {
    restoredataTableElement.DataTable().destroy();
  }

  var restore_lead_table = restoredataTableElement.DataTable({
      processing: true,
      serverSide: false,
    // scrollCollapse: true,
    // scrollX: true,
   
      "dom": 'rt<"d-flex mt-2 mb-2 justify-content-between align-items-center"ip>',
      ajax: {
          url: `${base_url}leads/Trash_Leads/fetch_leads_restore_data/${id}/${date}`,
          type: "GET"
      },
      columns: [
          { 
              data: "lead_id", 
              render: data => `Lead${String(data).padStart(4, '0')}` 
          },
          { data: "customer_name" },
          { data: 'customer_contact', 
            render: function(data) {
             return data.split(',').map(contact => `<a href="tel:${contact.trim()}">${contact.trim()}</a>`).join('<br>'); // Converts contact numbers into clickable links
          } 
         },
         { data: 'customer_email', 
            render: function(data) {
               return data.split(',').map(email => {
                const trimmedEmail = email.trim();
                return `<a href="https://mail.google.com/mail/?view=cm&fs=1&to=${trimmedEmail}" target="_blank">${trimmedEmail}</a>`;
            }).join('<br>');
          } 
      },
      { data: "remove_date" },
          // { 
          //     data: "date_assigned", 
          //     render: formatDate 
          // },
          {
            data: null,
            render: (data, type, row) => 
                `<input type="checkbox" class="task-checkbox" data-lead_id="${row.lead_id}" data-trash_id="${row.trash_id}" checked><input type="hidden" readonly name="get_leadgent_task_id[]" value ="${row.leadgent_task_id}"><input type="hidden" name="lead_id[]" readonly value="${row.lead_id}">`
        }
      ],
      drawCallback: function() {
        // Add event listener to rows after each draw (to handle dynamic row rendering)
        $('#editaskdataTable tbody').on('click', 'tr', function() {
          // Remove the highlight (background color) from all rows
          $('#editaskdataTable tbody tr').css('background-color', '');
    
          // Set the background color of the clicked row to highlight it
          $(this).css('background-color', 'rgb(211, 234, 253)');  // Change the color as needed (e.g., light green)
        });
      }
  });
// Event listener for the custom "Show entries" input
$('#entriesnum_20').on('change', function() {
  var newLength = parseInt($(this).val(), 10);
  if (!isNaN(newLength) && newLength > 0) {
    restore_lead_table.page.len(newLength).draw(); // Update page length and redraw table
  }
});
// Event listener for the custom search input

$('#searches').on('keyup', function() {
  restore_lead_table.search(this.value).draw(); // Update table based on search input
});
}



// get data
$(document).on("click", ".trash_leads", function(e){

  e.preventDefault();

    var trash_id= $(this).data('trash_id');
    var user_remove_leads_id= $(this).data('user_remove_leads_id');
    var remove_date= $(this).data('remove_date');
    dataEdit = 'trash_id='+ trash_id;

    get_trash_leads_data(user_remove_leads_id, remove_date);
      $.ajax({

      type:'GET',

      data:dataEdit,

      url: base_url +'leads/Trash_Leads/view_restore_leads_detail',

      dataType: 'json',

      success:function(data){
          var tr ="";
          for (var i = 0; i < data.length; i++) {
             $(".view_restore_leads_form .trash_id").val(data[i].trash_id);
             $(".view_restore_leads_form .user_id").val(data[i].user_remove_leads_id).change();
             $(".view_restore_leads_form .user_removed_leads").val(data[i].user_removed_leads).change();
             $(".view_restore_leads_form .lead_id").val(data[i].lead_id);
           }
        }
     });
});


//update recycled leads
$('#save_restore_form').on('submit', function (e) {
  e.preventDefault(); // Prevent default form submission

  let checkedTasks = [];
  let uncheckedTasks = [];
  let uncheckedLeads = [];
  let checkedLeads = [];

  $('.task-checkbox').each(function () {
      let taskId = $(this).data('trash_id');
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
      url: `${base_url}leads/Trash_Leads/restore_leads_data`,
      type: "POST",
      data: $(this).serialize() +
          '&checked_tasks=' + checkedTasks +
          '&unchecked_tasks=' + uncheckedTasks +
          '&unchecked_Lead=' + uncheckedLeads+
          '&checked_Lead=' + checkedLeads,
      dataType: 'json',
      success: function (res) {
          if (res.response == 'success') {
              $("#trash_leads").animate({ scrollTop: 0 }, "slow")
              // $("#updateagentask_form .alert-danger").removeClass("alert-danger").addClass("alert-success");
              // $("#updateagentask_form .alert-success").css("display", "block");
              // $("#updateagentask_form .alert-success p").html(res.message);

              swal({
                  title: "Leads Successfully restored",
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
              $("#trash_leads").animate({ scrollTop: 0 }, "slow")
              $("#save_restore_form .alert-success").removeClass("alert-success").addClass("alert-danger");
              $("#save_restore_form .alert-danger").css("display", "block");
              $("#save_restore_form .alert-danger p").html(res.message);

              setTimeout(function () {
                  $("#save_restore_form .alert-danger").css("display", "none");
              }, 4000);
          }
      }
  });
});

// SOLD AUTHOR TRANSACTION HISTORY

$(document).on("click", ".view_transaction_history", function (e) {
  e.preventDefault();

  var lead_id = $(this).data("lead_id");

  dataEdit = "lead_id=" + lead_id;

  $.ajax({
    type: "GET",

    data: dataEdit,

    url: base_url + "history/view_agent_history",

    dataType: "json",

    success: function (data) {
      var tr = "";

      let n = 1;
      var date_paid = "";

      for (var i = 0; i < data.length; i++) {
        date_paid =
          data[i].date_paid == null ? "Await Confirmation!" : data[i].date_paid;
          var recordingLink = data[i].recording
          ? '<a href="' + data[i].recording + '" target="_blank" rel="noopener noreferrer">' +
            data[i].recording.substring(0, 15) + '...</a>'
          : 'No Recording Available';
          var previousAgent = data[i].previous_agent ? data[i].previous_agent : 'No Previous Agent';
        tr +=
          "<tr>" +
          "<td>" +
          n++ +
          "</td>" +
          "<td>" +
          data[i].title +
          "</td>" +
          "<td>" +
          data[i].additional_book +
          "</td>" +  
             "<td>" +
          data[i].pitched_price +
          "</td>" +
          "<td>" +
          data[i].amount +
          "</td>" +
          "<td>" +
          data[i].payment_status +
          "</td>" +
          "<td>" +
          data[i].services_status +
          "</td>" +
         "<td>" +
          "<textarea disabled>" +
            data[i].service_purchased +
          "</textarea>" +
        "</td>" +
          "<td>" +
          data[i].agent_remarks +
          "</td>" +
          "<td>" +
          data[i].agent_priority +
          "</td>" +
          "<td>" +
          recordingLink +
          "</td>" +
          "<td>" +
          date_paid +
          "</td>" +
          "<td>" +
          formatDate(data[i].date) +
          "</td>" +
          "</tr>";
      }
      $(".Payment_transaction_history").html(tr);
      $("#TransactionHistory_dataTable").DataTable();
    },
  });
});

// 

$(document).on("click", ".views_agents_transaction_history", function (e) {
  e.preventDefault();

  var lead_id = $(this).data("lead_id");

  dataEdit = "lead_id=" + lead_id;

  $.ajax({
    type: "GET",

    data: dataEdit,

    url: base_url + "history/view_agent_history",

    dataType: "json",

    success: function (data) {
      var tr = "";

      let n = 1;
      var date_paid = "";

      for (var i = 0; i < data.length; i++) {
        date_paid =
          data[i].date_paid == null ? "Await Confirmation!" : data[i].date_paid;
          var recordingLink = data[i].recording
          ? '<a href="' + data[i].recording + '" target="_blank" rel="noopener noreferrer">' +
            data[i].recording.substring(0, 15) + '...</a>'
          : 'No Recording Available';
          var previousAgent = data[i].previous_agent ? data[i].previous_agent : 'No Previous Agent';
        tr +=
          "<tr>" +
          "<td>" +
          n++ +
          "</td>" +
          "<td>" +
          data[i].title +
          "</td>" +
          "<td>" +
          data[i].additional_book +
          "</td>" +  
             "<td>" +
          data[i].pitched_price +
          "</td>" +
          "<td>" +
          data[i].amount +
          "</td>" +
          "<td>" +
          data[i].payment_status +
          "</td>" +
          "<td>" +
          data[i].services_status +
          "</td>" +
         "<td>" +
          "<textarea disabled>" +
            data[i].service_purchased +
          "</textarea>" +
        "</td>" +
          "<td>" +
          data[i].agent_remarks +
          "</td>" +
          "<td>" +
          data[i].agent_priority +
          "</td>" +
          "<td>" +
          recordingLink +
          "</td>" +
          "<td>" +
          date_paid +
          "</td>" +
          "<td>" +
          formatDate(data[i].date) +
          "</td>" +
          "</tr>";
      }
      $(".View_Payment_transaction_history").html(tr);
      $("#ViewTransactionHistory_dataTable").DataTable();
    },
  });
});