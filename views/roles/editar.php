<?php
include_once '../../helpers/user.php';
include_once '../../helpers/user_session.php';
include_once '../../helpers/Tools.php';
include_once '../../helpers/Roles.php';
include_once '../../helpers/permisos.php';

if (isset($_SESSION["user"])) {
  error_reporting(0);
  $rol = $_SESSION['rol'];
  $permisos = new Permisos();
  $res = $permisos->getPermisosByIdRol($rol);
  for ($i = 0; $i < count($res); $i++) {
    if ($res[$i]['titulo'] == 'ROLES' && $res[$i]['Editar'] == 1) {
      $editarModulo = 'OK';
    }
  }
  if ($editarModulo == 'OK') {
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

    if (isset($_POST["form"]) and $_POST["form"] == "editar-data") {
      $i = $_POST["idR"];
      $app = new Roles();
      $resp = $app->updateRol($i);
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
                    <li class="breadcrumb-item active">Actualizar datos</li>
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
                      <h4 class="modal-title">Editar Rol</h4>
                    </div>
                    <div class="modal-body">
                      <p>
                      <form action="#" method="post" class="bordered">
                        <center>
                          <?php
                          $id = $_GET['token'];
                          $a = new Roles();
                          $res = $a->getRolById($id);
                          if (!$res) {
                            echo "Error, No hay datos con este id: <strong>" . $id . "</strong>, favor verificar!";
                          } else {
                            for ($i = 0; $i < count($res); $i++) {
                          ?>
                              <input type="hidden" name="form" value="editar-data">
                              <input type="hidden" name="idR" value="<?php echo $res[$i]['idRol']; ?>">
                              <input type="text" class="form-control-lg text-danger" readonly value="<?php echo $res[$i]['idRol']; ?>">
                              <input type="text" name="rolNombre" id="rolNombre" class="form-control-lg" placeholder="Nombre" required value="<?php echo $res[$i]['nombreRol']; ?>">
                              <input type="text" class="form-control-lg text-danger" readonly value="<?php echo $res[$i]['fecha_create']; ?>">
                          <?php }
                          } ?>
                        </center>

                        </p>
                    </div>
                    <div class="modal-footer justify-content-center">
                      <a href="../Roles" class="btn btn-warning"><i class="far fa-window-close"></i> Cancelar</a>
                      <button type="submit" class="btn btn-success"><i class="far fa-save"></i> Guardar Cambios</button>
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
      <script src="../plugins/daterangepicker/daterangepicker.js"></script>
      <!-- Tempusdominus Bootstrap 4 -->
      <script src="../plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js"></script>
      <!-- overlayScrollbars -->
      <script src="../plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js"></script>
      <!-- AdminLTE App -->
      <script src="../dist/js/adminlte.js"></script>
      <script src="../dist/js/pages/dashboard.js"></script>
      <script src="../plugins/toastr/toastr.min.js"></script>

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
    echo "<script type='text/javascript'>
        alert('No tiene permisos para realizar esta acción');
        window.location='../Roles';
       </script>";
  }
} else {
  echo "<script type='text/javascript'>
        window.location='../Login';
       </script>";
}
?>