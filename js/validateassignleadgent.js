$('#leadgenttaskmodaldatatable').DataTable({
  processing: true,
  serverSide: true,
  fixedColumns: {
    start: 2,
    end: 2
},
scrollCollapse: true,
scrollX: true,

  ajax: {
      url: `${base_url}leads/fetch_lead_limit_data_modal`,
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
      { data: null, 
        "render": function(data, type, row) {
            return '<a href="javascript::void();" class="OpenModal view_lead_activity" data-lead_id='+row.lead_id+' data-toggle="modal" data-target="#activityModal">'+row.title+'</a>';
        } 
    },
      // { data: "description" },
      // { data: "lead_value" },
      { data: "source" },
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
      { 
          data: "date_created", 
          render: formatDate 
      },
      { 
          data: null, 
          render: (data, type, row) => `<input type="checkbox" class="lead-checkbox" data-lead_id="${row.lead_id}">` 
      }
      // Additional columns can be added here
  ]
});



$(document).ready( function () {
  $('#leadgenttaskmodaldatatable').DataTable();
} );

$(document).ready( function () {
  $('#leadgenttaskdatatable').DataTable();
} );
$(document).ready( function () {
  $('#edileadgenttaskdataTable').DataTable();
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




$('#addleadgenttaskform').submit(function(e) {
  var form = $(this);
  e.preventDefault();
  // $('.loadingModal').modal('show');


  $.ajax({
      type: "POST",
      url: base_url +  "Leadgents/add_leadgent_task",
      data: form.serialize(), // <--- THIS IS THE CHANGE
      dataType: 'json',
      success: function(res){
          if (res.response=="success"){

            $('.loadingModal').modal('hide');

            $('#addleadgenttask').prop('disabled', true);

              $("#addleadgenttaskform .alert-danger").removeClass("alert-danger").addClass("alert-success");
  
              $("#addleadgenttaskform .alert-success").css("display", "block");
  
              $("#addleadgenttaskform .alert-success p").html(res.message);
  
                    setTimeout(function(){
  
                      location.reload();
  
                  },900);
  
          }
  
           else{
            $('.loadingModal').modal('hide');

              $("#addleadgenttaskform .alert-success").removeClass("alert-success").addClass("alert-danger");
  
              $("#addleadgenttaskform .alert-danger").css("display", "block");
  
              $("#addleadgenttaskform .alert-danger p").html(res.message);
  
              setTimeout(function(){
  
                      $("#addleadgenttaskform .alert-danger").css("display", "none");
  
                  },4000);
  
         }
      },
 });

});


$('#editleadgenttaskform').submit(function(e) {
  var form = $(this);
  e.preventDefault();

  $.ajax({
      type: "POST",
      url: base_url +  "Leadgents/update_leadgent_task",
      data: form.serialize(), // <--- THIS IS THE CHANGE
      dataType: 'json',
      success: function(res){
          if (res.response=="success"){

              $("#editleadgenttaskform .alert-danger").removeClass("alert-danger").addClass("alert-success");
  
              $("#editleadgenttaskform .alert-success").css("display", "block");
  
              $("#editleadgenttaskform .alert-success p").html(res.message);
  
              setTimeout(function(){
                    location.reload();
                  }, 1000);
  
          }
  
           else{
  
              $("#editleadgenttaskform .alert-success").removeClass("alert-success").addClass("alert-danger");
  
              $("#editleadgenttaskform .alert-danger").css("display", "block");
  
              $("#editleadgenttaskform .alert-danger p").html(res.message);
  
              setTimeout(function(){
  
                      $("#editleadgenttaskform .alert-danger").css("display", "none");
  
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
      url: 'leadgent/save_leadgent_tasks',
      type: 'POST',
      data: {
          lead_ids: lead_ids,
          assign_to: $('#user_id').val(),
          // priority: $('#priority').val(),
          lead_status: "not yet open",
          remarks: $('#remarks').val(),


      },
      success: function(response) {
          let res = JSON.parse(response);
          if (res.response === 'success') {
            $("#addmultipleTaskModal").animate({ scrollTop: 0 }, "slow")
            $("#savemultipleleadgenttaskform .alert-danger").removeClass("alert-danger").addClass("alert-success");
  
              $("#savemultipleleadgenttaskform .alert-success").css("display", "block");
            
              $("#savemultipleleadgenttaskform .alert-success p").html(res.message);
  
              setTimeout(function(){
                    location.reload();
                  }, 1000);
  
          
          } else {
            $("#addmultipleTaskModal").animate({ scrollTop: 0 }, "slow")

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

  $("#savemultipleleadgenttaskform .alert-danger p").html("Please check at least one lead to assign user");


  setTimeout(function(){

          $("#savemultipleleadgenttaskform .alert-danger").css("display", "none");

      },4000);
}
});
// end save multipletaskform


// get data
$(document).on("click", ".edit_leadgent_task", function(e){

  e.preventDefault();

    var leadgenttaskid= $(this).data('leadgent_task_id');
    var user_id= $(this).data('user_id');
    var date_assigned= $(this).data('date_assigned');
    dataEdit = 'leadgent_task_id='+ leadgenttaskid;
     get_task_data(user_id, date_assigned);
      $.ajax({

      type:'GET',

      data:dataEdit,

      url: base_url +'Leadgents/view_leadgent_task_detail',

      dataType: 'json',

      success:function(data){
          var tr ="";
          for (var i = 0; i < data.length; i++) {

             $(".editleadgenttask_form .leadgent_task_id").val(data[i].leadgent_task_id);
             $(".editleadgenttask_form .assign_to").val(data[i].user_id).change();
             $(".editleadgenttask_form .remarks").text(data[i].remarks);
            //  $(".editleadgenttask_form .priority").val(data[i].priority);
             $(".editleadgenttask_form .title").val(data[i].lead_id);
           }
        }
     });
});

// start list of tasks
function get_leadgent_task_data(user_id = 0, date_assigned = "") {
  let  id = user_id;
  let date = date_assigned;
  const dataTableElement = $('#edileadgenttaskdataTable');

  // Destroy existing DataTable instance if it exists
  if ($.fn.DataTable.isDataTable(dataTableElement)) {
      dataTableElement.DataTable().destroy();
  }

  dataTableElement.DataTable({
      processing: true,
      serverSide: false,
      ajax: {
          url: `${base_url}leadgents/fetch_edit_data/${id}/${date}`,
          type: "GET"
      },
      columns: [
          { 
              data: "lead_id", 
              render: data => `Lead${String(data).padStart(4, '0')}` 
          },
          { data: null, 
            "render": function(data, type, row) {
                return '<a href="javascript::void();" class="OpenModal view_lead_activity" data-lead_id='+row.lead_id+' data-toggle="modal" data-target="#activityModal">'+row.title+'</a>';
            } 
        },
          // { data: "description" },
          // { data: "lead_value" },
          { data: "source" },
          // { 
          //   data: "priority",
          //   render: function (data, type, row) {
          //     // Create a dropdown menu for priority
          //     const priorities = ["Low", "Medium", "High"];
          //     let options = priorities.map(priority => {
          //       // Set the selected option if it matches the current priority
          //       return `<option value="${priority}" ${data === priority ? 'selected' : ''}>${priority}</option>`;
          //     }).join('');
              
          //     return `<select class="priority-dropdown" name="priority[]" data-task_id="${row.task_id}">
          //               ${options}
          //             </select><input type="hidden" readonly name="get_task_id[]" value ="${row.task_id}"><input type="hidden" name="lead_id[]" readonly value="${row.lead_id}">`;
          //   }
          // },
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
                  return `<a href="https://mail.google.com/mail/?view=cm&fs=1&to=${trimmedEmail}">${trimmedEmail}</a>`;
              }).join('<br>');
            } 
        },
          { 
              data: "date_assigned", 
              render: formatDate 
          },
          { 
            data: "remarks",
            render: function (data, type, row) {
                return `<input type="text" class="remarks-input" name="remarks[]" value="${data}" data-task_id="${row.leadgent_task_id}">`;
            }
          },
          {
            data: null,
            render: (data, type, row) => 
                `<input type="checkbox" class="leadgent-task-checkbox" data-lead_id="${row.lead_id}" data-task_id="${row.leadgent_task_id}" checked>`
        }
      ]
  });




  // delete module
  $('#update_leadgent_task_form').on('submit', function(e) {
    e.preventDefault(); // Prevent default form submission

    let checkedleadgentTasks = [];
    let uncheckedleadgentTasks = [];
    let uncheckedLeads = [];
    let priorityUpdates = {};

    $('.leagent-task-checkbox').each(function() {
        let leadgenttaskId = $(this).data('leadgenttask_id');
        let leadId = $(this).data('lead_id');
        if ($(this).is(':checked')) {
            checkedleadgentTasks.push(leadgenttaskId);
        } else {
            uncheckedleadgentTasks.push(leadgenttaskId);
            uncheckedLeads.push(leadId);
        }
    });

    // $('.priority-dropdown').each(function() {
    //     let taskId = $(this).data('task_id');
    //     let selectedPriority = $(this).val();
    //     priorityUpdates[taskId] = selectedPriority; // Store priority updates
    // });

    $.ajax({
        url: `${base_url}Leadgents/save_leagent_taskss`,
        type: "POST",
        data: $(this).serialize() + 
              '&checked_leadgent_tasks=' + checkedleadgentTasks + 
              '&unchecked_leadgent_tasks=' + uncheckedleadgentTasks +
              '&unchecked_Lead=' + uncheckedLeads,
        dataType: 'json',
        success: function(res) {
            if (res.response === 'success') {
                $("#editlistoftask").animate({ scrollTop: 0 }, "slow")
                $("#update_leadgent_task_form .alert-danger").removeClass("alert-danger").addClass("alert-success");
                $("#update_leadgent_task_form .alert-success").css("display", "block");
                $("#update_leadgent_task_form .alert-success p").html(res.message);

                setTimeout(function(){
                    location.reload();
                }, 1000);
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
}



// $(document).ready(function() {
//   $('#update_leadgent_task_form').on('submit', function(e) {
//       e.preventDefault(); // Prevent the default form submission

//       $.ajax({
//           url: 'Tasks/updates',
//           type: 'POST',
//           data: $(this).serialize(),
//           dataType: 'json',
//           success: function(response) {
//               if (response.status === 'success') {
//                   $('.alert-success p').text(response.message);
//                   $('.alert-success').show();
//                   // Optionally, refresh the data table or close the modal
//               } else {
//                   alert(response.message);
//               }
//           },
//           error: function() {
//               alert('An error occurred while updating the task.');
//           }
//       });
//   });
// });

// end list of tasks



// $('#update_leadgent_task_form').submit(function(e) {
//   var form = $(this);
//   e.preventDefault();

//   $.ajax({
//       type: "POST",
//       url: base_url +  "Tasks/update_task_details",
//       data: form.serialize(), // <--- THIS IS THE CHANGE
//       dataType: 'json',
//       success: function(res){
//           if (res.response=="success"){

//               $("#update_leadgent_task_form .alert-danger").removeClass("alert-danger").addClass("alert-success");
  
//               $("#update_leadgent_task_form .alert-success").css("display", "block");
  
//               $("#update_leadgent_task_form .alert-success p").html(res.message);
  
//               setTimeout(function(){
//                    window.location= res.redirect;
//               }, 2000);
  
//           }
  
//            else{
  
//               $("#update_leadgent_task_form .alert-success").removeClass("alert-success").addClass("alert-danger");
  
//               $("#update_leadgent_task_form .alert-danger").css("display", "block");
  
//               $("#update_leadgent_task_form .alert-danger p").html(res.message);
  
//               setTimeout(function(){
  
//                       $("#update_leadgent_task_form .alert-danger").css("display", "none");
  
//                   },4000);
  
//          }
//       },
//  });

// });