function convertToEasternTime(utcTime) {
    const date = new Date(utcTime);
    const options = {
        timeZone: 'America/New_York',
        hour12: true,
        year: 'numeric',
        month: '2-digit',
        day: '2-digit',
        hour: 'numeric',
        minute: 'numeric'
    };
    return date.toLocaleString('en-US', options).replace(',', ''); // Remove comma for formatting
}

function formatDuration(durationInSeconds) {
    const hours = Math.floor(durationInSeconds / 3600);
    const minutes = Math.floor((durationInSeconds % 3600) / 60);
    const seconds = durationInSeconds % 60;

    return `${String(hours).padStart(2, '0')}:${String(minutes).padStart(2, '0')}:${String(seconds).padStart(2, '0')}`;
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
    var user_phonenumber = 0;

    $('#reportpaymentrange').on('apply.daterangepicker', function(ev, picker) {
        $('.agent_extension').prop('selectedIndex', 0);
    
        var start = picker.startDate.format('YYYY-MM-DD');
        var end = picker.endDate.format('YYYY-MM-DD');
    
        if ($.fn.DataTable.isDataTable('#callLogs_dataTable')) {
            $('#callLogs_dataTable').DataTable().clear().destroy();
        }
        // Initialize DataTable only once
        initializeDataTable(start, end);
    
        $('.agent_extension').on('change', function() {
            const agent_user = $(this).val();
            user_phonenumber = agent_user;
    
            // Update DataTable with new parameters
            updateDataTable(start, end,user_phonenumber);
        });
    });
    
    function initializeDataTable(start, end) {
        $('#callLogs_dataTable').DataTable({
            "processing": true,
            "pageLength": 20, // Default page length
            "lengthMenu": [20, 50, 100, 500, 1000], // Options for page length
            "order": [[4, "desc"]],

            "ajax": {
                url: base_url + 'ringcentral/call_logs/fetch_call_logs_data',
                type: 'POST',
                data: function(d) {
                    d.from_date = start;
                    d.to_date = end;
                    d.phonenumber = user_phonenumber;
                },
            },
            
            
            columns: [
                { data: 'from_number' },
                { data: 'to_number' },
                { data: 'action' },
                { data: 'result' },
                { data: "startime", render: function(data, type, row){
                    return convertToEasternTime(data);
                  }
                },
                { data: "duration", render: function(data, type, row){
                    return formatDuration(data);
                  }
                },
                { data: "recording", render: function(data, type, row){
                    if (data) {
                        
                        return '<a href="'+site_url+'/ringcentral/call_logs/fetch_audio/'+data+'"  target="_blank">Audio</a>';
                    }
                    
                    return 'No Recording';
                  }
                },


            ],
            "initComplete": function(settings, json) {
                const api = this.api();
                const rowCount = api.rows().count();
                $('.total_call_logs').text(rowCount);
            }
        });
    }
    
    function updateDataTable(startDate, endDate, user_phonenumber) {
        const dataTable = $('#callLogs_dataTable').DataTable();
        dataTable.ajax.reload(function() {
            const rowCount = dataTable.rows().count();
            $('.total_call_logs').text(rowCount);
        }, false);
    }

// Call Logs Agent

$(function () {
    var start = moment().tz('America/New_York').subtract(29, 'days');
     var end = moment().tz('America/New_York');
        function cb(start, end) {
            $('#reportpaymentrange_agent span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'));
        }

        $('#reportpaymentrange_agent').daterangepicker({
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

    

    $('#reportpaymentrange_agent').on('apply.daterangepicker', function(ev, picker) {

    
        var start = picker.startDate.format('YYYY-MM-DD');
        var end = picker.endDate.format('YYYY-MM-DD');
    
        if ($.fn.DataTable.isDataTable('#callLogsAgent_dataTable')) {
            $('#callLogsAgent_dataTable').DataTable().clear().destroy();
        }
        // Initialize DataTable only once
        initializeAgentDataTable(start, end);
    });
    
    function initializeAgentDataTable(start, end) {
        $('#callLogsAgent_dataTable').DataTable({
            "processing": true,
            "pageLength": 20, // Default page length
            "lengthMenu": [20, 50, 100, 500, 1000], // Options for page length
            "order": [[4, "desc"]],

            "ajax": {
                url: base_url + 'ringcentral/call_logs_agent/fetch_call_logs_data',
                type: 'POST',
                data: function(d) {
                    d.from_date = start;
                    d.to_date = end;
                },
            },
            
            
            columns: [
                { data: 'from_number' },
                { data: 'to_number' },
                { data: 'action' },
                { data: 'result' },
                { data: "startime", render: function(data, type, row){
                    return convertToEasternTime(data);
                  }
                },
                { data: "duration", render: function(data, type, row){
                    return formatDuration(data);
                  }
                },
                { data: "recording", render: function(data, type, row){
                    if (data) {
                        
                        return '<a href="'+site_url+'/ringcentral/call_logs/fetch_audio/'+data+'"  target="_blank">Audio</a>';
                    }
                    
                    return 'No Recording';
                  }
                },


            ],
            "initComplete": function(settings, json) {
                const api = this.api();
                const rowCount = api.rows().count();
                $('.total_call_logs').text(rowCount);
            }
        });
    }
    

