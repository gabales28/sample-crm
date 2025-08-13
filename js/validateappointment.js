$(document).ready( function () {
  $('#appointmentdatatable').DataTable();
} );


  $('.appointment-title').inputpicker({
    url: base_url + "leads/fetch_lead_data",
    fields:['Lead Title', 'Description', 'Lead Value', 'Customer Name'],
    fieldText : 'Lead Title',
    fieldValue:'lead_id',
    width: "600px",
    headShow: true,
    filterOpen: true, 
    autoOpen: true,
  });
  $('.appointment-title2').inputpicker({
    url: base_url + "leads/fetch_lead_data",
    fields:['Lead Title', 'Description', 'Lead Value', 'Customer Name'],
    fieldText : 'Lead Title',
    fieldValue:'lead_id',
    width: "600px",
    headShow: true,
    filterOpen: true, 
    autoOpen: true,
  });

// add  function
$('#appointment_form').submit(function(e) {
  var form = $(this);
  e.preventDefault();
  // $('.loadingModal').modal('show');

  $.ajax({
      type: "POST",
      url: base_url +  "appointment/tableApp",
      data: form.serialize(), // <--- THIS IS THE CHANGE
      dataType: 'json',
      success: function(res){
          if (res.response=="success"){

            $('.loadingModal').modal('hide');

            $('#add_appointment').prop('disabled', true);

              $("#appointment_form .alert-danger").removeClass("alert-danger").addClass("alert-success");
  
              $("#appointment_form .alert-success").css("display", "block");
  
              $("#appointment_form .alert-success p").html(res.message);
  
                    setTimeout(function(){
  
                      location.reload();
  
                  },1000);
  
          }
  
           else{
            $('.loadingModal').modal('hide');

              $("#appointment_form .alert-success").removeClass("alert-success").addClass("alert-danger");
  
              $("#appointment_form .alert-danger").css("display", "block");
  
              $("#appointment_form .alert-danger p").html(res.message);
  
              setTimeout(function(){
  
                      $("#appointment_form .alert-danger").css("display", "none");
  
                  },4000);
  
         }
      },
 });

});

// get data

$(document).on("click", ".edit_appointment", function(e){
  e.preventDefault();
  var appointmentid= $(this).data('appointment_id');
  dataEdit = 'appointment_id='+ appointmentid;
      $.ajax({
      type:'GET',
      data:dataEdit,
      url: base_url +'appointment/view_appointment_details',
      dataType: 'json',
      success:function(data){
          var tr ="";
         
          for (var i = 0; i < data.length; i++) {
           
            $(".Editappointment_form input[name='appointment_id']").val(data[i].appointment_id);
             $(".Editappointment_form .assign_to").val(data[i].user_id).change();
             $(".Editappointment_form .appointment_status").val(data[i].appointment_status).change();
             $(".Editappointment_form input[name='appointment_schedule']").val(data[i].appointment_schedule);
             $(".Editappointment_form select[name='start_time']").val(data[i].start_time);
              $(".Editappointment_form select[name='end_time']").val(data[i].end_time);
             $(".Editappointment_form .appointment_remarks").text(data[i].appointment_remarks);
             $(".Editappointment_form input[name='title']").val(data[i].lead_id).trigger('change');
           }
        }
});
});

$('#Editappointment_form').submit(function(e) {
  var form = $(this);
  e.preventDefault();

  $.ajax({
      type: "POST",
      url: base_url +  "appointment/update_appointment_details",
      data: form.serialize(), // <--- THIS IS THE CHANGE
      dataType: 'json',
      success: function(res){
          if (res.response=="success"){

              $("#Editappointment_form .alert-danger").removeClass("alert-danger").addClass("alert-success");
  
              $("#Editappointment_form .alert-success").css("display", "block");
  
              $("#Editappointment_form .alert-success p").html(res.message);
  
              setTimeout(function(){
                   window.location= res.redirect;
              }, 2000);
  
          }
  
           else{
  
              $("#Editappointment_form .alert-success").removeClass("alert-success").addClass("alert-danger");
  
              $("#Editappointment_form .alert-danger").css("display", "block");
  
              $("#Editappointment_form .alert-danger p").html(res.message);
  
              setTimeout(function(){
  
                      $("#Editappointment_form .alert-danger").css("display", "none");
  
                  },4000);
  
         }
      },
 });

});


// ===============================================
// $(document).ready(function() {
//   $('#appointment_schedule').on('change', function() {
//       var selectedDate = $(this).val();

//       // Send AJAX request to fetch available and unavailable times
//       $.ajax({
//           url: 'appointment/checkAvailableTimes', // Update with your actual controller path
//           method: 'POST',
//           data: { date: selectedDate },
//           dataType: 'json',
//           success: function(response) {
//               // Assuming response contains arrays of unavailable start and end times
//               var unavailableTimes = response.unavailable_times;
//               var availableTimes = response.available_times;

//               // Enable all options first
//               $('#start_time option, #end_time option').prop('disabled', false);

//               // Disable unavailable start times
//               unavailableTimes.forEach(function(time) {
//                   $('#start_time option[value="' + time + '"]').prop('disabled', true);
//                   $('#end_time option[value="' + time + '"]').prop('disabled', true);
//               });

//               // Optionally, clear selection if the previously selected time is now disabled
//               if ($('#start_time option:selected').prop('disabled')) {
//                   $('#start_time').val('');
//               }

//               if ($('#end_time option:selected').prop('disabled')) {
//                   $('#end_time').val('');
//               }
//           }
//       });
//   });
// });

$(document).ready(function() {
  // Add time options dynamically for hours with AM/PM
  const periods = ['AM', 'PM'];
  for (let i = 1; i <= 12; i++) {
      let hour = i.toString().padStart(2, '0');
      periods.forEach(period => {
          $('#start_time, #end_time').append(`<option value="${hour}:00 ${period}">${hour}:00 ${period}</option>`);
      });
  }

  $('#appointment_schedule').on('change', function() {
      var selectedDate = $(this).val();

      // Send AJAX request to fetch available and unavailable times
      $.ajax({
          url: 'appointment/checkAvailableTimes', // Update with your actual controller path
          method: 'POST',
          data: { date: selectedDate },
          dataType: 'json',
          success: function(response) {
              var unavailableTimes = response.unavailable_times;

              // Reset selections and styles
              $('#start_time option, #end_time option').prop('disabled', false).css('font-weight', 'normal');

              unavailableTimes.forEach(function(time) {
                  // Convert time to 12-hour format with AM/PM
                  let [hour, period] = convertTo12HourFormat(time);
                  $('#start_time option[value="' + hour + ':00 ' + period + '"]').prop('disabled', true).css('font-weight', 'normal');
                  $('#end_time option[value="' + hour + ':00 ' + period + '"]').prop('disabled', true).css('font-weight', 'normal');
              });

              // Bold the available times
              $('#start_time option:not(:disabled), #end_time option:not(:disabled)').css('font-weight', 'bold');

              // Clear selections if the selected time is unavailable
              if ($('#start_time option:selected').prop('disabled')) {
                  $('#start_time').val('');
              }
              if ($('#end_time option:selected').prop('disabled')) {
                  $('#end_time').val('');
              }
          }
      });
  });

  function convertTo12HourFormat(time) {
      let [hours, minutes] = time.split(':');
      let period = 'AM';
      hours = parseInt(hours);
      if (hours >= 12) {
          period = 'PM';
          if (hours > 12) hours -= 12;
      } else if (hours === 0) {
          hours = 12;
      }
      return [hours.toString().padStart(2, '0'), period];
  }
});


