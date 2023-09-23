<?php
include_once '../../helpers/user.php';
include_once '../../helpers/user_session.php';
include_once '../../helpers/Tools.php';
include_once '../../helpers/Roles.php';
//include_once '../../helpers/Modulos.php';

if (isset($_SESSION["user"])) {
  //error_reporting(0);

  $user = new User();
  $user->setUser($_SESSION['user']);
  //background-color: #323EDD; opacity: 0.5
  echo "<table style='width: 100%;'>";
  echo "<tr>";
  echo "<td align='right'>";
  echo "Usuario: <span style='font-weight: bold;'>" . $user->getUser() . "</span>";
  echo "&nbsp;";
  echo "<a href='../Logout' style='text-decoration: none; font-size:16px;'>Cerrar Sesion</a>";
  echo "</td>";
  echo "<td>";
  echo "&nbsp;";
  echo "</td>";
  echo "</tr>";
  echo "</table>";

  if (isset($_POST["form"]) and $_POST["form"] == "modulos-data") {
    //print_r($_POST);
    /*
  $app = new Roles();
  $resp = $app->addModulos_rol();
  */
  }


?>
  <!DOCTYPE html>
  <html lang="es">

  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Barragán & Urzola | Roles</title>

    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="../plugins/fontawesome-free/css/all.min.css">
    <!-- Favicon -->
    <link rel="icon" type="image/png" href="../dist/img/favicon.ico" />
    <!-- Ionicons -->
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <!-- Tempusdominus Bootstrap 4 -->
    <link rel="stylesheet" href="../plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css">
    <!-- iCheck -->
    <link rel="stylesheet" href="../plugins/icheck-bootstrap/icheck-bootstrap.min.css">
    <!-- JQVMap -->
    <link rel="stylesheet" href="../plugins/jqvmap/jqvmap.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="../dist/css/adminlte.min.css">
    <!-- Toastr -->
    <link rel="stylesheet" href="../plugins/toastr/toastr.min.css">

    <!-- overlayScrollbars -->
    <link rel="stylesheet" href="../plugins/overlayScrollbars/css/OverlayScrollbars.min.css">
    <!-- Theme style -->
  </head>

  <body class="sidebar-mini layout-fixed sidebar-collapse">
    <div class="wrapper">

      <!-- Preloader -->
      <div class="preloader flex-column justify-content-center align-items-center">
        <img class="animation__shake" src="../dist/img/AdminLTELogo.png" alt="AdminLTELogo" height="60" width="60">
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
                <h1 class="m-0">Rol No. <?php print_r($_GET['token']); ?></h1>
              </div><!-- /.col -->
              <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                  <li class="breadcrumb-item"><a href="../Dashboard">Home</a></li>
                  <li class="breadcrumb-item"><a href="../Roles">Roles</a></li>
                  <li class="breadcrumb-item active">Módulos</li>
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
                <div class="modal-content">
                  <div class="modal-header bg-primary">
                    <h4 class="modal-title">Administración de Módulos</h4>
                  </div>
                  <div class="modal-body">
                    <p>
                      <?php
                      if (isset($_POST["form"]) and $_POST["form"] == "modulos-data") {
                        $app = new Roles();
                        $resp = $app->addModulos_rol();
                      } ?>
                    <form action="#" method="post" class="bordered">
                      <center>

                        <input type="hidden" name="form" value="modulos-data">
                        <input type="hidden" name="idR" id="idR" value="<?php echo $_GET['token']; ?>">
                        <table class="table table-striped table-bordered">
                          <tr>
                            <th>#</th>
                            <th>Módulo</th>
                            <th>Ver</th>
                          </tr>
                          <?php
                          $id = $_GET['token'];
                          $a = new Roles();
                          $res = $a->getModulos_permisosByIdRol($id);
                          //print_r($res);
                          $cant = count($res);
                          if (!$res) {
                            echo "Error, No hay datos con este id: <strong>" . $id . "</strong>, favor verificar!";
                          } else {
                            for ($i = 0; $i < count($res); $i++) {

                          ?>
                              <tr>
                                <td><?php echo $res[$i]['idModulo'] ?></td>
                                <td><?php echo $res[$i]['titulo'] ?></td>
                                <td>
                                  <?php
                                  if (isset($res[$i]['idboton'])) {
                                  ?>
                                    <input type="checkbox" id="<?php echo $res[$i]['idModulo']; ?>" onfocus="asignarModulo(<?php echo $res[$i]['idPermiso']; ?>,<?php echo $i ?>)" value="1" name="my-checkbox[<?php echo $i ?>]" checked data-bootstrap-switch data-off-color="danger" data-on-color="success">
                                  <?php
                                  } else {
                                  ?>
                                    <input type="checkbox" id="<?php echo $res[$i]['idModulo']; ?>" onfocus="asignarModulo(0,<?php echo $i ?>)" value="0" name="my-checkbox[<?php echo $i ?>]" data-bootstrap-switch data-off-color="danger" data-on-color="success">
                                  <?php
                                  }
                                  ?>
                                </td>
                              </tr>
                          <?php }
                          } ?>
                          <input type="hidden" name="cant" value="<?php echo $cant; ?>">
                        </table>
                      </center>

                      </p>
                  </div>
                  <div class="modal-footer justify-content-center">
                    <a href="../Roles" class="btn btn-warning"><i class="far fa-window-close"></i> Volver</a>
                    </form>
                  </div>
                </div>
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
    <script src="../plugins/jquery/jquery.min.js"></script>
    <!-- jQuery UI 1.11.4 -->
    <script src="../plugins/jquery-ui/jquery-ui.min.js"></script>
    <!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
    <script>
      $.widget.bridge('uibutton', $.ui.button)
    </script>
    <!-- Bootstrap 4 -->
    <script src="../plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
    <!-- JQVMap -->
    <script src="../plugins/jqvmap/jquery.vmap.min.js"></script>
    <script src="../plugins/jqvmap/maps/jquery.vmap.usa.js"></script>
    <!-- daterangepicker -->
    <script src="../plugins/moment/moment.min.js"></script>
    <!-- switch -->
    <script src="../plugins/bootstrap-switch/js/bootstrap-switch.min.js"></script>
    <script src="../plugins/daterangepicker/daterangepicker.js"></script>
    <!-- Tempusdominus Bootstrap 4 -->
    <script src="../plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js"></script>
    <!-- overlayScrollbars -->
    <script src="../plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js"></script>
    <!-- AdminLTE App -->
    <script src="../dist/js/adminlte.js"></script>
    <script src="../dist/js/pages/dashboard.js"></script>
    <script src="../plugins/toastr/toastr.min.js"></script>

    <link href="https://cdn.jsdelivr.net/gh/gitbrent/bootstrap4-toggle@3.6.1/css/bootstrap4-toggle.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/gh/gitbrent/bootstrap4-toggle@3.6.1/js/bootstrap4-toggle.min.js"></script>

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
      $("input[data-bootstrap-switch]").each(function() {
        $(this).bootstrapSwitch('state', $(this).prop('checked'));
      });

      function asignarModulo(permiso, idcheck) {
        let idPermiso = permiso;
        let check = document.getElementsByName('my-checkbox[' + idcheck + ']');
        let modulo = (check[0].id >= 0) ? check[0].id : 0;
        let accion = (check[0].value == 0) ? 1 : 0;
        let rol = $('#idR').val().trim();

        if (idPermiso.length <= 0) {
          console.log("Error, id del permiso es invalido o esta Vacio");
        } else {
          if (accion.length <= 0 || accion >= 2) {
            console.log("Error, valor de la accion es invalida o esta Vacio");
          } else {
            accionGeneral = (check[0].value == 0) ? 'CREATE' : 'DELETE';
            let parametros = {
              idPermiso,
              modulo,
              accion,
              accionGeneral,
              rol
            };
            console.log(parametros);
            check[0].value = accion;

            $.ajax({
              data: parametros,
              url: '../config/ajaxAddModuloByIdPermiso.php',
              type: 'POST',

              beforeSend: function() {
                $("#query").html("<div class='spinner-border text-success' align='center'></div>");
              },

              success: function(response) {
                $("#query").html(response);
              }
            });



          }
        }
      }
    </script>
  </body>

  </html>

<?php
  if (isset($_POST["form"]) and $_POST["form"] == "editar-data") {
    if ($resp) {
      echo "
    <script>
        Command: toastr['success']('Información actualizada Correctamente!!!', 'Actualización Ok!');
    </script>
    ";
    } else {
      echo "
    <script>
        Command: toastr['error']('Comuniquese con el administrador del sistema!', 'Error, Fallo la Actualización!');
    </script>
    ";
    }
  }
} else {

  //header("Location:Login");
  echo "<script type='text/javascript'>
        window.location='../../Login';
       </script>";
}
?>