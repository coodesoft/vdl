

$(function(){

  //$.post(ajaxurl, data, function(data){});

  $('#smkSchedulerAdminArea').off().on('click', '#addEventSchedule', function(){
    let form = $(this).closest('#eventsForm');
    let data = {
      'events': form.serialize(),
      'action': 'skm_add_event'
    }

    $.post(ajaxurl, data, function(response){
      console.log(response);
    })
  })

});
