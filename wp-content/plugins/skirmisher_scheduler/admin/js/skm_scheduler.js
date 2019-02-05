
let scheduleRow = function(schedule){
  let row = '<tr data-id="'+schedule['id']+'">';
  row += '<td>'+schedule['title']+'</td>'
  row += '<td>'+schedule['sunday']+'</td>'
  row += '<td>'+schedule['monday']+'</td>'
  row += '<td>'+schedule['tuesday']+'</td>'
  row += '<td>'+schedule['wednesday']+'</td>'
  row += '<td>'+schedule['thursday']+'</td>'
  row += '<td>'+schedule['friday']+'</td>'
  row += '<td>'+schedule['saturday']+'</td>'
  row += '<td>'+schedule['timetable']+'</td>'
  row += '<td><i class="fas fa-trash-alt skirmisher-delete"></i></td>';
  row += '</tr>';
  return row;
}


$(function(){

  //$.post(ajaxurl, data, function(data){});

  $('#skmSchedulerAdminArea').off().on('click', '#addEventSchedule', function(){
    let form = $(this).closest('#eventsForm');
    let data = {
      'events': form.serialize(),
      'action': 'skm_add_event'
    }

    $.post(ajaxurl, data, function(response){
      response = JSON.parse(response);
      if (response['result']){
        let row = scheduleRow(response['schedule']);
        $('#smkSchedulerAdminArea table tbody').append(row);
      } else{
        $('#smkSchedulerAdminArea .response').html(response['msj']);
        $('#smkSchedulerAdminArea .response').addClass('alert-danger');
        $('#smkSchedulerAdminArea .response').removeClass('d-none');
        setTimeout(function(){
          $('#smkSchedulerAdminArea .response').removeClass('alert-danger');
          $('#smkSchedulerAdminArea .response').addClass('d-none');
        }, 1000);
      }
    });
  })

  $('#skmSchedulerAdminArea').on('click', '.skirmisher-delete', function(){
    let self = $(this)
    let data = {
      'to_delete' : self.closest('tr').attr('data-id'),
      'action' : 'skm_delete_event'
    }

    $.post(ajaxurl, data, function(response){
      response = JSON.parse(response);
      if (response){
        self.closest('tr').remove();
      } else{
        $('#smkSchedulerAdminArea .response').html(response['msj']);
        $('#smkSchedulerAdminArea .response').addClass('alert-danger');
        $('#smkSchedulerAdminArea .response').removeClass('d-none');
        setTimeout(function(){
          $('#smkSchedulerAdminArea .response').removeClass('alert-danger');
          $('#smkSchedulerAdminArea .response').addClass('d-none');
        }, 1000);
      }

    });
  });

});
