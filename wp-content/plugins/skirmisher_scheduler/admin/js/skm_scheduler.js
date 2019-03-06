

(function($){


  let scheduleRow = function(data){
    let schedule = data['schedule'];
    let radios = data['radios'];
    let row = '<tr class="schedule-'+schedule['schedule_id']+'" data-id="'+schedule['schedule_id']+'">';
      row += scheduleRowContent(schedule, radios);
      row += '</tr>';
    return row;
  }

  let scheduleRowContent = function(schedule, radios){
    let row;
    row += '<td>'+schedule['post_title']+'</td>';
    row += '<td class="d-none">';
    row +=    '<input type="text" disabled name="ScheduleItem[eventPost]" value="'+schedule['post_id']+'" placeholder="'+schedule['post_title']+'"/>';
    row +=    '<input type="hidden" disabled name="ScheduleItem[scheduleId]" value="'+schedule['schedule_id']+'"/>';
    row += '</td>';
    row += '<td><input type="checkbox" disabled value="sunday" name="ScheduleItem[day][]" '+schedule['sunday']+'/></td>';
    row += '<td><input type="checkbox" disabled value="monday" name="ScheduleItem[day][]" '+schedule['monday']+'/></td>';
    row += '<td><input type="checkbox" disabled value="tuesday" name="ScheduleItem[day][]" '+schedule['tuesday']+'/></td>';
    row += '<td><input type="checkbox" disabled value="wednesday" name="ScheduleItem[day][]" '+schedule['wednesday']+'/></td>';
    row += '<td><input type="checkbox" disabled value="thursday" name="ScheduleItem[day][]" '+schedule['thursday']+'/></td>';
    row += '<td><input type="checkbox" disabled value="friday" name="ScheduleItem[day][]" '+schedule['friday']+'/></td>';
    row += '<td><input type="checkbox" disabled value="saturday" name="ScheduleItem[day][]" '+schedule['saturday']+'/></td>';
    row += '<td class="data-text">'+schedule['begin_time']+' - '+schedule['end_time']+'</td>';
    row += '<td class="data-select d-none">';
    row +=    '<input type="time" name="ScheduleItem[horaInicio]" value="'+schedule['begin_time']+'" disabled/>';
    row +=    '<input type="time" name="ScheduleItem[horaFin]" value="'+schedule['end_time']+'" disabled/>';
    row += '</td>';
    row += '<td class="data-text">'+schedule['radio']+'</td>';
    row += '<td class="data-select d-none">';
    row += '<select name="ScheduleItem[radioSelect]" id="radioSelect" required> <option value="0" id="emptyOption" disabled></option>';
    let radio, selected;
    for (var i = 0; i < radios.length; i++) {
      radio = radios[i];
      selected = radio['id'] == schedule['radio_id'] ? 'selected' : '';
      row += '<option value="'+radio['id']+'" class="radio-'+radio['id']+'" '+selected+'>'+radio['radio']+'</option>';
    }
    row += '</select>';
    row += '</td>';
    row += '<td class="skm-table-actions">';
    row += '<div class="skm-edit d-inline"><i class="fas fa-edit fa-lg"></i></div>';
    row += '<div class="skm-delete d-inline"><i class="fas fa-trash-alt fa-lg"></i></div>';
    row += '<div class="skm-confirm-edit d-none"><i class="fas fa-check-circle fa-lg"></i></div>';
    row += '<div class="skm-cancel-edit d-none"><i class="fas fa-times-circle fa-lg"></i></div>';
    row += '</td>';

    return row;
  }

  let radioRow = function (radio){
    let row = '<tr data-radio="'+radio['id']+'">';
    row += '<td class="radio-'+radio['id']+'">'+radio['radio']+'</td>';
    row += '<td><i class="edit-radio fas fa-edit"></i>';
    row += '<i class="delete-radio fas fa-trash-alt"></i></td>';
    return row;
  }

  let showMessage = function(container, message, type){
    if (type == undefined)
      type = 'danger';

    $(container+' .response').html(message);
    $(container+' .response').addClass('alert-'+type);
    $(container+' .response').removeClass('d-none');
    setTimeout(function(){
      $(container+' .response').removeClass('alert-'+type);
      $(container+' .response').addClass('d-none');
    }, 1000);
  }



  let processResult = function(result, data, errorMsg, container, callback){
    if (result){
      let row = callback(data);

      if ($('#emptyTable').length)
        $(container+' table tbody').html(row);
      else
        $(container+' table tbody').append(row);
    } else{
      showMessage(container, errorMsg);
    }
  }

  let cleanScheduleForm = function(){
   //  $('#radioSelect').val("");
    $('#radioSelect').prop("selectedIndex",0);

    //  $('#eventsSelect').val("");
    $('#eventsSelect').prop("selectedIndex",0);

    $('#eventsSelect').attr('disabled', false);

    $('#selectDays input').attr('checked', false);
    $('#horaInicio').val('13:00');
    $('#horaFin').val('14:00');
  }


  //$.post(ajaxurl, data, function(data){});

  /*
   * FUNCIONES DE LA TAB DE LA PROGRAMACIÓN------------------------------------
   */

  $('#skmSchedulerAdminArea').off().on('click', '#addEventSchedule', function(){
    let form = $(this).closest('#eventsForm');
    let data = {
      'events': form.serialize(),
      'action': 'skm_add_event'
    }

    $.post(ajaxurl, data, function(response){
      response = JSON.parse(response);

      //reseteo el select y los checkbox
      $('#eventsForm input[type=checkbox]').prop('checked',false);
      $('#emptyOption').prop('selected', true);
      $('#selectDays input').prop('checked', false);

      processResult(response['result'], response, response['msg'], '#skmSchedulerAdminArea', scheduleRow);
    });
  });

  $('#skmSchedulerAdminArea').on('click', '.skm-delete', function(){
    let proceed = confirm('Vas a eliminar un evento. ¿Deseas continuar?');

    if (proceed){
          let self = $(this);
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
    }

  });

  $('#skmSchedulerAdminArea').on('click', '.skm-edit', function(){
      $('.skm-cancel-edit').click();

      $(this).addClass('d-none').removeClass('d-inline');
      $(this).siblings('.skm-delete').addClass('d-none').removeClass('d-inline');

      $(this).siblings('.skm-cancel-edit').removeClass('d-none').addClass('d-inline');
      $(this).siblings('.skm-confirm-edit').removeClass('d-none').addClass('d-inline');

      let $row = $(this).closest('tr');

      $row.find('input').attr('disabled', false);
      $row.find('select').attr('disabled', false);
      $row.find('td.data-text').addClass('d-none');
      $row.find('td.data-select').removeClass('d-none');

  });

  $('#skmSchedulerAdminArea').on('click', '.skm-cancel-edit', function(){
    $(this).addClass('d-none').removeClass('d-inline');
    $(this).siblings('.skm-delete').addClass('d-inline').removeClass('d-none');

    $(this).siblings('.skm-edit').removeClass('d-none').addClass('d-inline');
    $(this).siblings('.skm-confirm-edit').removeClass('d-inline').addClass('d-none');

    let $row = $(this).closest('tr');

    $row.find('input').attr('disabled', true);
    $row.find('select').attr('disabled', true);
    $row.find('td.data-select').addClass('d-none');
    $row.find('td.data-text').removeClass('d-none');

  });

  $('#skmSchedulerAdminArea').on('click', '.skm-confirm-edit', function(){
    let data = {
      data: $(this).closest('form').serialize(),
      action: 'skm_edit_event',
    }

    $.post(ajaxurl, data, function(response){
      response = JSON.parse(response);
      $('.skm-cancel-edit').click();

      if (response['status']){
        showMessage('#skmSchedulerAdminArea', response['msg'], 'success');

        $row = $('tr.schedule-'+response['entity_uid']);
        $row.addClass('skm-table-row-success');
        $row.empty();
        $row.html( scheduleRowContent(response['data']['schedule'], response['data']['radios']) );

        //console.log(response['entity']);
        setTimeout(function(){
          $row.removeClass('skm-table-row-success');
        }, 1000);
      } else{
        showMessage('#skmSchedulerAdminArea', response['msg']);

        $row = $('tr.schedule-'+response['entity_uid']);
        $row.addClass('skm-table-row-danger');
        setTimeout(function(){
          $row.removeClass('skm-table-row-danger');
        }, 1000);

      }
    });

  });

  $('#skmSchedulerAdminArea').on('click', '#selectAll', function(){
    if ( $(this).prop('checked') )
      $(this).siblings().prop('checked', true);
    else
      $(this).siblings().prop('checked', false);
  });

/*
 * FUNCIONES DE LA TAB DE RADIOS ----------------------------------------------
 */

  $('#skmRadiosAdminArea').off().on('submit', '#newRadioForm', function(e){
    e.stopPropagation();
    e.preventDefault();

    let isNewRadio = $('#radioId').val()==0;
    let data = {
      'data' : $(this).serialize(),
      'action': isNewRadio ? 'skm_add_radio' : 'skm_edit_radio',
    };

    $.post(ajaxurl, data, function(response){
      response = JSON.parse(response);

      $('#radioInput').val('');
      $('#radioId').val('0');
      $('#cancelEdit').remove();
      $('#submitButton').html('Cargar');

      if (isNewRadio)
        processResult(response['result'], response['radio'], response['msg'], '#skmRadiosAdminArea', radioRow);
      else{
        if (response['result']){
          let id = response['obj']['id'];
          let radio = response['obj']['radio'];
          $('#skmRadiosAdminArea table tr.radio-'+id+' td:first-child').html(radio);

        } else{
          showMessage('#skmRadiosAdminArea', response['msg']);
        }
      }
    });

  });

  $('#skmRadiosAdminArea').on('click', '#cancelEdit', function(){
    $('#radioInput').val('');
    $('#radioId').val('0');
    $(this).remove();
    $('#submitButton').html('Cargar');
  });

  $('#skmRadiosAdminArea').on('click', '.edit-radio', function(){

    let cancelButton = '<button id="cancelEdit" type="button" class="btn btn-dark">Cancelar</button>';
    if ( !$('#cancelEdit').length){
      $('#buttonArea').append(cancelButton);
      $('#submitButton').html('Editar');
    }

    let id = $(this).closest('tr').attr('data-radio');

    let data = {
        data: id,
        action: 'skm_edit_radio',
    };

    $.get(ajaxurl, data, function(response){
      response = JSON.parse(response);

      if (response['result']){
        $('#radioInput').val(response['obj']['radio']);
        $('#radioId').val(response['obj']['id']);

        $('#radioInput').attr('data-id', response['obj']['radioId']);
      }else{
        showMessage('#skmRadiosAdminArea', response['msg']);
      }

    });

  });

  $('#skmRadiosAdminArea').on('click', '.delete-radio', function(){
    let proceed = confirm('Vas a eliminar una radio. Deseas continuar?');

    if (proceed){

          let data = {
            data: $(this).closest('tr').attr('data-radio'),
            action: 'skm_delete_radio',
          };


          $.post(ajaxurl, data, function(response){
            response = JSON.parse(response);

            if (response['result'])
              $('tr.radio-'+response['radio_id']).remove();
            else
                showMessage('#skmRadiosAdminArea', response['msg']);
          });
    }


  });
})(jQuery);
