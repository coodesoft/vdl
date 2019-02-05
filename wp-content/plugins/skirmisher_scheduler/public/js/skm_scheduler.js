

$(function(){

  $('#skirmisherScheduler').off().on('click', 'li.schedule-selection', function(){
    $('li.schedule-active').removeClass('schedule-active');
    $(this).addClass('schedule-active');

    let data = {
      'schedule_id' : $(this).attr('data-day'),
      'action' : 'skm_load_schedule',
    }

    $.ajax({
      data: data,
      url: ajaxurl,
      type: 'POST',
      success: function(response){
        $('#shedulerContainer').html(response);
      },
      error: function (resonse){
        console.log('Se produjo un error inesperado. Contáctese con el administrador');
      }
    })

  });

})
