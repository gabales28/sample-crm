$(document).on("click", ".view_lead_activity", function(e){

    e.preventDefault();

    var lead_id= $(this).data('lead_id');

    dataEdit = 'lead_id='+ lead_id;

        $.ajax({

        type:'GET',

        data:dataEdit,

        url: base_url +'activity/activity_leads',

        dataType: 'json',

        success:function(data){

            var tr ="";
            var tr_notes ="";

            let n = 1;

            for (var i = 0; i < data.activities.length; i++) {

                tr += "<tr>"+
                "<td>"+n+++"</td>"+
                "<td>"+data.activities[i].title+"</td>"+
                "<td>"+data.activities[i].user_charge+"</td>"+
                "<td>"+data.activities[i].remarks+"</td>"+
                "<td>"+formatDate(data.activities[i].date_added)+"</td>"+
                "</tr>"
             }
             $(".lead_activity_detail").html(tr);
             $('#activitiesdatatable').DataTable();

             for (var i = 0; i < data.notes.length; i++) {

                tr_notes += "<tr>"+
                "<td>"+n+++"</td>"+
                "<td>"+data.notes[i].title+"</td>"+
                "<td>"+data.notes[i].user_charge+"</td>"+
                "<td>"+data.notes[i].remark_tasks+"</td>"+
                "<td>"+formatDate(data.notes[i].date_remark)+"</td>"+
                "</tr>"
             }
             $(".notes_detail").html(tr_notes);
             $('#notesdatatable').DataTable();
          }
     });

  });


  function formatDate(data) {
    if (!data) return '';
    const date = new Date(data);
    return moment(date).format('YYYY/MM/DD HH:mm:ss');
}