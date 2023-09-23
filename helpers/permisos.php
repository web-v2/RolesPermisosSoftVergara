<?php
include_once 'db.php';
include_once 'Tools.php';
include_once 'user.php';

class Permisos extends db{
    private $rol;
    private $permiso;

    public function getPermisosByIdRol($id_rol){
      $hr = new Tools();
      $query = $this->connect()->prepare('SELECT M.idModulo, R.idRol, R.nombreRol, P.idPermiso, P.Crear, P.Leer, P.Editar, P.Eliminar, M.titulo FROM roles AS R, permisos AS P, modulos AS M WHERE R.idRol = P.idRol AND P.idRol = R.idRol AND P.idModulo = M.idModulo AND M.idModulo = P.idModulo AND R.idRol = :id;');
      $query->execute(['id'=>$hr->limpiarCadena($id_rol)]);
      $this->close();
      while($filas = $query->FETCHALL(PDO::FETCH_ASSOC)){
        return $this->permiso[]=$filas;
      }   return false;
    }

    public function getPermisosModulosByIdRol($rol){
      $query = $this->connect()->prepare('SELECT P.idPermiso, P.idModulo AS idboton, P.idRol, M.* FROM `permisos` AS P RIGHT JOIN modulos as M ON P.idModulo = M.idModulo AND M.status =:s AND P.idRol =:i;');
      $query->execute(['s' =>'ACTIVO','i'=>$rol]);
      $this->close();
      while($filas = $query->FETCHALL(PDO::FETCH_ASSOC)){
          return $this->permiso[]=$filas;
      }   return false;
    }

    public function updatePermisosByIdRol(){
      if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $permissions = array('crear-checkbox' => 'CREATE', 'leer-checkbox' => 'READ', 'editar-checkbox' => 'UPDATE', 'eliminar-checkbox' => 'DELETE');
        foreach ($permissions as $input_name => $permission) {
          if (isset($_POST[$input_name])) {
            //echo "Recorrido para $permission<br>";
            $items = $_POST[$input_name];
            foreach ($items as $key => $idModulo) {
              $c = ($permission == 'CREATE') ? 1 : 0;
              $r = ($permission == 'READ') ? 1 : 0;
              $u = ($permission == 'UPDATE') ? 1 : 0;
              $d = ($permission == 'DELETE') ? 1 : 0;
            }
          }
        }
      }
   }

   public function updatePermisoByAccion(){
    //print_r($_POST);
    $hr = new Tools();

    if(isset($_POST)){
      switch($_POST["accionGeneral"]){
          case 'CREATE':
              $campo = 'Crear';
              $id = 'idCreate';
              break;
          case 'READ':
              $campo = 'Leer';
              $id = 'idRead';
              break;
          case 'UPDATE':
              $campo = 'Editar';
              $id = 'idUpdate';
              break;
          case 'DELETE':
              $campo = 'Eliminar';
              $id = 'idDelete';
              break;
          default:
              // asigna un valor predeterminado si es necesario
              break;
      }

    $dato =$hr->limpiarCadena($_POST['accion']);
    $idR = $hr->limpiarCadena($_POST[$id]);
    echo 'sql: '.$campo.' valor='.$dato.' idpermiso='.$idR;
    $sql = "UPDATE `permisos` SET `$campo` =:val WHERE `permisos`.`idPermiso` =:id";
    /**/
    try {
        $query = $this->connect()->prepare($sql);
        $query->execute(['val' => $dato,'id' => $idR]);
    } catch (PDOException $e) {
        echo $e->getMessage();
    } finally {
        $this->close();
    }

   }
  }

}
?>
