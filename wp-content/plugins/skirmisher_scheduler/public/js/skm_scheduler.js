

(function($){

  $('#skirmisherScheduler').off().on('click', 'li.schedule-selection', function(){
    $('li.schedule-selection').removeClass('schedule-active');
    $(this).addClass('schedule-active');

    $('#skirmisherScheduler').attr('data-day', $(this).attr('data-day'));

    let data = {
      'schedule_id' : $('#skirmisherScheduler').attr('data-day'),
      'radio_id' : $('#skirmisherScheduler').attr('data-radio'),
      'action' : 'skm_load_schedule',
    }

    $.ajax({
      data: data,
      url: ajaxurl,
      type: 'POST',
      success: function(response){
        $('#shedulerContainer').html(response);
      },
      error: function (response){
        console.log('Se produjo un error inesperado. Contáctese con el administrador');
      }
    })

  });

  $('#skirmisherScheduler').on('click', 'li.radio-item', function(){
    $('li.radio-item').removeClass('schedule-active');
    $(this).addClass('schedule-active');

    $('#skirmisherScheduler').attr('data-radio', $(this).attr('data-id'));

    let data = {
      'schedule_id' : $('#skirmisherScheduler').attr('data-day'),
      'radio_id' : $('#skirmisherScheduler').attr('data-radio'),
      'action' : 'skm_load_schedule',
    }

    $.ajax({
      data: data,
      url: ajaxurl,
      type: 'POST',
      success: function(response){
        $('#shedulerContainer').html(response);
      },
      error: function (response){
        console.log('Se produjo un error inesperado. Contáctese con el administrador');
      }
    })
  });

})(jQuery);
