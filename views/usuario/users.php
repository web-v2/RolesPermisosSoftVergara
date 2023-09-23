<?php
include_once '../../helpers/user.php';
include_once '../../helpers/user_session.php';
include_once '../../helpers/Tools.php';
include_once '../../helpers/Roles.php';
include_once '../../helpers/permisos.php';

if (isset($_SESSION["user"])) {
  //error_reporting(0);
  $rol = $_SESSION['rol'];
  $permisos = new Permisos();
  $res = $permisos->getPermisosByIdRol($rol);
  //print_r($res);
  for ($i = 0; $i < count($res); $i++) {
    if ($res[$i]['titulo'] == 'USUARIOS') {
      $Modulo = 'OK';
    }
  }
  if ($Modulo == 'OK') {
    $user = new User();
    $user->setUser($_SESSION['user']);


    echo "<table style='width: 100%;'>";
    echo "<tr>";
    echo "<td align='right'>";
    echo "Usuario: <span style='font-weight: bold;'>" . $user->getUser() . "</span>";
    echo "&nbsp;";
    echo "<a href='Logout' style='text-decoration: none; font-size:16px;'>Cerrar Sesion</a>";
    echo "</td>";
    echo "<td>";
    echo "&nbsp;";
    echo "</td>";
    echo "</tr>";
    echo "</table>";

    if (isset($_POST["form"]) and $_POST["form"] == "form-data") {
      //print_r($_POST);
      $app = new User();
      $resp = $app->newUser();
    }


?>
    <!DOCTYPE html>
    <html lang="es">

    <head>
      <meta charset="utf-8">
      <meta name="viewport" content="width=device-width, initial-scale=1">
      <title>Barragán & Urzola | Mantenimiento de Usuarios</title>

      <!-- Google Font: Source Sans Pro -->
      <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
      <!-- Font Awesome -->
      <link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">
      <!-- Favicon -->
      <link rel="icon" type="image/png" href="dist/img/favicon.ico" />
      <!-- Ionicons -->
      <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
      <!-- Tempusdominus Bootstrap 4 -->
      <link rel="stylesheet" href="plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css">
      <!-- iCheck -->
      <link rel="stylesheet" href="plugins/icheck-bootstrap/icheck-bootstrap.min.css">
      <!-- JQVMap -->
      <link rel="stylesheet" href="plugins/jqvmap/jqvmap.min.css">
      <!-- Theme style -->
      <link rel="stylesheet" href="dist/css/adminlte.min.css">
      <!-- Toastr -->
      <link rel="stylesheet" href="plugins/toastr/toastr.min.css">
      <!-- overlayScrollbars -->
      <link rel="stylesheet" href="plugins/overlayScrollbars/css/OverlayScrollbars.min.css">
      <!-- DataTables -->
      <link rel="stylesheet" href="plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
      <link rel="stylesheet" href="plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
      <link rel="stylesheet" href="plugins/datatables-buttons/css/buttons.bootstrap4.min.css">
      <!-- Theme style -->
    </head>

    <body class="sidebar-mini layout-fixed sidebar-collapse">
      <div class="wrapper">

        <!-- Preloader -->
        <div class="preloader flex-column justify-content-center align-items-center">
          <img class="animation__shake" src="dist/img/AdminLTELogo.png" alt="AdminLTELogo" height="60" width="60">
        </div>

        <!-- Navbar -->
        <?php
        include_once '../layout/Menu_horizontal.php';
        ?>
        <!-- /.navbar -->

        <!-- Main Sidebar Container -->
        <?php
        include_once '../layout/Menu_vertical.php';
        ?>
        <!-- Fin Main Menu -->

        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
          <!-- Content Header (Page header) -->
          <div class="content-header">
            <div class="container-fluid">
              <div class="row mb-2">
                <div class="col-sm-6">
                  <h1 class="m-0">Mantenimiento de Usuarios</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                  <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="Dashboard">Home</a></li>
                    <li class="breadcrumb-item active">Usuarios</li>
                  </ol>
                </div><!-- /.col -->
              </div><!-- /.row -->
            </div><!-- /.container-fluid -->
          </div>
          <!-- /.content-header -->

          <!-- Main content -->
          <section class="content">
            <div class="container-fluid">

              <div class="card">
                <!-- /.card-header -->
                <div class="card-body">
                  <?php
                  for ($i = 0; $i < count($res); $i++) {
                    if ($res[$i]['titulo'] == 'USUARIOS' && $res[$i]['Crear'] == 1) {
                  ?>
                      <span class="btn btn-success" data-toggle="modal" data-target="#modal-xl"><i class="fas fa-plus"></i> Nuevo</span>
                    <?php }
                    if ($res[$i]['titulo'] == 'USUARIOS' && $res[$i]['Leer'] == 1) {
                    ?>
                      <table id="table-data" class="table table-bordered table-striped">
                        <thead>
                          <tr class="bg-warning">
                            <th>Username</th>
                            <th>Email</th>
                            <th>Estado</th>
                            <th>Rol Asignado</th>
                            <th>Fecha_Creación</th>
                            <th>-</th>
                            <th>-</th>
                            <th>-</th>
                          </tr>
                        </thead>
                        <tbody>
                          <tr>
                            <td>-</td>
                            <td>-</td>
                            <td>-</td>
                            <td>-</td>
                            <td>-</td>
                            <td>-</td>
                            <td>-</td>
                            <td>-</td>
                          </tr>
                        </tbody>
                      </table>
                  <?php } else {
                      if ($res[$i]['Leer'] == 0) {
                        echo "<label class'bg-danger'>No Tiene Permisos para ver la información contacte al administrador del sistema</label>";
                      }
                    }
                  }
                  ?>
                </div>
                <!-- /.card-body -->
              </div>
              <!-- /.card -->
            </div>
            <!-- ./container -->
            <!-- /.row (main row) -->
        </div><!-- /.container-fluid -->
        </section>
        <!-- /.content -->
      </div>
      <!-- /.content-wrapper footer-->
      <?php
      include_once '../layout/footer.php';
      ?>

      <!-- Control Sidebar -->
      <aside class="control-sidebar control-sidebar-dark">
        <!-- Control sidebar content goes here -->
      </aside>
      <!-- /.control-sidebar -->
      </div>
      <!-- ./wrapper -->

      <!-- jQuery -->
      <script src="plugins/jquery/jquery.min.js"></script>
      <!-- jQuery UI 1.11.4 -->
      <script src="plugins/jquery-ui/jquery-ui.min.js"></script>
      <!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
      <script>
        $.widget.bridge('uibutton', $.ui.button)
      </script>
      <!-- Bootstrap 4 -->
      <script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
      <!-- JQVMap -->
      <script src="plugins/jqvmap/jquery.vmap.min.js"></script>
      <script src="plugins/jqvmap/maps/jquery.vmap.usa.js"></script>
      <!-- daterangepicker -->
      <script src="plugins/moment/moment.min.js"></script>
      <script src="plugins/daterangepicker/daterangepicker.js"></script>
      <!-- Tempusdominus Bootstrap 4 -->
      <script src="plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js"></script>
      <!-- overlayScrollbars -->
      <script src="plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js"></script>
      <!-- AdminLTE App -->
      <script src="dist/js/adminlte.js"></script>
      <!-- AdminLTE dashboard demo (This is only for demo purposes) -->
      <script src="dist/js/pages/dashboard.js"></script>
      <script src="plugins/toastr/toastr.min.js"></script>
      <!-- DataTables  & Plugins -->
      <script src="plugins/datatables/jquery.dataTables.min.js"></script>
      <script src="plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
      <script src="plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
      <script src="plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
      <script src="plugins/datatables-buttons/js/dataTables.buttons.min.js"></script>
      <script src="plugins/datatables-buttons/js/buttons.bootstrap4.min.js"></script>
      <script src="plugins/jszip/jszip.min.js"></script>
      <script src="plugins/pdfmake/pdfmake.min.js"></script>
      <script src="plugins/pdfmake/vfs_fonts.js"></script>
      <script src="plugins/datatables-buttons/js/buttons.html5.min.js"></script>
      <script src="plugins/datatables-buttons/js/buttons.print.min.js"></script>
      <script src="plugins/datatables-buttons/js/buttons.colVis.min.js"></script>
      <script>
        $(function() {
          let Toast = Swal.mixin({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 3000
          });
        });

        toastr.options = {
          "closeButton": false,
          "debug": false,
          "newestOnTop": false,
          "progressBar": false,
          "positionClass": "toast-top-full-width",
          "preventDuplicates": false,
          "onclick": null,
          "showDuration": "300",
          "hideDuration": "1000",
          "timeOut": "5000",
          "extendedTimeOut": "1000",
          "showEasing": "swing",
          "hideEasing": "linear",
          "showMethod": "fadeIn",
          "hideMethod": "fadeOut"
        }
        $(document).ready(function() {
          $("#correoUser").val('');
          $.ajax({
            url: "config/ajaxDatosUsuarios.php",
            success: function(data) {
              let query = JSON.parse(data); //A la variable le asigno el json decodificado JSON.parse(data);
              if (query) {
                $("#table-data").DataTable({
                  data: query,
                  "order": [0, 'desc'],
                  "columns": [{
                      "data": "username"
                    },
                    {
                      "data": "email"
                    },
                    {
                      "data": "estadoUxer"
                    },
                    {
                      "data": "rolNomobre"
                    },
                    {
                      "data": "fecha_create"
                    },
                    {
                      "data": null,
                      render: function(data, type, row) {
                        return "<a href='editar-usuario/" + data['idUxer'] + "' class='btn btn-sm btn-primary'><i class='fas fa-edit'></i> Editar</a>"
                      }
                    },
                    {
                      "data": null,
                      render: function(data, type, row) {
                        return "<a href='reset-password/" + data['idUxer'] + "' class='btn btn-sm btn-danger'><i class='fas fa-key'></i> Resetear</a>"
                      }
                    },
                    {
                      "data": null,
                      render: function(data, type, row) {
                        return "<a href='reset-password-mail/" + data['idUxer'] + "' class='btn btn-sm btn-dark'><i class='fas fa-envelope'></i> Enviar Correo</a>"
                      }
                    }
                  ],
                  bJQueryUI: true,
                  "responsive": true,
                  "lengthChange": false,
                  "autoWidth": false,
                  "buttons": ["excel", "colvis"]
                }).buttons().container().appendTo('#table-data_wrapper .col-md-6:eq(0)');
              }
            }
          });
        });

        $('document').ready(function() {
          $('#btn-correo-search').on('click', function() {
            buscarEmailUsuario();
          });
        });

        function buscarEmailUsuario() {
          let idCol = $("#correoUser").val().trim();
          let caract = new RegExp(/^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/);

          if (caract.test(idCol) == false) {
            $("#correoUser").addClass("bg-danger");
            return false;
          }
          $("#correoUser").removeClass("bg-warning");
          if (idCol.length <= 0 || idCol == "" || idCol == 0) {
            console.log("Error, campo Input Vacio");
            $("#correoUser").addClass("bg-warning");
          } else {
            $("#correoUser").removeClass("bg-warning");
            console.log("Exec: " + idCol);
            let parametros = {
              idCol
            };
            $.ajax({
              data: parametros,
              url: 'config/ajaxCorreoUsuarioExist.php',
              type: 'POST',

              beforeSend: function() {
                $("#query").html("<div class='spinner-border text-success' align='center'></div>");
              },

              success: function(response) {
                $("#query").html(response);
              }
            }); /**/
          }
        }


        function validaContrasenas() {
          let c1 = $("#cont1").val().trim();
          let c2 = $("#cont2").val().trim();

          if (c1.length <= 0 || c1 == "" || c1 == 0) {
            $("#cont1").addClass("bg-warning");
          } else {
            $("#cont1").removeClass("bg-warning");
          }
          if (c2.length <= 0 || c2 == "" || c2 == 0) {
            $("#cont2").addClass("bg-warning");
          } else {
            $("#cont2").removeClass("bg-warning");
          }

          if (c1 != c2) {
            $("#cont1").addClass("bg-warning");
            $("#cont2").addClass("bg-warning");
            $("#btnSave").addClass("disabled");
            $("#cont1").val('');
            $("#cont2").val('');
          } else {
            //*La contraseña debe tener entre 6 y 10 caracteres, *1 Letra Mayúscula, *1 Letra minúscula, *1 Número
            let ejecutar = new RegExp(/^(?=\w)(?=(?:.*\d){1})(?=(?:.*[A-Z]){1})(?=(?:.*[a-z]){1})\S{6,10}$/);
            if (ejecutar.test(c1)) {
              $("#cont1").removeClass("bg-warning border-danger");
              $("#cont2").removeClass("bg-warning border-danger");
              $("#cont1").addClass("border-success");
              $("#cont2").addClass("border-success");
              $("#btnSave").removeClass("disabled");
              $('#val').hide();
            } else {
              $("#cont1").addClass("border-danger");
              $("#cont2").addClass("border-danger");
              $("#val").html("<strong>Error, validar correctamente los parámetros para la asignación de contraseña</strong>");
            }
          }
        }
      </script>
    </body>

    </html>
    <div class="modal fade" id="modal-xl">
      <div class="modal-dialog modal-lg">
        <div class="modal-content">
          <div class="modal-header bg-primary">
            <h4 class="modal-title">Crear Usuario</h4>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <p>
            <form action="Usuarios" method="post" class="bordered">
              <center>
                <input type="hidden" name="form" value="form-data" autocomplete="off">
                <div class="card">
                  <div class="card-body">

                    <div id="query">
                      <div class="col-md-12">
                        <label for="correoUser" class="form-label">Correo</label>
                        <input type="email" class="form-control" name="correoUser" id="correoUser" required placeholder="Correo Electrónico">
                        <a href="#" class="btn btn-danger btn-xs" id="btn-correo-search">Buscar</a>
                      </div><!-- Fin col-md-12 -->

                      <div class="row g-3">
                        <div class="col-md-6">
                          <label for="rol" class="form-label">Asignar Rol</label>
                          <select name="rol" id="rol" class="form-control" required>
                            <option value=""></option>
                          </select>
                        </div>

                        <div class="col-md-6">
                          <label for="user" class="form-label">Usuario</label>
                          <input type="text" class="form-control" name="user" id="user" required placeholder="Nombre Usuario">
                        </div>

                        <div class="col-md-6">
                          <label for="cont1" class="form-label">Contraseña</label>
                          <input type="password" class="form-control" name="cont1" id="cont1" required placeholder="****">
                        </div>

                        <div class="col-md-6">
                          <label for="cont2" class="form-label">Confirma Contraseña</label>
                          <input type="password" class="form-control" name="cont2" id="cont2" required onchange="validaContrasenas();" placeholder="****">
                        </div>

                        <div class="col-md-12">
                          <p class="text-danger" id="val"></p>
                        </div>
                      </div> <!-- Fin row g-3 -->
                    </div> <!-- /.fin div Query ajax buscar email -->

                  </div><!-- Fin Card-body -->
                </div> <!-- Fin Card -->
              </center>
              </p>
          </div>
          <div class="modal-footer justify-content-center">
            <button type="button" class="btn btn-warning" data-dismiss="modal"><i class="far fa-window-close"></i> Cerrar</button>
            <button type="submit" class="btn btn-success disabled" id="btnSave"><i class="far fa-save"></i> Guardar Cambios</button>
            </form>
          </div>
        </div>
        <!-- /.modal-content -->
      </div>
      <!-- /.modal-dialog -->
    </div>
    <!-- /.modal -->
<?php
    if (isset($_POST["form"]) and $_POST["form"] == "form-area") {
      if ($resp) {
        echo "
    <script>
        Command: toastr['success']('Información almacenada Correctamente!!!', 'Inserción Ok!');
    </script>
    ";
      } else {
        echo "
    <script>
        Command: toastr['error']('Comuniquese con el administrador del sistema!', 'Error, Fallo la inserción!');
    </script>
    ";
      }
    }
  } else {
    echo "<script type='text/javascript'>
        alert('No tiene permisos para este Modulo!');
        window.location='Dashboard';
       </script>";
  }
} else {

  //header("Location:Login");
  echo "<script type='text/javascript'>
        window.location='Login';
       </script>";
}
?>