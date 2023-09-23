<?php
session_start();
error_reporting(0);
require_once '../helpers/user.php';
require_once '../helpers/user_session.php';

if (isset($_SESSION["user"])){
    $app = new User();
    $reg=$app->getAllUsers();
    echo json_encode($reg);

}else{

  echo "<script type='text/javascript'>
          window.location='../Login';
        </script>";
}
?>
