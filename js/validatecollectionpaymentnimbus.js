

$('#collectionform').submit(function(e) {
    var form = $(this);
    e.preventDefault();

    $.ajax({
        type: "POST",
        url: base_url +  "sales/add_collection_payment",
        data: form.serialize(), // <--- THIS IS THE CHANGE
        dataType: 'json',
        success: function(res){
            if (res.response=="success"){

                $("#collectionform .alert-danger").removeClass("alert-danger").addClass("alert-success");
    
                $("#collectionform .alert-success").css("display", "block");
    
                $("#collectionform .alert-success p").html(res.message);
                $("#SalesModal").animate({ scrollTop: 0 }, "slow")
    
                setTimeout(function(){
                      location.reload();
                    }, 2000);
    
            }
    
             else{
    
                $("#collectionform .alert-success").removeClass("alert-success").addClass("alert-danger");
    
                $("#collectionform .alert-danger").css("display", "block");
    
                $("#collectionform .alert-danger p").html(res.message);
    
                setTimeout(function(){
    
                        $("#collectionform .alert-danger").css("display", "none");
    
                    },4000);
    
           }
        },
   });

});

// update request receipt

$('#updaterequest_receipt_form').submit(function(e) {
    var form = $(this);
    e.preventDefault();

    $.ajax({
        type: "POST",
        url: base_url +  "sales/update_request_receipt",
        data: form.serialize(), // <--- THIS IS THE CHANGE
        dataType: 'json',
        success: function(res){
            if (res.response=="success"){

                $("#updaterequest_receipt_form .alert-danger").removeClass("alert-danger").addClass("alert-success");
    
                $("#updaterequest_receipt_form .alert-success").css("display", "block");
    
                $("#updaterequest_receipt_form .alert-success p").html(res.message);
                $("#UpdateRequestModal").animate({ scrollTop: 0 }, "slow")
    
                setTimeout(function(){
                      location.reload();
                    }, 2000);
    
            }
    
             else{
    
                $("#updaterequest_receipt_form .alert-success").removeClass("alert-success").addClass("alert-danger");
    
                $("#updaterequest_receipt_form .alert-danger").css("display", "block");
    
                $("#updaterequest_receipt_form .alert-danger p").html(res.message);
    
                setTimeout(function(){
    
                        $("#updaterequest_receipt_form .alert-danger").css("display", "none");
    
                    },4000);
    
           }
        },
    });

});

// update request
$('#updatecollectionform').submit(function(e) {
    var form = $(this); 
    e.preventDefault();
    //  var table = $('#collectiondatatable').DataTable();
    // var $lmTable = $("#collectiondatatable").DataTable({bRetrieve: true});

    $.ajax({
        type: "POST",
        url: base_url +  "sales/update_collection_payment",
        data: form.serialize(), // <--- THIS IS THE CHANGE
        dataType: 'json',
        success: function(res){
            if (res.response=="success"){

                $("#updatecollectionform .alert-danger").removeClass("alert-danger").addClass("alert-success");
    
                $("#updatecollectionform .alert-success").css("display", "block");
    
                $("#updatecollectionform .alert-success p").html(res.message);
                $("#EditSalesModal").animate({ scrollTop: 0 }, "slow")

                setTimeout(function(){
    
                    location.reload();
                    }, 2000);
    
            }
    
             else{
    
                $("#updatecollectionform .alert-success").removeClass("alert-success").addClass("alert-danger");
    
                $("#updatecollectionform .alert-danger").css("display", "block");
    
                $("#updatecollectionform .alert-danger p").html(res.message);
    
                setTimeout(function(){
    
                        $("#collectionform .alert-danger").css("display", "none");
    
                    },4000);
    
           }
        },
   });

});


// update request
$('#editrequest_form').submit(function(e) {
    var form = $(this); 
    e.preventDefault();
    //  var table = $('#collectiondatatable').DataTable();
    // var $lmTable = $("#collectiondatatable").DataTable({bRetrieve: true});

    $.ajax({
        type: "POST",
        url: base_url +  "sales/update_receipt_payment",
        data: form.serialize(), // <--- THIS IS THE CHANGE
        dataType: 'json',
        success: function(res){
            if (res.response=="success"){

                $("#editrequest_form .alert-danger").removeClass("alert-danger").addClass("alert-success");
    
                $("#editrequest_form .alert-success").css("display", "block");
    
                $("#editrequest_form .alert-success p").html(res.message);
                $("#EditSales_SecondModal").animate({ scrollTop: 0 }, "slow")

                setTimeout(function(){
    
                    location.reload();
                    }, 2000);
    
            }
    
             else{
    
                $("#editrequest_form .alert-success").removeClass("alert-success").addClass("alert-danger");
    
                $("#editrequest_form .alert-danger").css("display", "block");
    
                $("#editrequest_form .alert-danger p").html(res.message);
    
                setTimeout(function(){
    
                        $("#editrequest_form .alert-danger").css("display", "none");
    
                    },4000);
    
           }
        },
   });

});



 // calculate Balance
 function get_balance(amount = 0, qty = 0, balance = 0){

    var amount = amount > 0 ? amount : 0 ;
    var balance = balance > 0 ? balance : 0 ;
    var qty = qty > 0 ?  qty : 0 ;
    var total_balance = (amount * qty) - balance;

    return total_balance;

}

   // calculate Grand Total
   function get_total_amount(price = 0, qty = 0){

   var price = price > 0 ? price : 0 ;
   var qty = qty > 0 ? qty : 0 ;
   var total_amount = price * qty;

    return total_amount;

}
  // calculate Percentage
  function get_percentage(perc, total_payment = 0){

    var total_payment = total_payment > 0 ? total_payment : 0 ;
    var perc = perc > 0 ? perc : 0 ;
    var tax = parseFloat(perc / 100) * parseFloat(total_payment) ;
    return  tax;

}

function get_limit_text(str = ""){

    var str = str.length > 7 ? text.substr(0, 10)+'.....' : str ;

    return str;

}


// var table = $('#collectiondatatable').DataTable({
    
//     "processing": false, //Feature control the processing indicator.
//     "serverSide": true, //Feature control DataTables' server-side processing mode.
//      "ajax": {

//          "url": base_url +  "sales/load_sales",
//          "type": "POST",
//           "data":"",
//        },
//     });



$(document).on('click','.view_sales_details',function(e) {
    e.preventDefault();
    var payment_id= $(this).data('payment_id');
    var qty =  0 ;
    var price =  0 ;
    var total = 0;
    var perc = 0;
    var subtotal = 0 ;
    var tax = 0;
    var balance = 0;
    var tr_service_details = "";
    var dateToday = moment().tz("America/New_York").format("DD/MM/YYYY ");

    dataEdit = 'payment_id='+ payment_id;
        $.ajax({
        type:'GET',
        data:dataEdit,
        url: base_url +'sales/view_payment/',
        dataType: 'json',
        success:function(data){
            var tr ="";
            
            var data = data.data_sales;
            for (var i = 0; i < data.length; i++) {
               $(".updatecollectionform [name='reference_number']").val(data[i].reference_number);
               $(".updatecollectionform [name='customer_contact']").val(data[i].customer_contact);
               $(".updatecollectionform [name='customer_email']").val(data[i].customer_email);
               $(".updatecollectionform [name='customer_name']").val(data[i].customer_name);
               $(".updatecollectionform .address").text(data[i].customer_address);
               $(".updatecollectionform [name='payment_id']").val(data[i].payment_id);
               qty = data[i].book_quantity > 0 ? data[i].book_quantity : 0 ;
               price = data[i].unit_price > 0 ? data[i].unit_price : 0 ;
               total = qty * price;
               balance = parseFloat(total) - parseFloat(data[i].total_payment);

               $(".updatecollectionform [name='amount']").val(total);
               $(".updatecollectionform [name='total_payment']").val(data[i].total_payment);
               $(".updatecollectionform [name='last_payment']").val(data[i].total_payment);


              $('.updatecollectionform #sub_total').text(data[i].total_payment);

               $('.updatecollectionform #balance').text(balance.toFixed(2));


              $(".updatecollectionform .status_payment").val(data[i].status_payment).change();
              $(".updatecollectionform .company_name").val(data[i].company_name).change();




                if(data[i].status_payment == "Full Payment"){
                    $(".updatecollectionform input[name='total_payment']").attr("readonly", true);
                }
                else{
                    $(".updatecollectionform input[name='total_payment']").attr("readonly", false);
        
                }
                tr_service_details += '<tr>'+
                '<td><textarea name="book_detail[]" required  class="form-control service_detail" rows="5">'+data[i].book_detail+'</textarea></td>'+                   
                 '<td><input type="number" class="form-control quantity"  name="quantity[]" value="'+data[i].book_quantity+'" required placeholder="Quantity"><input type="hidden" class="form-control service_id"  name="service_id[]" value="'+data[i].service_id+'" required placeholder="Quantity"></td>'+
                 '<td><input type="number" class="form-control unit_price"  name="unit_price[]" value="'+data[i].unit_price+'" required placeholder="Unit Price"></td>'+
                 '<td><input type="text" class="form-control service_amount" readonly name="amount[]" value="'+total+'"  required placeholder="Service Amount"></td>'+
                 '<td><button type="button" class="btn btn-danger remove" data-service_id="'+data[i].service_id+'" data-payment_id="'+data[i].payment_id+'"  name="remove">Remove</button></td>'+
                '</tr>';
                

                $('.updatecollectionform .datepicker').datepicker({
                    clearBtn: true, 
                    // startDate: dateToday,
                    format: "dd/mm/yyyy",
                    autoclose: true,
               }).datepicker("setDate", data[i].date_paid);
              // alert(get_date_commitment);

            }

            $('.updatecollectionform .list_item_books').html(tr_service_details);
            update_calc_item();


         }
         
    });
   
});

$(document).on('click','.view_request_details',function(e) {
    e.preventDefault();
    var payment_id= $(this).data('payment_id');
    var group_payment_id= $(this).data('group_payment_id');
    var qty =  0 ;
    var price =  0 ;
    var total = 0;
    var perc = 0;
    var subtotal = 0 ;
    var tax = 0;
    var balance = 0;
    var tr_service_details = "";

    var dateToday = moment().tz("America/New_York").format("DD/MM/YYYY");
    
    dataEdit = 'payment_id='+ payment_id+'&group_payment_id='+group_payment_id
        $.ajax({
        type:'GET',
        data:dataEdit,
        url: base_url +'sales/view_payment/',
        dataType: 'json',
        success:function(data){
            var tr ="";
            var get_total_last_payment = data.data_group_payment;
            var data = data.data_sales;
            for (var i = 0; i < data.length; i++) {
               $(".editrequest_form [name='reference_number']").val(data[i].reference_number);
               $(".editrequest_form [name='customer_contact']").val(data[i].customer_contact);
               $(".editrequest_form [name='customer_email']").val(data[i].customer_email);
               $(".editrequest_form [name='customer_name']").val(data[i].customer_name);
               $(".editrequest_form .address").text(data[i].customer_address);
               $(".editrequest_form [name='payment_id']").val(payment_id);
               $(".editrequest_form [name='last_payment_made']").val(data[i].total_payment);
               $(".editrequest_form [name='total_all_payment_made']").val(get_total_last_payment);

               qty = data[i].book_quantity > 0 ? data[i].book_quantity : 0 ;
               price = data[i].unit_price > 0 ? data[i].unit_price : 0 ;
               total = qty * price;

               $(".editrequest_form [name='amount']").val(total);
               $(".editrequest_form [name='total_payment']").val(data[i].total_payment);

               $(".editrequest_form .company_name option[value='"+data[i].company_name+"']").attr('disabled', false); 

              $('.editrequest_form #sub_total').text(data[i].total_payment);

               $('.editrequest_form #last_payment').text(parseFloat(data[i].last_payment_made).toFixed(2));

              $(".editrequest_form .status_payment").val(data[i].status_payment).change();
              $(".editrequest_form .company_name").val(data[i].company_name).change();



                if(data[i].status_payment == "Full Payment"){
                    $(".editrequest_form input[name='total_payment']").attr("readonly", true);
                }
                else{
                    $(".editrequest_form input[name='total_payment']").attr("readonly", false);
        
                }
                tr_service_details += '<tr>'+
                '<td><textarea name="book_detail[]" required readonly class="form-control service_detail" rows="5">'+data[i].book_detail+'</textarea></td>'+                   
                 '<td><input type="number" class="form-control quantity" readonly name="quantity[]" value="'+data[i].book_quantity+'" required placeholder="Quantity"></td>'+
                 '<td><input type="number" class="form-control unit_price" readonly name="unit_price[]" value="'+data[i].unit_price+'" required placeholder="Unit Price"></td>'+
                 '<td><input type="text" class="form-control service_amount" readonly name="amount[]" value="'+total+'"  required placeholder="Service Amount"></td>'+
              '</tr>';
        

                $('.editrequest_form .datepicker').datepicker({
                clearBtn: true, 
                format: "dd/mm/yyyy",
                autoclose: true,
                // startDate: dateToday
               }).datepicker("setDate", data[i].date_paid);
              // alert(get_date_commitment);

            }
            $('.editrequest_form .list_item_books').html(tr_service_details);
            edit_request_receipt();


         }
         
    });

});

//  view request recepit
$(document).on('click','.update_request_detail',function(e) {
    e.preventDefault();
    var payment_id= $(this).data('payment_id');
    var group_payment_id= $(this).data('group_payment_id');
    var qty =  0 ;
    var price =  0 ;
    var total = 0;
    var perc = 0;
    var subtotal = 0 ;
    var last_payment = 0;
    var tax = 0;
    var tr_service_details = "";
    var amount =  0; 
    var dateToday = moment().tz("America/New_York").format("DD/MM/YYYY ");
    dataEdit = 'payment_id='+ payment_id+'&group_payment_id='+group_payment_id
        $.ajax({
        type:'GET',
        data:dataEdit,
        url: base_url +'sales/view_transaction_detail/',
        dataType: 'json',
        success:function(data){

            var get_total_last_payment = data.data_group_payment;
            var data = data.data_sales;

    
            var tr ="";
            for (var i = 0; i < data.length; i++) {
               $(".updaterequest_receipt_form [name='customer_contact']").val(data[i].customer_contact);
               $(".updaterequest_receipt_form [name='customer_email']").val(data[i].customer_email);
               $(".updaterequest_receipt_form [name='customer_name']").val(data[i].customer_name);
               $(".updaterequest_receipt_form .book_detail").text(data[i].customer_address);
               $(".updaterequest_receipt_form .address").text(data[i].customer_address);
            //    $(".updaterequest_receipt_form .payment_remark").text(data[i].payment_remark);
               $(".updaterequest_receipt_form .book_detail").text(data[i].book_detail);
               $(".updaterequest_receipt_form [name='quantity']").val(data[i].book_quantity);
               $(".updaterequest_receipt_form [name='unit_price']").val(data[i].unit_price);
               $(".updaterequest_receipt_form [name='last_payment_made']").val(data[i].total_payment);
               $(".updaterequest_receipt_form [name='last_payment']").val(get_total_last_payment);
               $(".updaterequest_receipt_form [name='tax_fee']").val(data[i].tax_fee);
               $(".updaterequest_receipt_form [name='payment_id']").val(payment_id);
               $(".updaterequest_receipt_form [name='group_payment_id']").val(data[i].group_payment_id);
               qty = data[i].book_quantity > 0 ? data[i].book_quantity : 0 ;
               price = data[i].unit_price > 0 ? data[i].unit_price : 0 ;
               total = qty * price;

               last_payment = parseFloat(total)  - (parseFloat(data[i].last_payment_made) + parseFloat(data[i].total_payment));

               $('.updaterequest_receipt_form  #last_payment').text(parseFloat(data[i].total_payment).toFixed(2))

            //    $(".updaterequest_receipt_form [name='total_payment']").val(data[i].total_payment);

            //   $('.updaterequest_receipt_form #sub_total').text(data[i].total_payment);
              $(".updaterequest_receipt_form .status_payment").val(data[i].status_payment).change();
              $(".updaterequest_receipt_form .company_name").val(data[i].company_name).change();

              $(".updaterequest_receipt_form .company_name option[value='"+data[i].company_name+"']").attr('disabled', false); 



                if(data[i].status_payment == "Full Payment"){
                    $(".updaterequest_receipt_form input[name='total_payment']").attr("readonly", true);
                }
                else{
                    $(".updaterequest_receipt_form input[name='total_payment']").attr("readonly", false);
        
                }
                


           tr_service_details += '<tr>'+
               '<td><textarea name="book_detail[]" required readonly class="form-control service_detail" rows="5">'+data[i].book_detail+'</textarea></td>'+                   
                '<td><input type="number" class="form-control quantity" readonly name="quantity[]" value="'+data[i].book_quantity+'" required placeholder="Quantity"></td>'+
                '<td><input type="number" class="form-control unit_price" readonly name="unit_price[]" value="'+data[i].unit_price+'" required placeholder="Unit Price"></td>'+
                '<td><input type="text" class="form-control service_amount" readonly name="amount[]" value="'+total+'"  required placeholder="Service Amount"></td>'+
             '</tr>';


               $('.updaterequest_receipt_form .datepicker').datepicker({
                clearBtn: true, 
                format: "dd/mm/yyyy",
                // startDate: dateToday,
                autoclose: true,
              });
              // alert(get_date_commitment);

            }

             $('.updaterequest_receipt_form .list_item_books').html(tr_service_details);


             update_request_receipt();


         }
         
    });
});

//view request detail
$(document).on('click','.view_reciept_details',function(e) {
    e.preventDefault();
    var payment_id= $(this).data('payment_id');
    var group_payment_id= $(this).data('group_payment_id');
    var qty =  0 ;
    var price =  0 ;
    var amount = 0;
    var subtotal = 0 ;
    var tr_data_group_receipt = '';
    var tr_data_history_remark = '';
    var balance = 0;
    dataEdit = 'payment_id='+ payment_id+'&group_payment_id='+group_payment_id
        $.ajax({
        type:'GET',
        data:dataEdit,
        url: base_url +'sales/receipt_history/',
        dataType: 'json',
        success:function(data){
            var data_receipt = data.data_receipt;
            var data_group_receipt = data.data_group_receipt;
            var data_group_remark_history = data.data_group_remark_history;
            amount = data_receipt.service_amount;
            $('.HistoryModal .author_name').text(data_receipt.customer_name);
            $('.HistoryModal .phone_number').text(data_receipt.customer_contact);
            $('.HistoryModal .email_address').text(data_receipt.customer_email);
            $('.HistoryModal .address').text(data_receipt.customer_address);
            $('.HistoryModal .service_detail').html(nl2br(data_receipt.service_details.replace(/,(?=[^,]+$)/, ' & ')));
            $('.HistoryModal .book_quantity').text(data_receipt.group_quantity.replace(/,(?=[^,]+$)/, ' & '));
            $('.HistoryModal .unit_price').text(data_receipt.group_price.replace(/,(?=[^,]+$)/, ' & '));
            $('.HistoryModal .service_amount').text(data_receipt.service_amount);
            for (var i = 0; i < data_group_receipt.length; i++) {
                subtotal += parseFloat(data_group_receipt[i].total_payment);
             
               tr_data_group_receipt += '<tr>'+
                    '<td><a href="'+base_url+'sales/receipt/'+data_group_receipt[i].payment_id+'"  target="_blank">'+data_group_receipt[i].reference_number+'</a></td>'+
                    '<td>'+moment(data_group_receipt[i].date_paid).format('MM/DD/YYYY')+" "+data_group_receipt[i].time_added+ '</td>'+
                    '<td>'+data_group_receipt[i].status_payment+'</td>'+
                    '<td>'+data_group_receipt[i].total_payment+'</td>'+
                '</tr>';


            }
            balance = parseFloat(amount) - parseFloat(subtotal);
            $('.HistoryModal .list_service_total_details').html(tr_data_group_receipt);
            $('.HistoryModal #sub_total').text(subtotal.toFixed(2));
            $('.HistoryModal #balance').text(balance.toFixed(2));

            for (var i = 0; i < data_group_remark_history.length; i++) {

                tr_data_history_remark += '<tr>'+
                        '<td>'+data_group_remark_history[i].reference_number+'</td>'+
                        '<td>'+data_group_remark_history[i].collection_status+'</td>'+
                        '<td>'+data_group_remark_history[i].user_charge+'</td>'+
                        '<td>'+moment(data_group_remark_history[i].collect_date).format('MM/DD/YYYY')+'</td>'+
                    '</tr>';
        
            }
            $('.HistoryModal .list_receipt_status_details').html(tr_data_history_remark);




         }
         
    });

});

function nl2br (str, is_xhtml) {
    if (typeof str === 'undefined' || str === null) {
        return '';
    }
    var breakTag = (is_xhtml || typeof is_xhtml === 'undefined') ? '<br />' : '<br>';
    return (str + '').replace(/([^>\r\n]?)(\r\n|\n\r|\r|\n)/g, '$1' + breakTag + '$2');
}

var original_add_collection_form = $("#collectionform #total_summary").clone(true, true);
var original_update_collection_form = $("#updatecollectionform #total_summary").clone(true, true);


$('.add_collection').click(function(){
    $('#collectionform')[0].reset();
    //   $("#updatecollectionform #total_summary").replaceWith(original_update_collection_form.clone(true, true));
});

    // calculating discount amount from percentage
//  $('.collectionform  [name="status_payment"]').on('change', function(){
//         var sub_total = 0
//         $('.collectionform  [name="amount"]').each(function(){
//              sub_total += parseFloat($(this).val())
//         })
        
//         $('.collectionform  [name="total_payment"]').text(sub_total.toFixed(2))
//         $('.collectionform  #sub_total').text(sub_total.toFixed(2))
//         calc_total();
//  })

calc_item();

function calc_item(){
    // Calculating Item Total Price
    $('.collectionform [name="quantity[]"], .collectionform  [name="unit_price[]"]').on('keyup', function(){
        var qty = $(this).closest('.list_item_books tr').find('[name="quantity[]"]').val()
        var price = $(this).closest('.list_item_books tr').find('[name="unit_price[]"]').val()
        qty = qty > 0 ? qty : 0 ;
        price = price > 0 ? price : 0 ;
        var total = qty * price;
        $(this).closest('.list_item_books tr').find('[name="amount[]"]').val(total)

        // $(this).closest('.list_item_books tr').find('[name="total_payment"]').val(total)
        sub_total();
    })

    // Calculating Sub Total
    function sub_total(){
        var sub_total = 0
        $('.collectionform  [name="amount[]"]').each(function(){
            sub_total += parseFloat($(this).val())
        })

        $('.collectionform  [name="total_payment"]').val(sub_total);
        $('.collectionform  #sub_total').text(sub_total.toFixed(2))
        calc_total();

    }

    // calculating discount amount from percentage
    $('.collectionform  [name="total_payment"]').on('keyup', function(){
        
        var sub_total = 0;
        var amount =  0;
        $('.collectionform  [name="amount[]"]').each(function(){
            amount += parseFloat($(this).val())
        })
        sub_total = $(this).val() > 0 ? parseFloat($(this).val()) : 0;

        if(parseFloat($(this).val()) > parseFloat(amount)){
            $('.collectionform .error_total_made').css("display", "block").text('Opp..! Total payment can not be greater than the service amount');

        }
        else{
            $('.collectionform .error_total_made').css("display", "none").text('');
        }


        $('.collectionform  #sub_total').text(sub_total.toFixed(2));

        calc_total();
    })
    $('.collectionform  [name="status_payment"]').on('change', function(){
        var sub_total = 0

        if ($(this).val() ==  'Full Payment'){
           $(".collectionform input[name='total_payment']").attr("readonly", true);
        }
        else{
            $(".collectionform input[name='total_payment']").attr("readonly", false);

        }

           $('.collectionform  [name="amount[]"]').each(function(){
                    sub_total +=  parseFloat($(this).val())
          })
                $('.collectionform  [name="total_payment"]').val(sub_total);
                $('.collectionform  #sub_total').text(sub_total.toFixed(2))
                calc_total();
    });

    $('#collectionform [name="company_name"]').on('change', function () {
        $.ajax({
        type:'POST',
        url: base_url +'sales/load_reference' ,
        data:$("#collectionform").serialize(),
        dataType: 'json',
        success:function(data){
            $('.collectionform [name="reference_number"]').val(data);

        }
   });
 });



    $('.collectionform  [name="quantity[]"]').trigger('change')


    // calculate Grand Total
        function calc_total(){
            var sub_total =  $('.collectionform  #sub_total').text().replace("$", "");
            var amount =  0;
            $('.collectionform  [name="amount[]"]').each(function(){
                amount += parseFloat($(this).val())
            })

            var balance = parseFloat(amount) - parseFloat(sub_total);
            $('.collectionform  #balance').text(balance.toFixed(2))
        }
  }
  // update collection paymentt compute
  function update_calc_item(){
    // Calculating Item Total Price
    $('.updatecollectionform [name="quantity[]"], .updatecollectionform [name="unit_price[]"]').on('keyup', function(){
        var qty = $(this).closest('.list_item_books tr').find('[name="quantity[]"]').val()
        var price = $(this).closest('.list_item_books tr').find('[name="unit_price[]"]').val()
        qty = qty > 0 ? qty : 0 ;
        price = price > 0 ? price : 0 ;
        var total = qty * price;
        $(this).closest('.list_item_books tr').find('[name="amount[]"]').val(total)
        // $(this).closest('.list_item_books tr').find('[name="total_payment"]').val(total)
        sub_total();
    })

    // Calculating Sub Total
    function sub_total(){
        var sub_total = 0
        $('.updatecollectionform  [name="amount[]"]').each(function(){
            sub_total += parseFloat($(this).val())
        })

        $('.updatecollectionform  [name="total_payment"]').val(sub_total);
        $('.updatecollectionform  #sub_total').text(sub_total.toFixed(2))
        calc_total();
    }


    // calculating discount amount from percentage
    $('.updatecollectionform [name="total_payment"]').on('keyup', function(){
        
        var sub_total = 0;
        var amount =  0;
        $('.updatecollectionform  [name="amount[]"]').each(function(){
            amount += parseFloat($(this).val())
        })
        sub_total = $(this).val() > 0 ? parseFloat($(this).val()) : 0;

        if(parseFloat($(this).val()) > parseFloat(amount)){
            $('.updatecollectionform .error_total_made').css("display", "block").text('Opp..! Total payment can not be greater than the service amount');

        }
        else{
            $('.updatecollectionform .error_total_made').css("display", "none").text('');
        }


        $('.updatecollectionform  #sub_total').text(sub_total.toFixed(2));

        calc_total();
    })
    $('.updatecollectionform  [name="status_payment"]').on('change', function(){
        var sub_total = 0;
       var last_payment =  $(".updatecollectionform input[name='last_payment']").val();
       var total_payment = 0;   


        if ($(this).val() ==  'Full Payment'){
           $(".updatecollectionform input[name='total_payment']").attr("readonly", true);
           $('.updatecollectionform  [name="amount[]"]').each(function(){
            sub_total +=  parseFloat($(this).val())
          })

            $('.updatecollectionform  [name="total_payment"]').val(sub_total);
            $('.updatecollectionform  #sub_total').text(sub_total.toFixed(2))


      
        }
        else{
             $(".updatecollectionform input[name='total_payment']").attr("readonly", false);



        }
            calc_total();
    })

    $('.updatecollectionform [name="status_payment"]').trigger('change')

  
    // calculate Grand Total
    function calc_total(){
        var last_payment =  $(".updatecollectionform input[name='last_payment']").val();

            var sub_total =  $('.updatecollectionform  #sub_total').text().replace("$", "");
            var amount =  0;
            $('.updatecollectionform  [name="amount[]"]').each(function(){
                amount += parseFloat($(this).val())
            })

            var balance = parseFloat(amount) - parseFloat(sub_total);
            $('.updatecollectionform  #balance').text(balance.toFixed(2))
        }
  }


  // update  request receipt
   
  function update_request_receipt(){
    // Calculating Item Total Price
    $('.updaterequest_receipt_form [name="total_payment"]').on('keyup', function(){
        var sub_total = 0;
        var amount =  0;
        $('.updaterequest_receipt_form  [name="amount[]"]').each(function(){
            amount += parseFloat($(this).val())
        })
        var last_payment =  $('.updaterequest_receipt_form #last_payment').text().replace("$", "");
        var last_payment_made =  $('.updaterequest_receipt_form [name="last_payment"]').val();

        sub_total = $(this).val() > 0 ? parseFloat($(this).val()) : 0;
        var balance = (parseFloat(amount) - parseFloat(last_payment_made)) - parseFloat(sub_total);

        if(parseFloat($(this).val()) > balance){
            $('.updaterequest_receipt_form .error_total_made').css("display", "block").text('Opp..! Total payment can not be greater than the balance');

        }
        else{
            $('.updaterequest_receipt_form .error_total_made').css("display", "none").text('');
        }

        $('.updaterequest_receipt_form #sub_total').text(sub_total.toFixed(2));


        calc_total();
    })
    $('.updaterequest_receipt_form  [name="status_payment"]').on('change', function(){
        var sub_total = 0;
        var last_payment = $('.updaterequest_receipt_form #last_payment').text().replace("$", "");
        var amount = 0;
        var last_payment_made =  $('.updaterequest_receipt_form [name="last_payment"]').val();
        $('.updaterequest_receipt_form  [name="amount[]"]').each(function(){
            amount += parseFloat($(this).val())
        })

        if ($(this).val() ==  'Full Payment'){
           $(".updaterequest_receipt_form input[name='total_payment']").attr("readonly", true);
           sub_total = parseFloat(amount) - (parseFloat(last_payment_made));

           $('.updaterequest_receipt_form  [name="total_payment"]').val(sub_total);
           $('.updaterequest_receipt_form  #sub_total').text(sub_total.toFixed(2))

        }
        else{
            sub_total = 0;

            $(".updaterequest_receipt_form input[name='total_payment']").attr("readonly", false);
            $('.updaterequest_receipt_form  [name="total_payment"]').val('');
            $('.updaterequest_receipt_form  #sub_total').text(sub_total.toFixed(2))


        }
         calc_total();

    })

    $('.updaterequest_receipt_form [name="company_name"]').on('change', function () {
        $.ajax({
        type:'POST',
        url: base_url +'sales/load_reference' ,
        data:$("#updaterequest_receipt_form").serialize(),
        dataType: 'json',
        success:function(data){
            $('.updaterequest_receipt_form [name="reference_number"]').val(data);

        }
   });
 });

    $('.updaterequest_receipt_form  [name="status_payment"], .updaterequest_receipt_form  [name="company_name"]').trigger('change');

    // calculate Grand Total
        function calc_total(){
            var sub_total =  $('.updaterequest_receipt_form #sub_total').text().replace("$", "");
            // var disc =  $('#disc_amount').text()
            var last_payment =  $('.updaterequest_receipt_form #last_payment').text().replace("$", "");
            var last_payment_made =  $('.updaterequest_receipt_form [name="last_payment"]').val();

            var amount =  0;
            $('.updaterequest_receipt_form  [name="amount[]"]').each(function(){
                amount += parseFloat($(this).val())
            })

            var balance = (parseFloat(amount) -  parseFloat(last_payment_made)) - parseFloat(sub_total) ;
            $('.updaterequest_receipt_form #balance').text(balance.toFixed(2))
        }

  }


  // update  request receipt
   
  function edit_request_receipt(){
    // Calculating Item Total Price

    // calculating discount amount from percentage
    $('.editrequest_form [name="total_payment"]').on('keyup', function(){
        
        var sub_total = 0;
        var amount =  0;
        $('.editrequest_form [name="amount[]"]').each(function(){
            amount += parseFloat($(this).val())
        })
        var last_payment =  $('.editrequest_form [name="last_payment_made"]').val();
        var total_all_payment_made =  $('.editrequest_form [name="total_all_payment_made"]').val();

        sub_total = $(this).val() > 0 ? parseFloat($(this).val()) : parseFloat(last_payment);
        var balance = parseFloat(amount) - (parseFloat(total_all_payment_made) + parseFloat(sub_total));
       
        if(parseFloat($(this).val()) == balance){
            $('.editrequest_form .error_total_made').css("display", "block").text('Opp..! Total payment is same of the Previous Balance. Please change the status into Full Payment');

        }
       else if(parseFloat($(this).val()) > balance){
            $('.editrequest_form .error_total_made').css("display", "block").text('Opp..! Total payment can not be greater than the balance');

        }
        else{
            $('.editrequest_form .error_total_made').css("display", "none").text('');
        }

        $('.editrequest_form #sub_total').text(sub_total.toFixed(2));

        calc_total();
    })
    $('.editrequest_form  [name="status_payment"]').on('change', function(){
        var sub_total = 0;
        var amount = 0;
        var last_payment =  $('.editrequest_form #last_payment').text().replace("$", "");
        var total_all_payment_made =  $('.editrequest_form [name="total_all_payment_made"]').val();
        var get_last_total_payment =  $('.editrequest_form [name="last_payment_made"]').val();

        $('.editrequest_form  [name="amount[]"]').each(function(){
            amount += parseFloat($(this).val())
        })

        if ($(this).val() ==  'Full Payment'){

            $(".editrequest_form input[name='total_payment']").attr("readonly", true);

            sub_total = parseFloat(amount) -  parseFloat(last_payment);

           $('.editrequest_form  [name="total_payment"]').val(sub_total);
           $('.editrequest_form  #sub_total').text(sub_total.toFixed(2))

        }
        else{
            $(".editrequest_form input[name='total_payment']").attr("readonly", false);

        }
         calc_total();
    })

    $('.editrequest_form  [name="status_payment"]').trigger('change');
       // calculate Grand Total
       function calc_total(){
        var sub_total =  $('.editrequest_form #sub_total').text().replace("$", "");
        // var disc =  $('#disc_amount').text()
        var last_payment =  $('.editrequest_form #last_payment').text().replace("$", "");
        var total_all_payment_made =  $('.editrequest_form [name="total_all_payment_made"]').val();
        var get_last_total_payment =  $('.editrequest_form [name="last_payment_made"]').val();
        var get_status_payment = $('.editrequest_form [name="status_payment"]').val();
        var balance = 0;0


        var amount =  0;
        $('.editrequest_form  [name="amount[]"]').each(function(){
            amount += parseFloat($(this).val())
        })

        if(get_status_payment == 'Full Payment'){
             balance = (parseFloat(amount) -  parseFloat(sub_total)) - last_payment;

        }
        else{
             balance = (parseFloat(amount)  - parseFloat(total_all_payment_made)) + (parseFloat(get_last_total_payment) - parseFloat(sub_total)) ;

        }
        $('.editrequest_form #balance').text(balance.toFixed(2))
    }

  }

   
   
    $(document).on('click','#collectionform .add_more_services',function(e) {
        
        var n= ($('.list_item_books tr').length -0)+1;
        var quantity = '' ;
        var unit_price = '' ;
        var amount = '' ;
        var service_detail = '' ;
        var tr= '<tr>'+
                   '<td><textarea name="book_detail[]" required class="form-control service_detail" rows="5"></textarea></td>'+                   
                   '<td><input type="number" class="form-control quantity" name="quantity[]" required placeholder="Quantity"></td>'+
                   '<td><input type="number" class="form-control unit_price" name="unit_price[]" required placeholder="Unit Price"></td>'+
                   '<td><input type="text" class="form-control service_amount" name="amount[]" readonly required placeholder="Service Amount"></td>'+
                   '<td><button type="button" class="btn btn-danger remove" name="remove" id="remove">Remove</button></td>">'+
                '</tr>';


               $('#collectionform .list_item_books tr').each(function() {
                     quantity =   $(this).find('.quantity').val();
                     unit_price =   $(this).find('.unit_price').val();
                     amount =   $(this).find('.service_amount').val();
                     service_detail =   $(this).find('.service_detail').val();
                });
                if ((quantity != 0) && (unit_price !=0)  && (amount !=0) && (service_detail.length !=0) ) {
                    $('.list_item_books').append(tr);

                 }
                 calc_item();

   });

   $(document).on('click','#updatecollectionform .add_more_services',function(e) {
        
    var n= ($('.list_item_books tr').length -0)+1;
    var quantity = '' ;
    var unit_price = '' ;
    var amount = '' ;
    var service_detail = '' ;
    var tr= '<tr>'+
               '<td><textarea name="book_detail[]" required class="form-control service_detail" rows="5"></textarea></td>'+                   
               '<td><input type="number" class="form-control quantity"  name="quantity[]"  required placeholder="Quantity"><input type="hidden" class="form-control service_id"  name="service_id[]" value="0" required placeholder="Quantity"></td>'+
               '<td><input type="number" class="form-control unit_price" name="unit_price[]" required placeholder="Unit Price"></td>'+
               '<td><input type="text" class="form-control service_amount" name="amount[]" readonly required placeholder="Service Amount"></td>'+
               '<td><button type="button" class="btn btn-danger remove" data-service_id="0"  data-payment_id="0" name="remove">Remove</button></td>'+
            '</tr>';


           $('#updatecollectionform .list_item_books tr').each(function() {
                 quantity =   $(this).find('.quantity').val();
                 unit_price =   $(this).find('.unit_price').val();
                 amount =   $(this).find('.service_amount').val();
                 service_detail =   $(this).find('.service_detail').val();
            });
            if ((quantity != 0) && (unit_price !=0)  && (amount !=0) && (service_detail.length !=0) ) {
                $('.list_item_books').append(tr);

             }
             update_calc_item();

});


   $('body').delegate('#collectionform  .remove','click', function(){
        var count= $('#collectionform  table').find('.list_item_books').children().length;
        if (count!=1){
            $(this).closest('tr').remove();

            sub_tract();
 
        }

});
$('body').delegate('#updatecollectionform  .remove','click', function(){
    var count= $('#updatecollectionform  table').find('.list_item_books').children().length;

    var service_id= $(this).data('service_id');
    var payment_id= $(this).data('payment_id');
 
    dataEdit = 'service_id='+service_id+'&payment_id='+payment_id;
    $.ajax({
         type:'GET',
         data:dataEdit,
         url: base_url +'sales/delete_services' ,
         dataType: 'json',
         success: function(res) {
             if (res.response=="success"){
                 console.log("success");
             }
              else{
               console.log("error");
 
            }
         },
       });
    if (count!=1){
        $(this).closest('tr').remove();
        sub_tract();
    }

});

function sub_tract() {
    var sum = 0;
    var balance = 0;
    $('[name="amount[]"]').each(function(){
            if (!isNaN(this.value) && this.value.length != 0) {
                sum += parseFloat(this.value);

                }
       });
       $('[name="total_payment"]').val(sum);
       $('.sub_total').text(sum.toFixed(2));
       calc_balancetotal();
  }

  function calc_balancetotal(){
    var sum =  $('.sub_total').text().replace("$", "");
    var amount =   $('[name="total_payment"]').val();


    var balance = parseFloat(amount) - parseFloat(sum);
    $('.balance').text(balance.toFixed(2))
}
  



 $('#updaterequest_receipt_form [name="company_name"]').on('change', function () {
    $.ajax({
    type:'POST',
    url: base_url +'sales/load_reference' ,
    data:$("#updaterequest_receipt_form").serialize(),
    dataType: 'json',
    success:function(data){
        $('.updaterequest_receipt_form [name="reference_number"]').val(data);

    }
});


});

