
let scheduleRow = function(schedule){
  let row = '<tr data-id="'+schedule['id']+'">';
  row += '<td>'+schedule['title']+'</td>'
  row += '<td>'+(schedule['sunday'] ? "Sí" : "-" )+'</td>'
  row += '<td>'+(schedule['monday'] ? "Sí" : "-" )+'</td>'
  row += '<td>'+(schedule['tuesday'] ? "Sí" : "-" )+'</td>'
  row += '<td>'+(schedule['wednesday'] ? "Sí" : "-" )+'</td>'
  row += '<td>'+(schedule['thursday'] ? "Sí" : "-" )+'</td>'
  row += '<td>'+(schedule['friday'] ? "Sí" : "-" )+'</td>'
  row += '<td>'+(schedule['saturday'] ? "Sí" : "-" )+'</td>'
  row += '<td>'+schedule['timetable']+'</td>'
  row += '<td><i class="skirmisher-edit fas fa-edit"></i>';
  row += '<i class="fas fa-trash-alt skirmisher-delete"></i></td>';
  row += '</tr>';
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


$(function(){

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

      processResult(response['result'], response['schedule'], response['msg'], '#skmSchedulerAdminArea', function(){
        return response['schedule'];
      });
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
    if ( !$('#selectDays input').attr('checked') )
      $('#selectDays input').attr('checked', true);
    else
      $('#selectDays input').attr('checked', false);
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
});
