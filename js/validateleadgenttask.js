 var leadgent_table = $('#leadgent_taskmodaldatatable').DataTable({
  processing: true,
  serverSide: true,
  fixedColumns: {
    start: 2,
    end: 2
},
scrollCollapse: true,
scrollX: true,

  // "pageLength": 1000, // Default number of entries
  // "lengthMenu": [500, 1000, 2000, 3000], // Options for entries per page
  "dom": 'rt<"d-flex mt-2 mb-2 justify-content-between align-items-center"ip>', // Removes the default length menu control
  ajax: {
      url: `${base_url}leads/fetch_lead_limit_leadgent_data_modal`,
      type: "GET",
      error: function(xhr, error, thrown) {
          console.error("Ajax error: ", error);
          alert("An error occurred while fetching data. Please try again.");
      }
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
    { data: "customer_address", render: function(data, type, row){
      return data.substring(0, 15);
    }},
    { data: "brand_name" },

      { data: null, 
        "render": function(data, type, row) {
            return '<a href="javascript::void();" class="OpenModal view_lead_activity" data-lead_id='+row.lead_id+' data-toggle="modal" data-target="#activityModal">'+row.title+'</a>';
        } 
    },
      // { data: "description" },
      { data: "book_link", render: function(data, type, row) {
        return '<a href="' + data + '" target="_blank" rel="noopener noreferrer">' + data.substring(0, 15) + '</a>';
    }},
      { data: "source" },
      
      { data: "lead_status" },
      { 
          data: "date_created", 
          render: formatDate 
      },
      { 
          data: null, 
          render: (data, type, row) => `<input type="checkbox" class="lead-checkbox" data-lead_id="${row.lead_id}" checked>` 
      }
      // Additional columns can be added here
  ],
  drawCallback: function() {
    // Add event listener to rows after each draw (to handle dynamic row rendering)
    $('#leadgent_taskmodaldatatable tbody').on('click', 'tr', function() {
      // Remove the highlight (background color) from all rows
      $('#leadgent_taskmodaldatatable tbody tr').css('background-color', '');

      // Set the background color of the clicked row to highlight it
      $(this).css('background-color', 'rgb(211, 234, 253)');  // Change the color as needed (e.g., light green)
    });
  }
});
  // Event listener for the custom "Show entries" input
  $('#entries_2').on('change', function() {
    var newLength = parseInt($(this).val(), 10);
    if (!isNaN(newLength) && newLength > 0) {
      leadgent_table.page.len(newLength).draw(); // Update page length and redraw table
    }
}).on('keypress', function(e) {
  if (e.which === 13) {
      e.preventDefault(); // Disable the Enter key
  }
});
// Event listener for the custom search input
$('#search').on('keyup', function() {
  leadgent_table.search(this.value).draw(); // Update table based on search input
});
$(document).ready( function () {
  $('#leadgent_taskdatatable').DataTable();
} );


$('.filter_title').inputpicker({
  url: base_url + "leads/fetch_lead_data",
  fields:['Lead Title', 'Description', 'Lead Value', 'Customer Name'],
  fieldText : 'Lead Title',
  fieldValue:'lead_id',
  width: "600px",
  headShow: true,
  filterOpen: true, 
  autoOpen: true,
});




$('#addtaskform').submit(function(e) {
  var form = $(this);
  e.preventDefault();
  // $('.loadingModal').modal('show');


  $.ajax({
      type: "POST",
      url: base_url +  "tasks/add_task",
      data: form.serialize(), // <--- THIS IS THE CHANGE
      dataType: 'json',
      success: function(res){
          if (res.response=="success"){

            $('.loadingModal').modal('hide');

            $('#addtask').prop('disabled', true);

              $("#addtaskform .alert-danger").removeClass("alert-danger").addClass("alert-success");
  
              $("#addtaskform .alert-success").css("display", "block");
  
              $("#addtaskform .alert-success p").html(res.message);
  
                    setTimeout(function(){
  
                      location.reload();
  
                  },900);
  
          }
  
           else{
            $('.loadingModal').modal('hide');

              $("#addtaskform .alert-success").removeClass("alert-success").addClass("alert-danger");
  
              $("#addtaskform .alert-danger").css("display", "block");
  
              $("#addtaskform .alert-danger p").html(res.message);
  
              setTimeout(function(){
  
                      $("#addtaskform .alert-danger").css("display", "none");
  
                  },4000);
  
         }
      },
 });

});


$('#edittaskform').submit(function(e) {
  var form = $(this);
  e.preventDefault();

  $.ajax({
      type: "POST",
      url: base_url +  "tasks/update_task",
      data: form.serialize(), // <--- THIS IS THE CHANGE
      dataType: 'json',
      success: function(res){
          if (res.response=="success"){

              $("#edittaskform .alert-danger").removeClass("alert-danger").addClass("alert-success");
  
              $("#edittaskform .alert-success").css("display", "block");
  
              $("#edittaskform .alert-success p").html(res.message);
  
              setTimeout(function(){
                    location.reload();
                  }, 1000);
  
          }
  
           else{
  
              $("#edittaskform .alert-success").removeClass("alert-success").addClass("alert-danger");
  
              $("#edittaskform .alert-danger").css("display", "block");
  
              $("#edittaskform .alert-danger p").html(res.message);
  
              setTimeout(function(){
  
                      $("#edittaskform .alert-danger").css("display", "none");
  
                  },4000);
  
         }
      },
 });

});
// start list of tasks
// $(document).ready(function() {
//   $('#taskdatatable').DataTable({
//       "processing": true,
//       "serverSide": true,
//       "ajax": {
//           "url": base_url + 'tasks/fetch_task_limit_data',
//           "type": "GET"
//       },
//       "columns": [
//           { data: "task_id", render: function(data) { return `Task${String(data).padStart(4, '0')}`; } },
//           { data: "title" },
//           { data: "lead_value" },
//           { data: "customer_name" },
//           { data: 'customer_contact', 
//             render: function(data) {
//                 return data.split(',').join('<br>'); // Breaks the contact numbers into new lines
//             } 
//           },
//          {  data: 'customer_email', 
//             render: function(data) {
//               return data.split(',').join('<br>'); // Breaks the emails into new lines
//           } 
//         },
//         { 
//           data: null, 
//           render: function(data) {
//               return `${data.fname} ${data.lname}`; // Combine first and last name
//           } 
//         },
//         { data: "priority" },
//         { data: "lead_status" },
//         { data: "remarks" },
//         { data: "date_assigned", render: formatDate },
//         { data: "description" },
//         { data: "tasks_total" },
//         { 
//             data: null, 
//             "render": function(data, type, row) {
//                 return '<button type="button" class="btn btn-md btn-danger edit_task" data-task_id='+row.task_id+' data-user_id='+row.user_id+' data-date_assigned='+formatDate_assigned(row.date_assigned)+' data-toggle="modal" data-target="#editmultipleTaskModal">Edit</button>';
//             } 
            
//         }
//           // Add more columns as needed
//       ]
      
// });

// });
// end list of tasks

function formatDate_assigned(data) {
  if (!data) return '';
  const date = new Date(data);
  return moment(date).format('YYYY-MM-DD');
}
// start save multipletaskform
$('#savemultipleleadgenttaskform').on('submit', function(e) {
  e.preventDefault();
  let lead_ids = [];
  var checkedCount = $('.lead-checkbox:checked').length;

  if (checkedCount > 0) {
    
  $('.lead-checkbox:checked').each(function() {
    lead_ids.push($(this).data('lead_id'));
});
  $.ajax({
      url:  `${base_url}tasks/leadgent/save_leadgent_tasks`,
      type: 'POST',
      data: {
          lead_ids: lead_ids,
          assign_to: $('#user_id').val(),
          remarks: $('#remarks').val(),
          total_leads: checkedCount
      },
      success: function(response) {
          let res = JSON.parse(response);
          if (res.response === 'success') {
            $("#addmultipleleadgentsTaskModal").animate({ scrollTop: 0 }, "slow")
            // $("#savemultipleleadgenttaskform .alert-danger").removeClass("alert-danger").addClass("alert-success");
  
            //   $("#savemultipleleadgenttaskform .alert-success").css("display", "block");
            
              // $("#savemultipleleadgenttaskform .alert-success p").html(res.message);


              swal({
                title: "Lead Successfully Assigned",
                text: res.message,
                icon: "success",
                buttons: false,
                timer: 2000
            }).then(() => {
                $('#editLeadsModal').modal().hide();
                $('body').removeClass('modal-open'); 
                $('.modal-backdrop').remove();
                setTimeout(function () {
                  location.reload(); 
              }, 1);
            });
  
  
              // setTimeout(function(){
              //       location.reload();
              //     }, 1000);
  
          
          } else {
            $("#addmultipleleadgentsTaskModal").animate({ scrollTop: 0 }, "slow")

            $("#savemultipleleadgenttaskform .alert-success").removeClass("alert-success").addClass("alert-danger");
  
            $("#savemultipleleadgenttaskform .alert-danger").css("display", "block");

            $("#savemultipleleadgenttaskform .alert-danger p").html(res.message);

            setTimeout(function(){

                    $("#savemultipleleadgenttaskform .alert-danger").css("display", "none");

                },4000);
          }
      }
  });
}
else{
  $("#addmultipleTaskModal").animate({ scrollTop: 0 }, "slow")
  $("#savemultipleleadgenttaskform .alert-success").removeClass("alert-success").addClass("alert-danger");
  
  $("#savemultipleleadgenttaskform .alert-danger").css("display", "block");

  $("#savemultipleleadgenttaskform .alert-danger p").html("Please check at least one lead to assign leadgent");


  setTimeout(function(){

          $("#savemultipleleadgenttaskform .alert-danger").css("display", "none");

      },4000);
}
});
// end save multipletaskform


// get data
$(document).on("click", ".edit_task", function(e){

  e.preventDefault();

    var taskid= $(this).data('task_id');
    var user_id= $(this).data('user_id');
    var date_assigned= $(this).data('date_assigned');
    dataEdit = 'task_id='+ taskid;

    get_task_leadgent_data(user_id, date_assigned);
      $.ajax({

      type:'GET',

      data:dataEdit,

      url: base_url +'Tasks/leadgent/view_leadgent_Task_detail',

      dataType: 'json',

      success:function(data){
          var tr ="";
          for (var i = 0; i < data.length; i++) {

             $(".editleadgenttask_form .task_id").val(data[i].task_id);
             $(".editleadgenttask_form .assign_to").val(data[i].leadgent_user_id).change();
             $(".editleadgenttask_form .remarks").text(data[i].remarks);
             $(".editleadgenttask_form .priority").val(data[i].priority);
             $(".editleadgenttask_form .title").val(data[i].lead_id);
             $(".editleadgenttask_form .existing_user_id").val(data[i].leadgent_user_id);
           }
        }
     });
});


$(document).ready(function() {
  $('#editaskdataTable').DataTable();
})

// start list of tasks
function get_task_leadgent_data(user_id = 0, date_assigned = "") {
  let  id = user_id;
  let date = date_assigned;
  const dataTableElement = $('#editaskdataTable');

  // Destroy existing DataTable instance if it exists
  if ($.fn.DataTable.isDataTable(dataTableElement)) {
      dataTableElement.DataTable().destroy();
  }

  var edit_lead_table = dataTableElement.DataTable({
      processing: true,
      serverSide: false,
      fixedColumns: {
        start: 2,
        end: 2
    },
    scrollCollapse: true,
    scrollX: true,
   
      "dom": 'rt<"d-flex mt-2 mb-2 justify-content-between align-items-center"ip>',
      ajax: {
          url: `${base_url}tasks/leadgent/fetch_leadgent_edit_data/${id}/${date}`,
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
      { data: "customer_address", render: function(data, type, row){
        return data.substring(0, 15);
      }},
      { data: "brand_name" },

          { data: null, 
            "render": function(data, type, row) {
                return '<a href="javascript::void();" class="OpenModal view_lead_activity" data-lead_id='+row.lead_id+' data-toggle="modal" data-target="#activityModal">'+row.title+'</a>';
            } 
        },
        { data: "book_link", render: function(data, type, row) {
          return '<a href="' + data + '" target="_blank" rel="noopener noreferrer">' + data.substring(0, 15) + '</a>';
      }},
          // { data: "lead_value" },
          { data: "source" },
         
          
          { data: "lead_status" },
          { 
              data: "date_assigned", 
              render: formatDate 
          },
          {
            data: null,
            render: (data, type, row) => 
                `<input type="checkbox" class="task-checkbox" data-lead_id="${row.lead_id}" data-task_id="${row.leadgent_task_id}" checked><input type="hidden" readonly name="get_leadgent_task_id[]" value ="${row.leadgent_task_id}"><input type="hidden" name="lead_id[]" readonly value="${row.lead_id}">`
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
$('#entriesnum_3').on('change', function() {
  var newLength = parseInt($(this).val(), 10);
  if (!isNaN(newLength) && newLength > 0) {
    edit_lead_table.page.len(newLength).draw(); // Update page length and redraw table
  }
});
// Event listener for the custom search input

$('#searches').on('keyup', function() {
  edit_lead_table.search(this.value).draw(); // Update table based on search input
});
}





  // delete module
  $('#update_leadgent_task_form').on('submit', function(e) {
    e.preventDefault(); // Prevent default form submission

    let checkedTasks = [];
    let uncheckedTasks = [];
    let uncheckedLeads = [];
    let priorityUpdates = {};

    $('.task-checkbox').each(function() {
        let taskId = $(this).data('task_id');
        let leadId = $(this).data('lead_id');
        if ($(this).is(':checked')) {
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
        url: `${base_url}tasks/leadgent/save_leagent_taskss`,
        type: "POST",
        data: $(this).serialize() + 
              '&checked_tasks=' + checkedTasks + 
              '&unchecked_tasks=' + uncheckedTasks +
              '&unchecked_Lead=' + uncheckedLeads,
        dataType: 'json',
        success: function(res) {
            if (res.response === 'success') {
                $("#editlistoftask").animate({ scrollTop: 0 }, "slow")
                // $("#update_leadgent_task_form .alert-danger").removeClass("alert-danger").addClass("alert-success");
                // $("#update_leadgent_task_form .alert-success").css("display", "block");
                // $("#update_leadgent_task_form .alert-success p").html(res.message);

                 
            swal({
              title: "Lead Generations Task Successfully Updated",
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
              $("#editlistoftask").animate({ scrollTop: 0 }, "slow")
                $("#update_leadgent_task_form .alert-success").removeClass("alert-success").addClass("alert-danger");
                $("#update_leadgent_task_form .alert-danger").css("display", "block");
                $("#update_leadgent_task_form .alert-danger p").html(res.message);

                setTimeout(function(){
                    $("#update_leadgent_task_form .alert-danger").css("display", "none");
                }, 4000);
            }
        }
    });
});


// VIEW
$(document).ready(function() {
  $('#view_editaskagentdataTable').DataTable();
})

// start list of tasks
// function view_get_task_data(user_id = 0, date_assigned = ""){
//   let  id = user_id;
//   let date = date_assigned;
//   const dataTableElement = $('#view_editaskagentdataTable');

//   // Destroy existing DataTable instance if it exists
//   if ($.fn.DataTable.isDataTable(dataTableElement)) {
//       dataTableElement.DataTable().destroy();
//   }

//   var vieweditagenttask_table = dataTableElement.DataTable({
//       processing: true,
//       serverSide: false,
//       "dom": 'rt<"d-flex mt-2 mb-2 justify-content-between align-items-center"ip>',
//       ajax: {
//           url: `${base_url}leadgent/view_sales_tasks/fetch_agent_view_data_task/${id}/${date}`,
//           type: "GET"
//       },
//       columns: [
//           { 
//               data: "lead_id", 
//               render: data => `Lead${String(data).padStart(4, '0')}` 
//           },
//           { data: "customer_name" },
//           { data: 'customer_contact', 
//               render: function(data) {
//               return data.split(',').map(contact => `<a href="tel:${contact.trim()}">${contact.trim()}</a>`).join('<br>'); // Converts contact numbers into clickable links
//              } 
//           },
//           { data: 'customer_email', 
//               render: function(data) {
//               return data.split(',').map(email => {
//                   const trimmedEmail = email.trim();
//                   return `<a href="https://mail.google.com/mail/?view=cm&fs=1&to=${trimmedEmail}">${trimmedEmail}</a>`;
//               }).join('<br>');
//           } 
//       }, 
//       { data: "customer_address" },
//       { data: "brand_name" },
//         { data: null, 
//           "render": function(data, type, row) {
//               return '<a href="javascript::void();" class="OpenModal view_lead_activity" data-lead_id='+row.lead_id+' data-toggle="modal" data-target="#activityModal">'+row.title+'</a>';
//           } 
//       },
      
//         { data: "book_link", render: function(data, type, row) {
//           return '<a href="' + data + '" target="_blank" rel="noopener noreferrer">' + data.substring(0, 15) + '</a>';
//       }},
      
//           { data: "source" },
//           { data: "priority" },
//       {
//           data: null,
//           render: function (data) {
//               return `${data.fname} ${data.lname}`; // Combine first and last name
//           }
//       },
//       {
//           data: null,
//           render: function (data) {
//               return `${data.agent_fname} ${data.agent_lname}`; // Combine first and last name
//           }
//       },
//       { data: "lead_status" },
//       { data: "services_status" },
//       { data: "agent_priority" },
//       { data: "agent_remarks" },

//       // { data: "status_services" },
//       { data: "date_assigned" },
//       { data: "agent_date_assigned", render: formatDate },
//       {
//           "data": "remark_tasks", "render": function (data, type, row) {
//               return data ? '<textarea class="form-control edit_remark" style="width: 250px;"  data-lead_id="' + row.lead_id + '" rows="4" id="comment">' + data + '</textarea>' :
//                   '<textarea class="form-control edit_remark"  data-lead_id="' + row.lead_id + '" rows="4" id="comment"></textarea>';
//           }
//       },
          
//       ]
      
//   });
//   // Event listener for the custom "Show entries" input
// $('#entries_7').on('change', function() {
//   var newLength = parseInt($(this).val(), 10);
//   if (!isNaN(newLength) && newLength > 0) {
//       vieweditagenttask_table.page.len(newLength).draw(); // Update page length and redraw table
//   }
// });
// // Event listener for the custom search input
// $('#search').on('keyup', function() {
//   vieweditagenttask_table.search(this.value).draw(); // Update table based on search input
// });

// }


// end save multipletaskform
$(document).on("click", ".view_agent_task", function(e){

  e.preventDefault();

    var user_id= $(this).data('user_id');
     view_lead_task_data(user_id)
 
  });       
                                                                                                                                                                                                          
                                                                                                                                                                                                                                                                  
function view_lead_task_data(user_id =0){
  let  id = user_id;
  const dataTableElement = $('#view_editaskagentdataTable');

  // Destroy existing DataTable instance if it exists
  if ($.fn.DataTable.isDataTable(dataTableElement)) {
      dataTableElement.DataTable().destroy();
  }

  var vieweditagenttask_table = dataTableElement.DataTable({
      "processing": true,
      "serverSide": true,
      fixedColumns: {
        start: 2,
        end: 1
    },
    scrollCollapse: true,
    scrollX: true,
    
      // "pageLength": 100, // Default number of entries
      // "lengthMenu": [100, 200, 500, 1000, 2000, 3000], // Options for entries per page
      "dom": 'rt<"d-flex mt-2 mb-2 justify-content-between align-items-center"ip>',

      ajax: {
          url: `${base_url}tasks/fetch_lead_agent_task_view_task/?user_id=${id}`,
          type: "GET"
      },
      "columns": [
        { data: "lead_id", render: function (data) { return `Lead${String(data).padStart(4, '0')}`; } },
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
      { data: "customer_address", render: function(data, type, row){
        return data.substring(0, 15);
      }},
        { data: "brand_name" },
        { data: null, 
            "render": function(data, type, row) {
                return '<a href="javascript::void();" class="OpenModal view_lead_activity" data-lead_id='+row.lead_id+' data-toggle="modal" data-target="#activityModal">'+row.title+'</a>';
            } 
        },
          // { d
        // { data: "description" },
        // { data: "lead_value" },
        { data: "book_link", render: function(data, type, row) {
            return '<a href="' + data + '" target="_blank" rel="noopener noreferrer">' + data.substring(0, 15) + '</a>';
        }},
        { data: "source" },
        {
            data: null,
            render: function (data) {
                return `${data.agent_fname} ${data.agent_lname}`; // Combine first and last name
            }
        },
        { data: "lead_status" },
        { data: "agent_priority" },
        { data: "services_status" },
        { data: "agent_remarks" },
        { data: "sales_remarks" },


        // { data: "status_services" },
        { data: "agent_date_assigned", render: formatDate },
        { "data": "remark_tasks", "render": function(data, type, row) {
            return data ? '<textarea class="form-control edit_remark" style="width: 250px;"  data-lead_id="'+row.lead_id+'" rows="1" id="comment">'+data+'</textarea>' :
            '<textarea class="form-control edit_remark"  data-lead_id="'+row.lead_id+'" rows="1" id="comment"></textarea>';   
        }},

    ],
    drawCallback: function() {
      // Add event listener to rows after each draw (to handle dynamic row rendering)
      $('#view_editaskagentdataTable tbody').on('click', 'tr', function() {
        // Remove the highlight (background color) from all rows
        $('#view_editaskagentdataTable tbody tr').css('background-color', '');
  
        // Set the background color of the clicked row to highlight it
        $(this).css('background-color', 'rgb(211, 234, 253)');  // Change the color as needed (e.g., light green)
      });
    }
      
  });
  // Event listener for the custom "Show entries" input
  $('#entries_7').on('change', function() {
    var newLength = parseInt($(this).val(), 10);
    if (!isNaN(newLength) && newLength > 0) {
        vieweditagenttask_table.page.len(newLength).draw(); // Update page length and redraw table
    }
  });
  // Event listener for the custom search input
  $('#search_view_leadgent').on('keyup', function() {
    vieweditagenttask_table.search(this.value).draw(); // Update table based on search input
  });
  
}
$(document).on('blur ','#view_editaskagentdataTable .edit_remark',function(e) {
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

function myFunction() {
  var input, filter, table, tr, td, i, txtValue;
  input = document.getElementById("myInput");
  filter = input.value.toUpperCase();
  table = document.getElementById("myTable");
  tr = table.getElementsByTagName("tr");
  for (i = 0; i < tr.length; i++) {
    td = tr[i].getElementsByTagName("td")[0];
    if (td) {
      txtValue = td.textContent || td.innerText;
      if (txtValue.toUpperCase().indexOf(filter) > -1) {
        tr[i].style.display = "";
      } else {
        tr[i].style.display = "none";
      }
    }       
  }
}