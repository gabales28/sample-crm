$(document).ready(function() {

    function timeAgo(date) {
        const now = new Date();
        const seconds = Math.floor((now - date) / 1000);
        let interval = Math.floor(seconds / 31536000);

        if (interval > 1) return interval + " years ago";
        interval = Math.floor(seconds / 2592000);
        if (interval > 1) return interval + " months ago";
        interval = Math.floor(seconds / 86400);
        if (interval > 1) return interval + " days ago";
        interval = Math.floor(seconds / 3600);
        if (interval > 1) return interval + " hours ago";
        interval = Math.floor(seconds / 60);
        if (interval > 1) return interval + " minutes ago";
        return seconds + " seconds ago";
    }


    function fetchNotificationCount_default() {
        $.ajax({
            url: base_url + 'activity/count_unread_notifications',
            type: 'GET',
            dataType: 'json',
            success: function(data) {
                var count = data.count;
                var user_type = data.usertype;
                $('#notification-count').text(count || '');
                $.each(data.activities, function(index, notification) {
                    var lead_id= notification.lead_id;
                    var status_activity = notification.status_activity;
                    var link = "";

                    if (user_type == "Admin"  && status_activity == 0){
                        link = base_url + 'tasks/'+lead_id+'';
                    }
                    else if (user_type == "Lead Gen." && status_activity == 0){
                        link = base_url + 'tasks/sales_agents/'+lead_id+'';
 
                    }  
                    else if (user_type == "Admin" && status_activity == 5){
                        link = base_url + 'recycle/recycled_leads';
 
                    } 
                    else if (user_type == "Admin" && status_activity == 6){
                        link = base_url + 'recycle';
 
                    }   
                    else if ((user_type == "Sales Tier 1" || user_type == "Sales Tier 2" || user_type == "Sales Trainee" || user_type == "Sales Prospecting") && (status_activity == 0)){
                        link = base_url + 'agent/Lead_Agent/'+lead_id+'';
                    }
                    else{
                        link = "javascript::void();"
                    }
                    $('#notification-list').append(
                        '<a href="'+link+'" class="list-group-item list-group-item-action redirect_task_url" data-lead_id='+notification.lead_id+' data-status_activity='+notification.status_activity+' data-usertype='+user_type+'>'+
                            '<div class="d-flex">'+
                              '<div class="flex-shrink-0">'+
                                 '<img src="'+base_url+'/assets/images/user/avatar-2.jpg" alt="user-image" width="50" class="user-avatar"/>'+
                               '</div>'+
                            '<div class="flex-grow-1 ms-1">'+
                                '<span class="float-end text-muted">'+timeAgo(new Date(notification.date_added))+'</span>'+
                                '<h5>'+notification.user_charge+'</h5>'+
                               '<p class="text-body fs-6">'+notification.remarks+'</p>'+
                          '</div>'+
                        '</div>'+
                 '</a>');
                });

            },
            error: function() {
                console.error('Error fetching notification count');
            }
        });
        
    }
    fetchNotificationCount_default();

     function fetchNotificationCount_default_for_payment() {
        $.ajax({
            url: base_url + 'activity/count_unread_notifications_of_payment',
            type: 'GET',
            dataType: 'json',
            success: function(data) {
                var count = data.count;
                var user_type = data.usertype;
                $('#notification-count-payment').text(count || '');
                $.each(data.activities, function(index, notification) {
                    var lead_id= notification.lead_id;
                    var status_activity = notification.status_activity;
                    var link = "";

                    if (user_type == "Admin"  && status_activity == 0){
                        link = base_url + 'tasks/'+lead_id+'';
                    }
                    else if (user_type == "Lead Gen." && status_activity == 0){
                        link = base_url + 'tasks/sales_agents/'+lead_id+'';
 
                    }  
                    else if (user_type == "Admin" && status_activity == 5){
                        link = base_url + 'recycle/recycled_leads';
 
                    } 
                    else if (user_type == "Admin" && status_activity == 6){
                        link = base_url + 'recycle';
 
                    }   
                    else if ((user_type == "Sales Tier 1" || user_type == "Sales Tier 2" || user_type == "Sales Trainee" || user_type == "Sales Prospecting") && (status_activity == 0)){
                        link = base_url + 'agent/Lead_Agent/'+lead_id+'';
                    }
                    else{
                        link = "javascript::void();"
                    }
                    $('#notification-list_of_payment').append(
                        '<a href="'+link+'" class="list-group-item list-group-item-action redirect_task_url" data-lead_id='+notification.lead_id+' data-status_activity='+notification.status_activity+' data-usertype='+user_type+'>'+
                            '<div class="d-flex">'+
                              '<div class="flex-shrink-0">'+
                                 '<img src="'+base_url+'/assets/images/user/avatar-2.jpg" alt="user-image" width="50" class="user-avatar"/>'+
                               '</div>'+
                            '<div class="flex-grow-1 ms-1">'+
                                '<span class="float-end text-muted">'+timeAgo(new Date(notification.date_added))+'</span>'+
                                '<h5>'+notification.user_charge+'</h5>'+
                                '<p class="text-body fs-6">'+notification.remarks+' <h6> $'+(isNaN(notification.amount) ? 0 : parseFloat(notification.amount))+'</h6></p>'+                          '</div>'+
                        '</div>'+
                 '</a>');
                });

            },
            error: function() {
                console.error('Error fetching notification count');
            }
        });
        
    }
    fetchNotificationCount_default_for_payment();

    let previousCount = 0;
    function fetchNotificationCount() {

        $.ajax({
            url: base_url + 'activity/count_unread_notifications',
            type: 'GET',
            dataType: 'json',
            success: function(data) {
                const count = data.count || 0;
                const count_data = data.count;
                const user_type = data.usertype;
                $('#notification-count').text(count_data || '');
                if (count > previousCount) {
                    $('#notification-list').html("")
                    playNotificationSound();
                    $.each(data.activities, function(index, notification) {
                        var lead_id= notification.lead_id;
                        var status_activity = notification.status_activity;
                        var link = "";

                        if (user_type == "Admin" && status_activity == 0){
                            link = base_url + 'tasks/'+lead_id+'';
                        }
                        else if (user_type == "Lead Gen." && status_activity == 0){
                            link = base_url + 'tasks/sales_agents/'+lead_id+'';
                        }
                        else if (user_type == "Admin" && status_activity == 5){
                            link = base_url + 'recycle/recycled_leads';
     
                        } 
                        else if (user_type == "Admin" && status_activity == 6){
                            link = base_url + 'recycle';
     
                        }  
                        else if ((user_type == "Sales Tier 1" || user_type == "Sales Tier 2" || user_type == "Sales Trainee" || user_type == "Sales Prospecting") && (status_activity == 0)){
                            link = base_url + 'agent/Lead_Agent/'+lead_id+'';
                        }
                        else{
                            link = "javascript::void();";
                        }

                        $('#notification-list').append(
                            '<a href="'+link+'" class="list-group-item list-group-item-action redirect_task_url" data-lead_id='+notification.lead_id+' data-status_activity='+notification.status_activity+' data-usertype='+user_type+'>'+
                                '<div class="d-flex">'+
                                '<div class="flex-shrink-0">'+
                                    '<img src="'+base_url+'/assets/images/user/avatar-2.jpg" alt="user-image" width="50" class="user-avatar"/>'+
                                '</div>'+
                                '<div class="flex-grow-1 ms-1">'+
                                    '<span class="float-end text-muted">'+timeAgo(new Date(notification.date_added))+'</span>'+
                                    '<h5>'+notification.user_charge+'</h5>'+
                                '<p class="text-body fs-6">'+notification.remarks+'</p>'+
                            '</div>'+
                            '</div>'+
                            '</a>');                           
                        });
            
                 }
                    previousCount = count; // Update previous count
                    resetNotificationInterval();

                },
              error: function() {
                console.error('Error fetching notification count');
            }
        });
    }
    
    let notificationInterval = setInterval(fetchNotificationCount, 15000);
    
    // Function to reset the notification interval
    function resetNotificationInterval() {
        clearInterval(notificationInterval);
        notificationInterval = setInterval(fetchNotificationCount, 20000);
    }
});
// Function to play notification sound
function playNotificationSound() {
    const audio = new Audio( base_url + '/assets/audio/notification.mp3'); // Specify the path to your sound file
    audio.play().catch(error => {
        console.error('Error playing sound:', error);
    });
}

$(document).on('click', '.notification-count', function() {
    $.ajax({
        url: base_url + 'activity/mark_read',
        method: 'POST',
        success: function(response) {
            $('#notification-count').text('');
        },
        error: function() {
            console.error('Error fetching notification count');
        }
    });
});

