var  sales_datatable = $('#sales_reportdatatable').DataTable({
  "lengthMenu": [[100, 150, 200, 500, 1000, -1], [100, 150, 200, 500, 1000, "All"]],
  "order": [[ 0, "desc" ]], 
  autoWidth: true, 
  fixedColumns: {
  left: 1,
},
  responsive: true,
  dom: 'Blfrtip',
        buttons: [
              {
                  extend: 'excelHtml5',
                  footer: true,
                   title: 'Receipt',
                   filename: 'Receipt',
                   exportOptions: {
                    columns: [ 0, 1, 5, 6, 7, 8, 9,10]
                },
                customize: function( xlsx ) {
                  $(xlsx.xl["styles.xml"]).find('numFmt[numFmtId="164"]').attr('formatCode', '[$$-45C] #,##0.00_-');
                }
              },
              {
                  extend: 'pdfHtml5',
                  footer: true,
                   title: 'Receipt',
                   filename: 'Receipt',
                  exportOptions: {
                      columns: [ 0, 1, 5, 6, 7, 8, 9, 10]
                  },
              },
          ],

   "initComplete": function (settings, json) {
    var api = this.api();
    CalculateSalesReport_TableSummary(this);
   },
   "drawCallback": function ( row, data, start, end, display ) {
       var api = this.api(), data;  
       CalculateSalesReport_TableSummary(this);
       return ;   
     }
   } );

   function CalculateSalesReport_TableSummary(sales_datatable) {
    try {

        var intVal = function (i) {
            return typeof i === 'string' ?
                    i.replace(/[\$,]/g, '') * 1 :
                    typeof i === 'number' ?
                        i : 0;
        };

        var api = sales_datatable.api();


         api.columns(".total_payments").each(function (index) {
         var column = api.column(index,{page:'current'});

           var sum = column 
                .data()
                .reduce( function (a, b) {
                    return intVal(a) + intVal(b);
                }, 0 );

        $('.total_sales_payment').text(sum.toLocaleString("en"));
        $('.total_all_payment_made').text(sum);
      });

    //     api.columns(".total_balances").each(function (index) {
    //         var column = api.column(index,{page:'current'});
   
    //           var sum = column 
    //                .data()
    //                .reduce( function (a, b) {
    //                    return intVal(a) + intVal(b);
    //                }, 0 );
   
    //        $('.total_balances_payment').text('$'+sum.toLocaleString("en"));
     
    // });
  }
  catch (e) {
        console.log('Error in CalculateReceipt_TableSummary');
        console.log(e)
    }
}



$(function () {
    var start = moment().tz('America/New_York').subtract(29, 'days');
     var end = moment().tz('America/New_York');
        function cb(start, end) {
            $('#reportpaymentrange span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'));
        }

        $('#reportpaymentrange').daterangepicker({
            startDate: start,
            endDate: end,
            ranges: {
            'Today': [moment().tz('America/New_York'), moment()],
            'Yesterday': [moment().subtract(1, 'days').tz('America/New_York'), moment().subtract(1, 'days').tz('America/New_York')],
            'Last 7 Days': [moment().subtract(6, 'days').tz('America/New_York'), moment().tz('America/New_York')],
            'Last 30 Days': [moment().subtract(29, 'days').tz('America/New_York'), moment().tz('America/New_York')],
            'This Month': [moment().startOf('month'), moment().endOf('month')],
            'Last Month': [moment().subtract(1, 'month').startOf('month').tz('America/New_York'), moment().subtract(1, 'month').endOf('month').tz('America/New_York')]
            }
        }, cb);

        cb(start, end);
    });

    $('#reportpaymentrange').on('apply.daterangepicker', function(ev, picker) {
      $('#sales_form .payment_status').prop('selectedIndex',0);

      var start = picker.startDate.format('YYYY-MM-DD');
      var end = picker.endDate.format('YYYY-MM-DD');
   

        $('#sales_form [name="from_date"]').val(start);
        $('#sales_form [name="to_date"]').val(end);

     
      
       $.fn.dataTable.ext.search.push(
         function(settings, data, dataIndex) {
           var min = new Date(start);
           var max = new Date(end);
           var startDate = new Date(data[13]);
           
           if (min == null && max == null) {
             return true;
           }
           if (min == null && startDate <= max) {
             return true;
           }
           if (max == null && startDate >= min) {
             return true;
           }
           if (startDate <= max && startDate >= min) {
             return true;
           }
           return false;
         }
       );
       sales_datatable.draw();
         $.fn.dataTable.ext.search.pop();
     
       });

   $('.payment_status').change(function(){
        sales_datatable.columns(11).search($(this).val()).draw() ;
    
        $.fn.dataTable.ext.search.push(
            function(settings, data, dataIndex) {
              var min = new Date($('#sales_form [name="from_date"]').val());
              var max = new Date($('#sales_form [name="to_date"]').val());
              var startDate = new Date(data[13]);
              var payment_status = data[11];
                  
              
              if (min == null && max == null &&  $(this).val() == payment_status) {
                return true;
              }
              if (min == null && startDate <= max && $(this).val() == payment_status) {
                return true;
              }
              if (max == null && startDate >= min && $(this).val() == payment_status) {
                return true;
              }
              if (startDate <= max && startDate >= min) {
                return true;
              }
              return false;
            }
          );
          sales_datatable.draw();
          $.fn.dataTable.ext.search.pop();
    });