function create(permiso, idcheck){
  let idCreate = permiso;
  let action = document.getElementsByName('crear-checkbox['+idcheck+']');
  let accion = (action[0].value == 0) ? 1 : 0;
  let accionGeneral = 'CREATE';
  if(idCreate.length <= 0 || idCreate == "" || idCreate == 0){
        console.log("Error, id del permiso es invalido o esta Vacio");
    }else{
      if(accion.length <= 0 || accion >= 2){
        console.log("Error, valor de la accion es invalida o esta Vacio");
      }else{
        let parametros = {idCreate,accion, accionGeneral};
        console.log(parametros);
        action[0].value = accion;
        $.ajax({
                data:  parametros,
                url:   '../config/ajaxAddPermisoByAccion.php',
                type:  'POST',

                beforeSend: function () {
                    $("#query").html("<div class='spinner-border text-success' align='center'></div>");
                },

                success:  function (response) {
                    $("#query").html(response);
                }
        });
      }
    }
}

function read(permiso,idcheck) {
  let idRead = permiso;
  let action = document.getElementsByName('leer-checkbox['+idcheck+']');
  let accion = (action[0].value == 0) ? 1 : 0;
  let accionGeneral = 'READ';
    if(idRead.length <= 0 || idRead == "" || idRead == 0){
        console.log("Error, id del permiso es invalido o esta Vacio");
    }else{
      if(accion.length <= 0 || accion >= 2){
        console.log("Error, valor de la accion es invalida o esta Vacio");
      }else{
        let parametros = {idRead,accion, accionGeneral};
        console.log(parametros);
        action[0].value = accion;
        $.ajax({
                data:  parametros,
                url:   '../config/ajaxAddPermisoByAccion.php',
                type:  'POST',

                beforeSend: function () {
                    $("#query").html("<div class='spinner-border text-success' align='center'></div>");
                },

                success:  function (response) {
                    $("#query").html(response);
                }
        });
      }
    }
}

function update(permiso,idcheck) {
  let idUpdate = permiso;
  let action = document.getElementsByName('editar-checkbox['+idcheck+']');
  let accion = (action[0].value == 0) ? 1 : 0;
  let accionGeneral = 'UPDATE';
    if(idUpdate.length <= 0 || idUpdate == "" || idUpdate == 0){
        console.log("Error, id del permiso es invalido o esta Vacio");
    }else{
      if(accion.length <= 0 || accion >= 2){
        console.log("Error, valor de la accion es invalida o esta Vacio");
      }else{
        let parametros = {idUpdate,accion, accionGeneral};
        console.log(parametros);
        action[0].value = accion;
        $.ajax({
                data:  parametros,
                url:   '../config/ajaxAddPermisoByAccion.php',
                type:  'POST',

                beforeSend: function () {
                    $("#query").html("<div class='spinner-border text-success' align='center'></div>");
                },

                success:  function (response) {
                    $("#query").html(response);
                }
        });
      }
    }
}

function deleteAccion(permiso,idcheck) {
  let idDelete = permiso;
  let action = document.getElementsByName('eliminar-checkbox['+idcheck+']');
  let accion = (action[0].value == 0) ? 1 : 0;
  let accionGeneral = 'DELETE';
    if(idDelete.length <= 0 || idDelete == "" || idDelete == 0){
        console.log("Error, id del permiso es invalido o esta Vacio");
    }else{
      if(accion.length <= 0 || accion >= 2){
        console.log("Error, valor de la accion es invalida o esta Vacio");
      }else{
        let parametros = {idDelete,accion, accionGeneral};
        console.log(parametros);
        action[0].value = accion;
        $.ajax({
                data:  parametros,
                url:   '../config/ajaxAddPermisoByAccion.php',
                type:  'POST',

                beforeSend: function () {
                    $("#query").html("<div class='spinner-border text-success' align='center'></div>");
                },

                success:  function (response) {

                    $("#query").html(response);
                }
        });
      }
    }
}
