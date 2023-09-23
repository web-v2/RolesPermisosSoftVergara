<?php
include_once '../helpers/user.php';
include_once '../helpers/user_session.php';
include_once '../helpers/permisos.php';
include_once '../helpers/Tools.php';
include_once '../helpers/Dashboard.php';

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
  echo "<a href='Logout' style='text-decoration: none; font-size:16px;'>Cerrar Sesion</a>";
  echo "</td>";
  echo "<td>";
  echo "&nbsp;";
  echo "</td>";
  echo "</tr>";
  echo "</table>";

?>
  <!DOCTYPE html>
  <html lang="es">

  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Barragán & Urzola| Dashboard</title>

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
    <!-- overlayScrollbars -->
    <link rel="stylesheet" href="plugins/overlayScrollbars/css/OverlayScrollbars.min.css">
    <!-- Daterange picker
  <link rel="stylesheet" href="plugins/daterangepicker/daterangepicker.css">-->
    <!-- summernote -->
    <link rel="stylesheet" href="plugins/summernote/summernote-bs4.min.css">
    <style>
      .container {
        padding-top: 20px;
      }

      @media only screen and (max-width: 600px) {

        /* For tablets: */
        .row .col-3 {
          background-color: red;
          display: flex;
          flex-wrap: wrap;
        }

        .col-s-3 {
          width: 25%;
        }

        .col-s-4 {
          width: 33.33%;
        }

        .col-s-5 {
          width: 41.66%;
        }

        .col-s-6 {
          width: 50%;
        }

      }
    </style>
  </head>

  <body class="sidebar-mini layout-fixed sidebar-collapse">
    <div class="wrapper">

      <!-- Preloader -->
      <div class="preloader flex-column justify-content-center align-items-center">
        <img class="animation__shake" src="dist/img/AdminLTELogo.png" alt="AdminLTELogo" height="60" width="60">
      </div>

      <!-- Navbar -->
      <?php
      include_once 'layout/Menu_horizontal.php';
      ?>
      <!-- /.navbar -->

      <!-- Main Sidebar Container -->
      <?php
      include_once 'layout/Menu_vertical.php';
      ?>
      <!-- Fin Main Menu -->

      <!-- Content Wrapper. Contains page content -->
      <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="content-header">
          <div class="container-fluid">
            <div class="row mb-2">
              <div class="col-sm-6">
                <h1 class="m-0">Dashboard</h1>
              </div><!-- /.col -->
              <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                  <li class="breadcrumb-item"><a href="Dashboard">Home</a></li>
                  <li class="breadcrumb-item active">Dashboard</li>
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
              <!-- Small boxes (Stat box) -->
              <?php
              /* */
              $app = new Dashboard();

              $empl = $app->getCountByTable('empleados');
              $empleados = $empl[0]['count'];

              $emp = $app->getCountByTable('empresa');
              $empresa = $emp[0]['count'];

              $rep = $app->getNumUsers();
              $uxers = $rep[0]['n_user'];

              ?>

              <?php

              $rol = $_SESSION['rol'];
              $permisos = new Permisos();
              $res = $permisos->getPermisosByIdRol($rol);
              //print_r($res);
              ?>

              <div class="container responsive">
                <div class="row mb-2">

                  <div class="col-md-3">
                    <section class="connectedSortable">
                      <div class="card card-primary">
                        <div class="card-body">
                          <center>
                            <img src="dist/img/CompanyLogoW.jpeg" alt="img" width="230" height="180">
                          </center>
                        </div>
                      </div>
                    </section>
                  </div>

                  <div class="col-md-3">

                    <?php
                    for ($i = 0; $i < count($res); $i++) {
                      if ($res[$i]['titulo'] == 'EMPLEADOS' && $res[$i]['Leer'] == 1) {
                    ?>
                        <section class="connectedSortable">
                          <div class="small-box bg-success">
                            <div class="inner">
                              <h3><?php echo $empleados; ?></h3>
                              <p>Empleados</p>
                            </div>
                            <div class="icon">
                              <i class="fas fa-industry"></i>
                            </div>
                            <a href="Empleados" class="small-box-footer">Más información <i class="fas fa-arrow-circle-right"></i></a>
                          </div>
                        </section>
                      <?php
                      }
                    }
                    for ($i = 0; $i < count($res); $i++) {
                      if ($res[$i]['titulo'] == 'FACTURAS DE COMPRA' && $res[$i]['Leer'] == 1) {
                      ?>
                  </div>
                  <div class="col-md-3">

                    <section class="connectedSortable">
                      <div class="small-box bg-secondary">
                        <div class="inner">
                          <h3><?php echo $fc; ?></h3>

                          <p>Facturas de Compra</p>
                        </div>
                        <div class="icon">
                          <i class="fas fa-file-invoice-dollar"></i>
                        </div>
                        <a href="Facturas-compra" class="small-box-footer">Más información <i class="fas fa-arrow-circle-right"></i></a>
                      </div>
                    </section>

                  <?php
                      }
                    }
                    for ($i = 0; $i < count($res); $i++) {
                      if ($res[$i]['titulo'] == 'CLIENTES' && $res[$i]['Leer'] == 1) {
                  ?>
                  </div>
                  <div class="col-md-3">

                    <section class="connectedSortable">
                      <div class="small-box bg-primary">
                        <div class="inner">
                          <h3><?php echo $clientes; ?></h3>

                          <p>Clientes</p>
                        </div>
                        <div class="icon">
                          <i class="far fa-address-book"></i>
                        </div>
                        <a href="Clientes" class="small-box-footer">Más información <i class="fas fa-arrow-circle-right"></i></a>
                      </div>
                    </section>

                  <?php
                      }
                    }
                    for ($i = 0; $i < count($res); $i++) {
                      if ($res[$i]['titulo'] == 'PRODUCTOS' && $res[$i]['Leer'] == 1) {
                  ?>
                  </div>
                  <div class="col-md-3">

                    <section class="connectedSortable">
                      <div class="small-box bg-warning">
                        <div class="inner">
                          <h3><?php echo $productos; ?></h3>

                          <p>Productos</p>
                        </div>
                        <div class="icon">
                          <i class="fas fa-dolly-flatbed"></i>
                        </div>
                        <a href="Productos" class="small-box-footer">Más información <i class="fas fa-arrow-circle-right"></i></a>
                      </div>
                    </section>

                <?php
                      }
                    }
                ?>
                  </div>
                </div>
              </div>

              <div class="container">
                <div class="row">
                  <?php
                  for ($i = 0; $i < count($res); $i++) {
                    if ($res[$i]['titulo'] == 'COLABORADORES' && $res[$i]['Leer'] == 1) {
                  ?>
                      <div class="col-lg-3 col-6">
                        <div class="small-box bg-dark">
                          <div class="inner">
                            <h3><?php //echo $col; 
                                ?>0</h3>

                            <p>Colaboradores</p>
                          </div>
                          <div class="icon">
                            <i class="ion ion-person-add"></i>
                          </div>
                          <a href="Colaboradores" class="small-box-footer">Más información <i class="fas fa-arrow-circle-right"></i></a>
                        </div>
                      </div>
                    <?php
                    }
                  }
                  for ($i = 0; $i < count($res); $i++) {
                    if ($res[$i]['titulo'] == 'DATOS DE LA EMPRESA' && $res[$i]['Leer'] == 1) {
                    ?>
                      <div class="col-lg-3 col-6">
                        <div class="small-box bg-danger">
                          <div class="inner">
                            <h3><?php echo $empresa; ?></h3>

                            <p>Datos Empresa</p>
                          </div>
                          <div class="icon">
                            <i class="fas fa-building"></i>
                          </div>
                          <a href="Datos-empresa" class="small-box-footer">Más información <i class="fas fa-arrow-circle-right"></i></a>
                        </div>
                      </div>
                    <?php
                    }
                  }
                  for ($i = 0; $i < count($res); $i++) {
                    if ($res[$i]['titulo'] == 'USUARIOS' && $res[$i]['Leer'] == 1) {
                    ?>
                      <div class="col-lg-3 col-6">
                        <div class="small-box bg-success">
                          <div class="inner">
                            <h3><?php echo $uxers; ?></h3>
                            <p>Usuarios</p>
                          </div>
                          <div class="icon">
                            <i class="fas fa-users"></i>
                          </div>
                          <a href="Usuarios" class="small-box-footer">Más información <i class="fas fa-arrow-circle-right"></i></a>
                        </div>
                      </div>
                  <?php
                    }
                  }
                  ?>
                </div>
              </div>

            </div>
        </section>
      </div>


      <!-- /.content-wrapper footer-->
      <?php
      include_once 'layout/footer.php';
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
    <!-- ChartJS -->
    <script src="plugins/chart.js/Chart.min.js"></script>
    <!-- Sparkline-->
    <script src="plugins/sparklines/sparkline.js"></script>
    <!-- JQVMap -->
    <script src="plugins/jqvmap/jquery.vmap.min.js"></script>
    <script src="plugins/jqvmap/maps/jquery.vmap.usa.js"></script>
    <!-- jQuery Knob Chart -->
    <script src="plugins/jquery-knob/jquery.knob.min.js"></script>
    <!-- daterangepicker -->
    <script src="plugins/moment/moment.min.js"></script>
    <script src="plugins/daterangepicker/daterangepicker.js"></script>
    <!-- Tempusdominus Bootstrap 4 -->
    <script src="plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js"></script>
    <!-- Summernote -->
    <script src="plugins/summernote/summernote-bs4.min.js"></script>
    <!-- overlayScrollbars -->
    <script src="plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js"></script>
    <!-- AdminLTE App -->
    <script src="dist/js/adminlte.js"></script>
    <!-- AdminLTE for demo purposes
<script src="dist/js/demo.js"></script>-->
    <!-- AdminLTE dashboard demo (This is only for demo purposes) -->
    <script src="dist/js/pages/dashboard.js"></script>
  </body>

  </html>
<?php
} else {
  //header("Location:Login");
  echo "<script type='text/javascript'>
        window.location='Login';
       </script>";
}
?>