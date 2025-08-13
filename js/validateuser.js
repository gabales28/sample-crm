

$(document).on('click','.formlogin #login',function(e) {

  e.preventDefault();
  $.ajax({

         type: "POST",

         url: base_url +  "login/login_user",

         dataType: 'json',

         data: $(".formlogin").serialize(),

         success: function(res) {

         if (res.response=="success"){

            $(".formlogin .alert-danger").removeClass("alert-danger").addClass("alert-success");

            $(".formlogin .alert-success").css("display", "block");

            $(".formlogin .alert-success p").html(res.message);
            
            setTimeout(function(){

              window.location= res.redirect;

           },1000);

        }
  
         else{      
            $(".formlogin .alert-success").removeClass("alert-success").addClass("alert-danger");

            $(".formlogin .alert-danger").css("display", "block");

            $(".formlogin .alert-danger p").html(res.message);

            setTimeout(function(){

                    $("#loginForm .alert-danger").css("display", "none");

              },1000);


       }

    },

  });

 });


 $(document).on('click','#forgotPasswordForm #reset',function(e) {

  e.preventDefault();
  $.ajax({

         type: "POST",

         url: base_url +  "account/send_reset_link",

         dataType: 'json',

         data: $("#forgotPasswordForm").serialize(),

         success: function(res) {

         if (res.response=="success"){

            $("#forgotPasswordForm .alert-danger").removeClass("alert-danger").addClass("alert-success");

            $("#forgotPasswordForm .alert-success").css("display", "block");

            $("#forgotPasswordForm .alert-success p").html(res.message);
            
            setTimeout(function(){

              location.reload();

           },900);

        }
  
         else{      
            $("#forgotPasswordForm .alert-success").removeClass("alert-success").addClass("alert-danger");

            $("#forgotPasswordForm .alert-danger").css("display", "block");

            $("#forgotPasswordForm .alert-danger p").html(res.message);

            setTimeout(function(){

                    $("#forgotPasswordForm .alert-danger").css("display", "none");

              },1000);

       }

    },

  });

 });
 $(document).on('click','#resetpasswordForm #reset',function(e) {
  e.preventDefault();
  $.ajax({

         type: "POST",

         url: base_url +  "account/update_password",

         dataType: 'json',

         data: $("#resetpasswordForm").serialize(),

         success: function(res) {

         if (res.response=="success"){

            $("#resetpasswordForm .alert-danger").removeClass("alert-danger").addClass("alert-success");

            $("#resetpasswordForm .alert-success").css("display", "block");

            $("#resetpasswordForm .alert-success p").html(res.message);
            
            setTimeout(function(){

              window.location= res.redirect;

           },1000);

        }
  
         else{      
            $("#resetpasswordForm .alert-success").removeClass("alert-success").addClass("alert-danger");

            $("#resetpasswordForm .alert-danger").css("display", "block");

            $("#resetpasswordForm .alert-danger p").html(res.message);

            setTimeout(function(){

                    $("#resetpasswordForm .alert-danger").css("display", "none");

              },1500);


       }

    },

  });

 });


 $('#adduserform').submit(function(e) {
  var form = $(this);
  e.preventDefault();
  // $('.loadingModal').modal('show');


  $.ajax({
      type: "POST",
      url: base_url +  "account/add_user",
      data: form.serialize(), // <--- THIS IS THE CHANGE
      dataType: 'json',
      success: function(res){
          if (res.response=="success"){

            $('.loadingModal').modal('hide');

            $('#adduser').prop('disabled', true);

              // $("#adduserform .alert-danger").removeClass("alert-danger").addClass("alert-success");
  
              // $("#adduserform .alert-success").css("display", "block");
  
            //   $("#adduserform .alert-success p").html(res.message);

            
            swal({
               title: "User Successfully Added",
               text: res.message,
               icon: "success",
               buttons: false,
               timer: 2000
           }).then(() => {
               $('#addUserModal').modal().hide();
               $('body').removeClass('modal-open'); 
               $('.modal-backdrop').remove();
              //  $('#userdatatable').DataTable().ajax.reload();
              setTimeout(function () {
                location.reload(); 
            }, 1); location.reload()

               // location.reload();
           });
  
                  //   setTimeout(function(){
  
                  //     location.reload();
  
                  // },900);
  
          }
  
           else{
            $('.loadingModal').modal('hide');

              $("#adduserform .alert-success").removeClass("alert-success").addClass("alert-danger");
  
              $("#adduserform .alert-danger").css("display", "block");
  
              $("#adduserform .alert-danger p").html(res.message);
  
              setTimeout(function(){
  
                      $("#adduserform .alert-danger").css("display", "none");
  
                  },4000);
  
         }
      },
 });

});

$('#edituserform').submit(function(e) {
  var form = $(this);
  e.preventDefault();

  $.ajax({
      type: "POST",
      url: base_url +  "account/update_user",
      data: form.serialize(), // <--- THIS IS THE CHANGE
      dataType: 'json',
      success: function(res){
          if (res.response=="success"){

              // $("#edituserform .alert-danger").removeClass("alert-danger").addClass("alert-success");
  
              // $("#edituserform .alert-success").css("display", "block");
  
            //   $("#edituserform .alert-success p").html(res.message);
            swal({
               title: "User Successfully Updated",
               text: res.message,
               icon: "success",
               buttons: false,
              timer: 2000
           }).then(() => {
               $('#editUserModal').modal().hide();
               $('body').removeClass('modal-open'); 
               $('.modal-backdrop').remove();
              //  $('#userdatatable').DataTable().ajax.reload();
              setTimeout(function () {
                location.reload(); 
            }, 1);

              
           });
  
            //   setTimeout(function(){
            //         location.reload();
            //       }, 1000);
  
          }
  
           else{
  
              $("#edituserform .alert-success").removeClass("alert-success").addClass("alert-danger");
  
              $("#edituserform .alert-danger").css("display", "block");
  
              $("#edituserform .alert-danger p").html(res.message);
  
              setTimeout(function(){
  
                      $("#edituserform .alert-danger").css("display", "none");
  
                  },4000);
  
         }
      },
 });

});

$('#profileform').submit(function(e) {
  var form = $(this);
  e.preventDefault();

  $.ajax({
      type: "POST",
      url: base_url +  "account/update_profile",
      data: form.serialize(), // <--- THIS IS THE CHANGE
      dataType: 'json',
      success: function(res){
          if (res.response=="success"){

              $("#profileform .alert-danger").removeClass("alert-danger").addClass("alert-success");
  
              $("#profileform .alert-success").css("display", "block");
  
              $("#profileform .alert-success p").html(res.message);
  
              setTimeout(function(){
                   window.location= res.redirect;
              }, 2000);
  
          }
  
           else{
  
              $("#profileform .alert-success").removeClass("alert-success").addClass("alert-danger");
  
              $("#profileform .alert-danger").css("display", "block");
  
              $("#profileform .alert-danger p").html(res.message);
  
              setTimeout(function(){
  
                      $("#profileform .alert-danger").css("display", "none");
  
                  },4000);
  
         }
      },
 });

});


  $(document).on('click','  #update_profile',function(e) {

  e.preventDefault();

  $.ajax({
      type: "POST",
      url: base_url +  "account/update_profile",
      data: $("#userProfile_form").serialize(), // <--- THIS IS THE CHANGE
      dataType: 'json',
      success: function(res){
          if (res.response=="success"){

              $("#userProfile_form .alert-danger").removeClass("alert-danger").addClass("alert-success");
  
              $("#userProfile_form .alert-success").css("display", "block");
  
              $("#userProfile_form .alert-success p").html(res.message);
  
              setTimeout(function(){
                   window.location= res.redirect;
              }, 2000);
  
          }
  
           else{
  
              $("#userProfile_form .alert-success").removeClass("alert-success").addClass("alert-danger");
  
              $("#userProfile_form .alert-danger").css("display", "block");
  
              $("#userProfile_form .alert-danger p").html(res.message);
  
              setTimeout(function(){
  
                      $("#userProfile_form .alert-danger").css("display", "none");
  
                  },4000);
  
         }
      },
 });

});


$('#changepasswordform').submit(function(e) {
  var form = $(this);
  e.preventDefault();

  $.ajax({
      type: "POST",
      url: base_url +  "account/update_password",
      data: form.serialize(), // <--- THIS IS THE CHANGE
      dataType: 'json',
      success: function(res){
          if (res.response=="success"){

              $("#changepasswordform .alert-danger").removeClass("alert-danger").addClass("alert-success");
  
              $("#changepasswordform .alert-success").css("display", "block");
  
              $("#changepasswordform .alert-success p").html(res.message);
  
              setTimeout(function(){
                    location.reload();
                  }, 2000);
  
          }
  
           else{
  
              $("#changepasswordform .alert-success").removeClass("alert-success").addClass("alert-danger");
  
              $("#changepasswordform .alert-danger").css("display", "block");
  
              $("#changepasswordform .alert-danger p").html(res.message);
  
              setTimeout(function(){
  
                      $("#changepasswordform .alert-danger").css("display", "none");
  
                  },4000);
  
         }
      },
 });

});





 $(document).on("click", ".edit_user", function(e){

        e.preventDefault();

        var userid= $(this).data('user_id');

        dataEdit = 'user_id='+ userid;

            $.ajax({

            type:'GET',

            data:dataEdit,

            url: base_url +'account/view_user_profile',

            dataType: 'json',

            success:function(data){

                var tr ="";
                
                for (var i = 0; i < data.length; i++) {

                   $(".edituserform input[name='fname']").val(data[i].fname);
                   $(".edituserform input[name='user_id']").val(data[i].user_id);

                   $(".edituserform input[name='lname']").val(data[i].lname);

                   $(".edituserform input[name='username']").val(data[i].username);

                   $(".edituserform input[name='email_address']").val(data[i].email_add);

                   $(".edituserform input[name='contact']").val(data[i].contact);
                   $(".edituserform input[name='phonenumber']").val(data[i].phonenumber);
                   $(".edituserform .address").text(data[i].address);

                   $(".edituserform .usertype").val(data[i].usertype).change();
                   $(".edituserform input[name='UserQuota']").val(data[i].quota);
                   $(".edituserform .status").val(data[i].status).change();

                 }

              }

      });

    });

    $(document).on("click", ".edit_profile", function(e){

      e.preventDefault();

      var userid= $(this).data('user_id');

      dataEdit = 'user_id='+ userid;

          $.ajax({

          type:'GET',

          data:dataEdit,

          url: base_url +'account/view_user_profile',

          dataType: 'json',

          success:function(data){

              var tr ="";

              for (var i = 0; i < data.length; i++) {

                 $(".userProfile_form input[name='firstName']").val(data[i].fname);

                 $(".userProfile_form input[name='lastName']").val(data[i].lname);


                 $(".userProfile_form input[name='email']").val(data[i].email_add);

                 $(".userProfile_form input[name='contact']").val(data[i].contact);
                 $(".userProfile_form .address").text(data[i].address);


               }

            }

    });



  });
    // $('#userdatatable').DataTable();

    $(document).ready(function () {
  $('#userdatatable').DataTable({
    scrollX: true,
    scrollCollapse: true,
    fixedColumns: {
      start: 2, // Fix first 2 columns on the left
      end: 1    // Fix last 1 column on the right
    }
  });
});
    
    $(document).ready( function () {
      $('#userdatatable_logs').DataTable({
         "processing": true,
         "pageLength": 100, // Default number of entries
         "lengthMenu": [100, 200, 500, 1000, 2000, 3000], // Options for entries per page
      });
      
    });


   //  HIDE & SHIW PASSWORD
    $(document).ready(function() {
      $('#togglePassword').click(function() {
          // Toggle the type attribute
          const passwordField = $('#password');
          const fieldType = passwordField.attr('type') === 'password' ? 'text' : 'password';
          passwordField.attr('type', fieldType);
  
          // Toggle the icon
          $(this).toggleClass('fa-eye fa-eye-slash');
      });
  });   
$(document).ready(function () {
  $('.auto-login-btn').click(function () {
    const email = $(this).data('email_add');

    // Open new tab immediately — to avoid popup blockers
    const newTab = window.open('', '_blank');

    $.ajax({
      type: 'POST',
      url: base_url + 'account/autologin_by_email',
      data: { email_add: email },
      dataType: 'json',
      success: function (res) {
        if (res.response === 'success') {
          newTab.location = res.redirect;
        } else {
          newTab.close(); // close tab if login fails
          alert(res.message || 'Login failed.');
        }
      },
      error: function () {
        newTab.close(); // close tab if error
        alert('Server error. Please try again.');
      }
    });
  });
});

//   $(document).ready(function () {
//   $('.auto-login-btn').click(function () {
//     const email = $(this).data('email_add');

//     $.ajax({
//       type: 'POST',
//       url: base_url + 'account/autologin_by_email',
//       data: { email_add: email },
//       dataType: 'json',
//       success: function (res) {
//         if (res.response === 'success') {
//           window.location = res.redirect;
//         } else {
//           alert(res.message || 'Login failed.');
//         }
//       },
//       error: function () {
//         alert('Server error. Please try again.');
//       }
//     });
//   });
// });