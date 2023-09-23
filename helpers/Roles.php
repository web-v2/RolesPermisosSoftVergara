<?php
include_once 'db.php';
include_once 'Tools.php';
include_once 'user.php';

class Roles extends db{
    private $id;
    private $roles;

    public function newRol(){
        $hr = new Tools();
        $rol = $hr->limpiarCadena($_POST['rolNombre']);
        if(!$this->getRolByNombre($rol)){
          $query = $this->connect()->prepare("INSERT INTO `roles`(`idRol`, `nombreRol`) VALUES (null, :nom)");
          $query->execute(['nom' => $rol]);
          $this->close();
          if($query->rowCount()){
              return true;
          }else{
              return false;
          }
        } return false;
    }

    public function getAllRoles(){ //Get Todos los Roles
        $query = $this->connect()->prepare('SELECT * FROM roles;');
        $query->execute();
        $this->close();
        while($filas = $query->FETCHALL(PDO::FETCH_ASSOC)){
            return $this->roles[]=$filas;
        }   return false;
    }

    public function getRolById($id){ //Get Rol por id.
        $hr = new Tools();
        $query = $this->connect()->prepare('SELECT * FROM roles WHERE idRol=:id');
        $query->execute(['id' => $hr->limpiarCadena($id)]);
        $this->close();
        while($filas = $query->FETCHALL(PDO::FETCH_ASSOC)){
            return $this->roles[]=$filas;
        }   return false;
    }

    public function getRolByNombre($n){ //Get Rol por Nombre.
      $hr = new Tools();
      $query = $this->connect()->prepare('SELECT * FROM roles WHERE nombreRol=:n');
      $query->execute(['n' => $hr->limpiarCadena($n)]);
      $this->close();
      while($filas = $query->FETCHALL(PDO::FETCH_ASSOC)){
          return $this->roles[]=$filas;
      }   return false;
    }

    public function updateRol($id){
      $hr = new Tools();
      $nombre = $hr->limpiarCadena($_POST['rolNombre']);
      $query = $this->connect()->prepare("UPDATE `roles` SET `nombreRol` = :n WHERE `roles`.`idRol` = :id");
      $query->execute(['n' => $nombre, 'id' => $hr->limpiarCadena($id)]);
      $this->close();
      if($query->rowCount()){
          return true;
      }else{
          return false;
      }
    }

    public function deleteRol($id){
      $hr = new Tools();
      try {
        $query = $this->connect()->prepare("DELETE FROM `roles` WHERE `idRol` = :id");
        $query->execute(['id' => $hr->limpiarCadena($id)]);
        $this->close();
        echo '<script type="text/javascript">window.location="../Roles";</script>';
      } catch (PDOException $e) {
        return $sms = $e->getMessage();
      }
    }

    public function getModulos(){
      $query = $this->connect()->prepare('SELECT * FROM modulos WHERE `status` = :a');
      $query->execute(['a' =>'ACTIVO']);
      $this->close();
      while($filas = $query->FETCHALL(PDO::FETCH_ASSOC)){
          return $this->roles[]=$filas;
      }   return false;
    }

    public function addModulos_rol(){
      $hr = new Tools();
      $idRol = $hr->limpiarCadena($_POST['idR']);
      $checkbox = $_POST['my-checkbox'];
      $cant = $_POST['cant'];
      for ($i=0; $i < $cant; $i++) {
        if(isset($checkbox[$i])){
          $query = $this->connect()->prepare("INSERT INTO `permisos`(`idPermiso`, `idRol`,`idModulo`,`Crear`,`Leer`,`Editar`,`Eliminar`) VALUES (null, :r, :m, :c, :l, :e, :d)");
          $query->execute(['r' => $idRol, 'm' => $i+1,'c' => 0,'e' => 0,'l' => 1,'d' => 0]);
        }
      }
      $this->close();
      if($query->rowCount()){
        return true;
      }else{
        return false;
      }
    }

    public function getModulos_rol($i){
      $hr = new Tools();
      $query = $this->connect()->prepare('SELECT * FROM permisos WHERE idRol=:n');
      $query->execute(['n' => $hr->limpiarCadena($i)]);
      $this->close();
      while($filas = $query->FETCHALL(PDO::FETCH_ASSOC)){
          return $this->roles[]=$filas;
      }   return false;
    }

    public function getModulos_permisosByIdRol($rol){
      $query = $this->connect()->prepare('SELECT P.idPermiso, P.idModulo AS idboton, P.idRol, M.* FROM `permisos` AS P RIGHT JOIN modulos as M ON P.idModulo = M.idModulo AND M.status =:s AND P.idRol =:i;');
      $query->execute(['s' =>'ACTIVO','i'=>$rol]);
      $this->close();
      while($filas = $query->FETCHALL(PDO::FETCH_ASSOC)){
          return $this->roles[]=$filas;
      }   return false;
    }

    public function getId(){
        return $this->id;
    }

    public function addModulo_rol(){

      $hr = new Tools();
      $idP = $hr->limpiarCadena($_POST['idPermiso']);
      $mod = $hr->limpiarCadena($_POST['modulo']);
      $idR = $hr->limpiarCadena($_POST['rol']);

      if(isset($_POST)){
        switch($_POST["accionGeneral"]){
            case 'CREATE':
                $sql = "INSERT INTO `permisos` (`idPermiso`, `idRol`, `idModulo`, `Crear`, `Leer`, `Editar`, `Eliminar`) VALUES (NULL, :rol, ".$mod.", '0', 1, '0', '0');";
                try {
                    $query = $this->connect()->prepare($sql);
                    $query->execute(['rol' => $idR]);
                } catch (PDOException $e) {
                    echo $e->getMessage();
                } finally {
                    $this->close();
                }
                break;
            case 'DELETE':
              echo $idR.' - '.$idP;
                $sql = "DELETE FROM permisos WHERE `idPermiso` =:perm ";
                try {
                    $query = $this->connect()->prepare($sql);
                    $query->execute(['perm' => $idP]);
                } catch (PDOException $e) {
                    echo $e->getMessage();
                } finally {
                    $this->close();
                }
                break;
                default:
                // asigna un valor predeterminado si es necesario
                break;
        }
      }
      /**/
      try {
        echo $idP;
          $query = $this->connect()->prepare($sql);
          $query->execute(['rol' => $idR, 'permiso' => $idP]);
      } catch (PDOException $e) {
          echo $e->getMessage();
      } finally {
          $this->close();
      }
    }

}

?>
