$(document).ready( function () {
    $('#agent_leadgent').DataTable();
  } );
  $(document).ready( function () {
    $('#SalesLeadgentuserdatatable').DataTable();
  } );

// add multiple agent 
$('#savemultipleleadgentagentform').off('submit').on('submit', function(e) {
    e.preventDefault();
    
    let user_id = [];
    let checkedCount = $('.lead-checkbox:checked').length;

    if (checkedCount > 0) {
        $('.lead-checkbox:checked').each(function() {
            user_id.push($(this).data('user_id'));
        });

        $.ajax({
            url: `${base_url}tasks/Sales_Leadgent/assign_agent_to_leadgent`,
            type: 'POST',
            data: {
                user_id: user_id,
                assign_to: $('#user_id').val(),
            },
            success: function(response) {
                let res = JSON.parse(response);
                
                if (res.response === 'success') {
                    $("#addmultipleTaskModal").animate({ scrollTop: 0 }, "slow");
                    // $("#savemultipleleadgentagentform .alert-danger").removeClass("alert-danger").addClass("alert-success");

                    // $("#savemultipleleadgentagentform .alert-success").css("display", "block");
                    // $("#savemultipleleadgentagentform .alert-success p").html(res.message);

                    
            swal({
                title: "Agent successfully assigned",
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
                    showError(res.message);
                }
            },
            error: function() {
                showError('An error occurred while assigning the tasks. Please try again.');
            }
        });
    } else {
        showError("Please check at least one lead to assign leadgent.");
    }
});

function showError(message) {
  $("#addmultipleTaskModal").animate({ scrollTop: 0 }, "slow");
  $("#savemultipleleadgentagentform .alert-success").removeClass("alert-success").addClass("alert-danger");
  $("#savemultipleleadgentagentform .alert-danger").css("display", "block");
  $("#savemultipleleadgentagentform .alert-danger p").html(message);
  
  setTimeout(function(){
      $("#savemultipleleadgentagentform .alert-danger").css("display", "none");
  }, 4000);
}

// get data

$(document).on("click", ".edit_leadgent_agent", function(e){

    e.preventDefault();
    var agent_leadgent_id= $(this).data('task_id');

    var dataEdit = { agent_leadgent_id: agent_leadgent_id};

        $.ajax({

        type:'GET',

        data:dataEdit,

        url: base_url +'tasks/Sales_Leadgent/view_agent_leadgent',

        dataType: 'json',

        success:function(data){

            var tr ="";

            for (var i = 0; i < data.length; i++) {



               $(".update_leadgent_agent_form select[name='assign_leadgent']").val(data[i].leadgent_user_id);
               $(".update_leadgent_agent_form select[name='assign_agent']").val(data[i].agent_user_id);

               $(".update_leadgent_agent_form .agent_leadgent_id").val(data[i].agent_leadgent_id);
               $(".update_leadgent_agent_form .existing_leadgent_user_id").val(data[i].leadgent_user_id);
               $(".update_leadgent_agent_form .existing_agent_user_id").val(data[i].agent_user_id);

             }

          }

  });

});

// UPDATE

$('#update_leadgent_agent_form').submit(function(e) {
    var form = $(this);
    e.preventDefault();
 
    $.ajax({
        type: "POST",
        url: base_url +  "tasks/Sales_Leadgent/update_agent_leadgent",
        data: form.serialize(), // <--- THIS IS THE CHANGE
        dataType: 'json',
        success: function(res){
            if (res.response=="success"){
  
                // $("#update_leadgent_agent_form .alert-danger").removeClass("alert-danger").addClass("alert-success");
    
                // $("#update_leadgent_agent_form .alert-success").css("display", "block");
    
                // $("#update_leadgent_agent_form .alert-success p").html(res.message);
    
                swal({
                    title: "Agent Successfully Updated",
                    text: res.message,
                    icon: "success",
                    buttons: false,
                    timer: 2000
                }).then(() => {
                    $('#editlistoftask').modal().hide();
                    $('body').removeClass('modal-open'); 
                    $('.modal-backdrop').remove();
                    setTimeout(function () {
                        location.reload(); 
                    }, 1);
                 
                });

                // setTimeout(function(){
                //      window.location= res.redirect;
                // }, 2000);
    
            }
    
             else{
    
                $("#update_leadgent_agent_form .alert-success").removeClass("alert-success").addClass("alert-danger");
    
                $("#update_leadgent_agent_form .alert-danger").css("display", "block");
    
                $("#update_leadgent_agent_form .alert-danger p").html(res.message);
    
                setTimeout(function(){
    
                        $("#update_leadgent_agent_form .alert-danger").css("display", "none");
    
                    },4000);
    
           }
        },
   });
  
  });

// RECYCLE TASK OF AGENT
$(document).ready(function() {
    $('#recycle_editaskagentdataTable').DataTable();
  })

function get_task_data(user_id = 0, date_assigned = ""){
    let  id = user_id;
    let date = date_assigned;
    const dataTableElement = $('#recycle_editaskagentdataTable');
  
    // Destroy existing DataTable instance if it exists
    if ($.fn.DataTable.isDataTable(dataTableElement)) {
        dataTableElement.DataTable().destroy();
    }
  
    var editagenttaskrecycle_table = dataTableElement.DataTable({
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
            url: `${base_url}leadgent/sales_agent/fetch_recycle_agent_view_data/${id}/${date}`,
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
            { data: "source" },
        { data: "agent_priority" },
            { data: "lead_status" },
            
            { 
            data: "agent_date_assigned", 
                render: formatDate 
            },
            {
              data: null,
              render: (data, type, row) => 
                  `<input type="checkbox" class="task-checkbox" data-lead_id="${row.lead_id}" data-task_id="${row.agent_task_id}" checked><input type="hidden" readonly name="get_agent_task_id[]" value ="${row.agent_task_id}"><input type="hidden" name="lead_id[]" readonly value="${row.lead_id}">`
          }
        ]
        
    });
    // Event listener for the custom "Show entries" input
$('#entries_101').on('change', function() {
    var newLength = parseInt($(this).val(), 10);
    if (!isNaN(newLength) && newLength > 0) {
        editagenttaskrecycle_table.page.len(newLength).draw(); // Update page length and redraw table
    }
  });
  // Event listener for the custom search input
  $('#search').on('keyup', function() {
    editagenttaskrecycle_table.search(this.value).draw(); // Update table based on search input
  });

}  