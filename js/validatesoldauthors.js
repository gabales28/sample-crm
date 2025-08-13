

// Event listener for the custom search input
$("#search").on("keyup", function () {
  table.search(this.value).draw(); // Update table based on search input
});

$(".statusfilter").on("change", function () {
  var selectLead_Status = $(this).val();
  table.ajax
    .url(
      base_url + "leads/fetch_lead_limit_data?lead_status=" + selectLead_Status
    )
    .load();
});

// $(".leadgent_statusfilter").on("change", function () {
//   var leadgent_selectLead_Status = $(this).val();
//   table_leadgent.ajax
//     .url(
//       base_url +
//         "leads/fetch_leadgen_limit_data?lead_status=" +
//         leadgent_selectLead_Status
//     )
//     .load();
// });
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

$("#agentstatusfilters").on("change", function () {
  var agent_selectLead_Status = $(this).val();
  table_agent.ajax
    .url(
      base_url +
        "leads/fetch_agent_lead_limit_data?lead_status=" +
        agent_selectLead_Status
    )
    .load();
});

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

var sold_agenttask_table = $("#sold_author_of_agents_datatable").DataTable({
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
    url: base_url + "sold_author/Sold_authors/fetch_lead_limit_agent_data_sold_leads",
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
      data: "customer_contact",
      render: function (data) {
        return data
          .split(",")
          .map((contact) => `<a href="tel:${contact.trim()}">${contact.trim()}</a>`)
          .join("<br>");
      },
    },
    {
      data: null,
      render: function (data, type, row) {
        return (
          '<button type="button" class="btn btn-md views_agents_transaction_history" style="background-color:teal; color:white" data-lead_id="' +
          row.lead_id +
          '" data-toggle="modal" data-target="#view_transaction_history"><i class="bi bi-clock-history"></i></button>'
        );
      },
    },
  ],
});
// Event listener for the custom search input
    $('#admin_search_sold_author').on('keyup', function () {
        sold_agenttask_table.search(this.value).draw(); // Update table based on search input
    });

$(".select_agent_extension").on("change", function () {
  var selectLead_soldleads = $(this).val();
  sold_agenttask_table.ajax
    .url(
      base_url +
      "sold_author/Sold_authors/fetch_lead_limit_agent_data_sold_leads_drodown?user_id=" +
      selectLead_soldleads
    )
    .load();
});

var sold_agenttask_leadgentable = $("#ListOfSoldAuthors_leadgent_datatable").DataTable({
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
    url: base_url + "sold_author/Sold_authors/fetch_lead_limit_agent_data_sold_leads",
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
      data: "customer_contact",
      render: function (data) {
        return data
          .split(",")
          .map((contact) => `<a href="tel:${contact.trim()}">${contact.trim()}</a>`)
          .join("<br>");
      },
    },
    {
      data: null,
      render: function (data, type, row) {
        return (
          '<button type="button" class="btn btn-md views_agents_transaction_history" style="background-color:teal; color:white" data-lead_id="' +
          row.lead_id +
          '" data-toggle="modal" data-target="#view_transaction_history"><i class="bi bi-clock-history"></i></button>'
        );
      },
    },
  ],
});

// Event listener for the custom search input
    $('#leadgen_search_sold_author').on('keyup', function () {
        sold_agenttask_leadgentable.search(this.value).draw(); // Update table based on search input
    });

$(".select_agent_extension_leadgen").on("change", function () {
  var selectLead_soldleads = $(this).val();
  sold_agenttask_leadgentable.ajax
    .url(
      base_url +
      "sold_author/Sold_authors/fetch_lead_limit_agent_data_sold_leads_drodown?user_id=" +
      selectLead_soldleads
    )
    .load();
});

// Highlight row on click
$('#sold_author_of_agents_datatable tbody').on('click', 'tr', function () {
  $('#sold_author_of_agents_datatable tbody tr').css('background-color', '');
  $(this).css('background-color', 'rgb(211, 234, 253)');
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
 

// EMAIL ADDRESS add more
$(document).ready(function () {
  // add lead contact person form
  function addLeadDeleteEmailButtons() {
    $("#save_sold_author_form .removeFields").prop("disabled", false);
    if ($("#save_sold_author_form #inputfieldemail .field-container").length === 1) {
      $("#save_sold_author_form .removeFields").prop("disabled", true);
    }
  }
  $("#save_sold_author_form #addMoreEmail").click(function () {
    $("#save_sold_author_form #inputfieldemail").append(
      '<div class="mb-3 field-container d-flex gap-1"><input type="text" class="form-control" name="customer_email[]" placeholder="Add new email address"><button type="button" class="btn btn-danger removeinputfieldemail"><i class="ti ti-trash"></i></button></div>'
    );
    addLeadDeleteEmailButtons();
  });
  $("#save_sold_author_form").on("click", ".removeinputfieldemail", function () {
    $(this).closest("#inputfieldemail .field-container").remove();
    addLeadDeleteEmailButtons();
  });
  updateDeleteEmailButtons();
  addLeadDeleteEmailButtons();
});


// EMAIL ADDRESS add more
$(document).ready(function () {
  // add lead contact person form
  function addLeadDeleteEmailButtons() {
    $("#edit_sold_author_form .removeFields7").prop("disabled", false);
    if ($("#edit_sold_author_form #inputFields7 .field-container").length === 1) {
      $("#edit_sold_author_form .removeFields7").prop("disabled", true);
    }
  }
  $("#edit_sold_author_form #addMore7").click(function () {
    $("#edit_sold_author_form #inputFields7").append(
      '<div class="mb-3 field-container d-flex gap-1"><input type="text" class="form-control" name="customer_email[]" placeholder="Add new email address"><button type="button" class="btn btn-danger removeFields7"><i class="ti ti-trash"></i></button></div>'
    );
    addLeadDeleteEmailButtons();
  });
  $("#edit_sold_author_form").on("click", ".removeFields7", function () {
    $(this).closest("#inputFields7 .field-container").remove();
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
    $("#save_sold_author_form .removeInputField").prop("disabled", false);

    // If only one field is left, disable the delete button for that field
    if (
      $("#save_sold_author_form #InputContact .field-container").length === 1
    ) {
      $("#save_sold_author_form .removeInputField").prop("disabled", true);
    }
  }

  $("#save_sold_author_form #addContactField").click(function () {
    $("#save_sold_author_form #InputContact").append(
      '<div class="mb-3 field-container d-flex gap-1"><input type="text" class="form-control" name="customer_contact[]" placeholder="Add new contact"><button type="button" class="btn btn-danger removeInputField"><i class="ti ti-trash"></i></button></div>'
    );
    addLeadContactDeleteButtons();
  });

  // Delegate event handler for dynamically added delete buttons
  $("#save_sold_author_form").on("click", ".removeInputField", function () {
    $(this).closest("#InputContact  .field-container").remove();
    addLeadContactDeleteButtons();
  });

  // Initial check on page load
  updateLeadContactDeleteButtons();
  addLeadContactDeleteButtons();
});

$(document).ready(function () {
  function addLeadContactDeleteButtons() {
    // Enable all delete buttons
    $("#edit_sold_author_form .removeFields8").prop("disabled", false);

    // If only one field is left, disable the delete button for that field
    if (
      $("#edit_sold_author_form #inputFields8 .field-container").length === 1
    ) {
      $("#edit_sold_author_form .removeFields8").prop("disabled", true);
    }
  }

  $("#edit_sold_author_form #addMoreContact8").click(function () {
    $("#edit_sold_author_form #inputFields8").append(
      '<div class="mb-3 field-container d-flex gap-1"><input type="text" class="form-control" name="customer_contact[]" placeholder="Add new contact"><button type="button" class="btn btn-danger removeFields8"><i class="ti ti-trash"></i></button></div>'
    );
    addLeadContactDeleteButtons();
  });

  // Delegate event handler for dynamically added delete buttons
  $("#edit_sold_author_form").on("click", ".removeFields8", function () {
    $(this).closest("#inputFields8  .field-container").remove();
    addLeadContactDeleteButtons();
  });

  // Initial check on page load
  updateLeadContactDeleteButtons();
  addLeadContactDeleteButtons();
});

$(document).ready(function () {

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
// $(document).ready(function () {
//   $("#add_sold_author").click(function (e) {
//     e.preventDefault(); // Prevent default form submission


//     var combinedData = $("#save_sold_author_form").serialize();

//       // If valid second tab, check data php and save database

//       $.ajax({
//         type: "POST",
//         url: base_url + "Sold_author/add_sold_author",
//         dataType: "json",
//         data: combinedData,
//         success: function (res) {
//           // Handle success response
//           if (res.response == "success") {
//             // $("#LeadsModal .alert-danger").removeClass("alert-danger").addClass("alert-success");

//             // $("#LeadsModal .alert-success").css("display", "block");

//             // $("#LeadsModal .alert-success p").html(res.message);

//             // $('#leaddatatable').DataTable().ajax.reload();
//             // $('#leadgentdatatable').DataTable().ajax.reload();

//             swal({
//               title: "Lead Successfully Added",
//               text: res.message,
//               icon: "success",
//               buttons: false,
//               timer: 2000,
//             }).then(() => {
//               $("#LeadsModal").modal().hide();
//               $("body").removeClass("modal-open");
//               $(".modal-backdrop").remove();

//               $("#leaddatatable").DataTable().ajax.reload();
//               $("#leadgentdatatable").DataTable().ajax.reload();
//               setTimeout(function () {
//                 location.reload();
//               }, 1);
//             });
//           } else {
//             $("#LeadsModal .alert-success")
//               .removeClass("alert-success")
//               .addClass("alert-danger");

//             $("#LeadsModal .alert-danger").css("display", "block");

//             $("#LeadsModal .alert-danger p").html(res.message);

//             setTimeout(function () {
//               $("#loginForm .alert-danger").css("display", "none");
//             }, 1000);
//           }
//         },
//         error: function (xhr, status, error) {
//           // Handle error response
//           $("#LeadsModal .alert-danger p").html("An error occurred: " + error);
//         },
//       });
//     }
//   );

// })

// SOLD AUTHORS
$(document).ready( function () {
  $('#ListOfSoldAuthors_datatable').DataTable();
} );
$(document).ready(function() {
  $('#add_sold_author').on('click', function(e) {
      e.preventDefault(); // Prevent the default form submission

      // Serialize the form data
      var formData = $('#save_sold_author_form').serialize();

      // AJAX request
      $.ajax({
          type: 'POST',
          url: base_url + "sold_author/add_sold_author",// Replace with your server URL
          data: formData,
          dataType: 'json',
        success: function (res) {
            if (res.response == 'success') {
                $("#add_sold_author").animate({ scrollTop: 0 }, "slow")
                // $("#updateagentask_form .alert-danger").removeClass("alert-danger").addClass("alert-success");
                // $("#updateagentask_form .alert-success").css("display", "block");
                // $("#updateagentask_form .alert-success p").html(res.message);

                swal({
                    title: "Lead Successfully Updated",
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
                $("#add_sold_author").animate({ scrollTop: 0 }, "slow")
                $("#save_sold_author_form .alert-success").removeClass("alert-success").addClass("alert-danger");
                $("#save_sold_author_form .alert-danger").css("display", "block");
                $("#save_sold_author_form .alert-danger p").html(res.message);

                setTimeout(function () {
                    $("#save_sold_author_form .alert-danger").css("display", "none");
                }, 4000);
            }
        }
      });
  });
});
$(document).on("click", ".view_recycle_history", function (e) {
  e.preventDefault();
  var lead_id = $(this).data('lead_id');

  $.ajax({

      type: 'GET',

      data: dataEdit,

      url: base_url + 'sold_author/view_recycled_agent_task_detail',

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

// SOLD AUTHORS ENDS






$(document).ready(function() {
  $('#edit_sold_author').on('click', function(e) {
      e.preventDefault(); // Prevent the default form submission

      // Serialize the form data
      var formData = $('#edit_sold_author_form').serialize();
      // AJAX request
      $.ajax({
          type: 'POST',
          url: base_url + "sold_author/edit_sold_author",// Replace with your server URL
          data: formData,
          dataType: 'json',
        success: function (res) {
            if (res.response == 'success') {
                $("#edit_sold_author_form").animate({ scrollTop: 0 }, "slow")
                // $("#updateagentask_form .alert-danger").removeClass("alert-danger").addClass("alert-success");
                // $("#updateagentask_form .alert-success").css("display", "block");
                // $("#updateagentask_form .alert-success p").html(res.message);

                swal({
                    title: "Lead Successfully Updated",
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
                $("#edit_sold_author_form").animate({ scrollTop: 0 }, "slow")
                $("#edit_sold_author_form .alert-success").removeClass("alert-success").addClass("alert-danger");
                $("#edit_sold_author_form .alert-danger").css("display", "block");
                $("#edit_sold_author_form .alert-danger p").html(res.message);

                setTimeout(function () {
                    $("#edit_sold_author_form .alert-danger").css("display", "none");
                }, 4000);
            }
        }
      });
  });
});


    // $('.loadingModal').modal('show');
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




$(document).on("click", ".edit_sold_author", function (e) {
  e.preventDefault();

  var sold_author_id = $(this).data("sold_author_id");
  
  dataEdit = "sold_author_id=" + sold_author_id;
  $.ajax({
    type: "GET",

    data: dataEdit,

    url: base_url + "sold_author/view_sold_author_detail",

    dataType: "json",

    success: function (data) {
      var contact_string = "";
      var email_string = "";
      var get_contact_field = "";
      var get_email_field = "";
      let get_sold_author_id = 0;

      for (var i = 0; i < data.length; i++) {
        contact_string = data[i].customer_contact;
        email_string = data[i].customer_email;
        let contact_array = contact_string.split(","); // Splitting by comma converty string to array
        let email_array = email_string.split(","); // Splitting by comma converty string to array
        $(".view_sold_author input[name='customer_name']").val(data[i].customer_name);
        $(".view_sold_author input[name='sold_author_id']").val(
          data[i].sold_author_id
        );
        get_sold_author_id = data[i].sold_author_id;

        for (var i = 0; i < contact_array.length; i++) {
          get_contact_field +=
            '<div class="d-flex field-container mb-2 gap-1">' +
            '<input type="text" class="form-control" name="customer_contact[]" value="' +
            contact_array[i] +
            '" placeholder="Please Enter Contact Number">' +
            '<button type="button" data-lead_id="' +
            get_sold_author_id +
            '" data-customer_contact="' +
            contact_array[i] +
            '"  class="btn btn-danger removeFields8"><i class="ti ti-trash"></i></button>' +
            "</div>";
        }
        for (var i = 0; i < email_array.length; i++) {
          get_email_field +=
            '<div class="d-flex field-container mb-2 gap-1">' +
            '<input type="email" class="form-control" name="customer_email[]" value="' +
            email_array[i] +
            '" placeholder="Please Enter Email Address">' +
            '<button type="button" data-lead_id="' +
            get_sold_author_id +
            '" data-customer_email="' +
            email_array[i] +
            '"   class="btn btn-danger removeFields7"><i class="ti ti-trash"></i></button>' +
            "</div>";
        }
       
      }
      $(".view_sold_author .customer_contact_details").html(
        get_contact_field
      );
      $(".view_sold_author .customer_email_details").html(
        get_email_field
      );
    },
  });
});

$(document).ready(function() {
  // Initialize DataTable
  var table = $('#ListOfSoldAuthors_datatable').DataTable();

  // Initialize Select2
  $('#nameFilter').select2({

      placeholder: "Select multiple name",

      allowClear: true
  });

  // Event listener for filtering
  $('#nameFilter').on('change', function() {
      var selectedValues = $(this).val();
      table.column(1).search(selectedValues ? selectedValues.join('|') : '', true, false).draw();
  });
});
$(document).ready( function () {
  $('#ListOfSoldAuthorsAd_datatable').DataTable();
} );