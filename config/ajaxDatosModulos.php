<?php
session_start();
error_reporting(0);
require_once '../helpers/user.php';
require_once '../helpers/user_session.php';
require_once '../helpers/Modulos.php';

if (isset($_SESSION["user"])){

    $app = new Modulos();
    $reg=$app->getModulos();
    echo json_encode($reg);

}else{

  echo "<script type='text/javascript'>
          window.location='../Login';
        </script>";
}
?>
