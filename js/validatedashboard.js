function renderChart(data) {
    var options = {
        chart: {
          type: 'bar',
          height: 480,
          stacked: true,
          toolbar: {
            show: false
          }
        },
        plotOptions: {
          bar: {
            horizontal: false,
            columnWidth: '50%'
          }
        },
        dataLabels: {
          enabled: false
        },
        colors: ['#017979'],
        series: [
          {
            name: 'Sales',
            data: data
          },
    
        ],
        responsive: [
          {
            breakpoint: 480,
            options: {
              legend: {
                position: 'bottom',
                offsetX: -10,
                offsetY: 0
              }
            }
          }
        ],
        xaxis: {
          type: 'category',
          categories: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec']
        },
        grid: {
          strokeDashArray: 4
        },
        tooltip: {
          theme: 'dark'
        }
      };
      var chart = new ApexCharts(document.querySelector('.growthchart'), options);
      chart.render();
      chart.update();
    }


$('#agent_user').on('change', function() {
  const agent_user_id = $(this).val();
  const user_data = { user_id: agent_user_id};

  if (agent_user_id == 0){
       location.reload();

  }
  else{
        $.ajax({

            url: base_url + 'dashboard/view_dashboard_details',

            method: 'POST',

            dataType: 'json',
            
            data: user_data,

            success: function(data) {
                renderChart(data.payments);
                const total_leads = data.total_leads ? data.total_leads : 0; 
                const total_sales = data.total_sales['total_sales'] ? data.total_sales['total_sales'] : 0; 
                const total_deals_month = data.total_deals_month ? data.total_deals_month : 0; 
                const total_deals_year = data.total_deals_year ? data.total_deals_year : 0; 
                const sales_qouta = data.sales_qouta['quota'] ? data.sales_qouta['quota'] : 0; 
                $('.total_leads').text(total_leads);
                $('.total_sales').text(formatNumber(total_sales));
                $('.total_deals_month').text(total_deals_month);
                $('.total_deals_year').text(total_deals_year);
                $('.sales_qouta').text('$'+formatNumber(sales_qouta) + '/$'+ formatNumber(total_sales));
            },
            error: function() {
                console.error('Error fetching total dashboard');
            }
      });
  }
});

function formatNumber(num) {
  // Convert the number to a float
      num = parseFloat(num);
      
      // Check if the number is valid
      if (isNaN(num)) {
          return "Invalid number";
      }

      // Format the number to two decimal places
      num = num.toFixed(2);

      // Split the number into integer and decimal parts
      let parts = num.split(".");
      let integerPart = parts[0];
      let decimalPart = parts[1];

      // Use a regular expression to add commas
      integerPart = integerPart.replace(/\B(?=(\d{3})+(?!\d))/g, ",");

      // Combine the integer and decimal parts
      return integerPart + "." + decimalPart;
    }