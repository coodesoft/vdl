<?php

function skm_radios_tab(){ ?>

  <div id="skmRadiosAdminArea" class="skm-container container-fluid">
    <div class="row">
      <div class="response alert d-none" role="alert"></div>
    </div>
    <div class="row">
      <div class="col-6">

        <div class="card w-100" style="max-width: 100%;">
          <div class="card-body">
            <form id="newRadioForm">
              <div class="form-group">
                <label for="radioInput">Nombre de la radio</label>
                <input data-id="0" type="text" class="form-control" id="radioInput" name="radio" aria-describedby="emailHelp" placeholder="Ingresa un nombre para tu radio">
                <input type="hidden" class="form-control" name="radioId" id="radioId" value="0">
                <small id="emailHelp" class="form-text text-muted">El nombre que ingreses servirá a los usuarios para filtrar la programación radial</small>
              </div>
              <div id="buttonArea" class="form-group">
                <button id="submitButton" type="submit" class="btn btn-dark">Cargar</button>
              </div>
            </form>
          </div>
        </div>

      </div>

      <div class="col-6">

        <?php $radios = Radios::getAll(); ?>
          <table class="table table-striped">
            <thead>
              <tr>
                <th scope="col">Radio</th>
                <th scope="col">Acciones</th>
              </tr>
            </thead>
            <tbody>
              <?php if (count($radios)==0) { ?>
                <tr id="emptyTable">
                  <td colspan="3" class="text-center">Todavía no hay radios cargadas</td>
                </tr>
              <?php } ?>
              <?php foreach ($radios as $key => $radio): ?>
                  <tr class="radio-<?php echo $radio['id']?>" data-radio="<?php echo $radio['id']?>">
                    <td><?php echo $radio['radio'] ?></td>
                    <td>
                      <i class="edit-radio fas fa-edit"></i>
                      <i class="delete-radio fas fa-trash-alt"></i>
                    </td>
                  </tr>
              <?php endforeach; ?>
            </tbody>
          </table>
      </div>
    </div>

  </div>
<?php
}

add_action( 'wp_ajax_skm_add_radio', 'skm_add_radio' );
function skm_add_radio(){
  $toSave = $_POST['data'];
  parse_str($_POST['data'], $toSave);


  $radio_id = Radios::add($toSave['radio']);

  if ($radio_id){
    $response['radio'] = $toSave['radio'];
    $response['id'] = $radio_id;
    echo json_encode(['result' => true, 'radio' => $response] );
  } else
    echo json_encode(['result' => false, 'msj' => 'Ops, hay algo mal que no anda bien. Se produjo un error al guardar la radio'] );
  wp_die();
}

add_action( 'wp_ajax_skm_edit_radio', 'skm_edit_radio');
function skm_edit_radio(){

  if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    parse_str($_POST['data'], $toEdit);

    $radio_id = Radios::edit($toEdit['radioId'], $toEdit['radio']);

    if ($radio_id){
      $response['id'] = $radio_id;
      $response['radio'] = $toEdit['radio'];
      echo json_encode( ['result' => true, 'obj' => $response] );
    } else
      echo json_encode( ['result' => false, 'msg' => 'Ops, hay algo mal que no anda bien. Se produjo un error al actualizar la radio'] );
    wp_die();
  } else{
    $toEdit = $_GET['data'];
    $radio = Radios::getById($toEdit);

    if (count($radio)>0)
      echo json_encode( ['result' => true, 'obj' => $radio[0]] );
    else
      echo json_encode( ['result' => false, 'msg' => 'Ops, hay algo mal que no anda bien. No se pudo cargar la radio solicitada para su edición.'] );
    wp_die();
  }
}

add_action( 'wp_ajax_skm_delete_radio', 'skm_delete_radio' );
function skm_delete_radio(){
  $toDelete = intval($_POST['data']);

  if ($toDelete){
    $result = Radios::delete($toDelete);
    $response = ($result) ? ['result' => true, 'radio_id'=> $toDelete] : ['result' => false, 'msg' => 'Ops, hay algo mal que no anda bien. Se produjo un error al eliminar la radio' ] ;
  } else
    $response = ['result' => false, 'msg' => 'El ID de la radio que deseas eliminar no es válido' ];

  echo json_encode($response);
  wp_die();
}
