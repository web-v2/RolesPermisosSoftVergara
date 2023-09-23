<?php
include_once 'db.php';
include_once 'Tools.php';
include_once 'user.php';

class Modulos extends db{
    private $id;
    private $modulo;

    public function newModulo(){
        $hr = new Tools();
        $nombre = $hr->limpiarCadena(strtoupper($_POST['nombres']));
        $descrpcion = $hr->limpiarCadena($_POST['descripcion']);
        $estado ="ACTIVO";
        if($this->moduloExist($nombre)){
          return false;
        }else{
          try{
            $query = $this->connect()->prepare("INSERT INTO `modulos` (`idModulo`, `titulo`, `descripcion`, `status`) VALUES (null, :t, :d, :e)");
            $query->execute(['t'=>$nombre, 'd'=>$descrpcion, 'e'=>$estado]);
            $this->close();
          }catch (PDOException $e){
            return false;
          }
          if($query->rowCount()){
              return true;
          }else{
              return false;
          }
        }
    }

    public function moduloExist($param){
      $query = $this->connect()->prepare('SELECT * FROM `modulos` WHERE titulo = :p');
      $query->execute(['p'=>$param]);
      $this->close();
      while($filas = $query->FETCHALL(PDO::FETCH_ASSOC)){
          return $this->modulo[]=$filas;
      }   return false;
  }

    public function getModulos(){
        $query = $this->connect()->prepare('SELECT * FROM `modulos`');
        $query->execute();
        $this->close();
        while($filas = $query->FETCHALL(PDO::FETCH_ASSOC)){
            return $this->modulo[]=$filas;
        }   return false;
    }

    public function getModuloActivo(){
      $query = $this->connect()->prepare('SELECT * FROM `modulos` WHERE status = "ACTIVO"');
      $query->execute();
      $this->close();
      while($filas = $query->FETCHALL(PDO::FETCH_ASSOC)){
          return $this->modulo[]=$filas;
      }   return false;
    }

    public function getModuloById($id){
        $hr = new Tools();
        $query = $this->connect()->prepare('SELECT * FROM `modulos` WHERE idModulo = :id');
        $query->execute(['id' => $hr->limpiarCadena($id)]);
        $this->close();
        while($filas = $query->FETCHALL(PDO::FETCH_ASSOC)){
            return $this->modulo[]=$filas;
        }   return false;
    }

  public function update(){
    //print_r($_POST);
      $hr = new Tools();
      $nombre = $hr->limpiarCadena(strtoupper($_POST['nombres']));
      $descrpcion = $hr->limpiarCadena($_POST['descripcion']);
      $estado = $hr->limpiarCadena($_POST['estado']);
      $id = $hr->limpiarCadena($_POST['idModulo']);

      $query = $this->connect()->prepare("UPDATE `modulos` SET `titulo` = :t, `descripcion` = :d, `status` = :s WHERE `modulos`.`idModulo` = :id");
      $query->execute(['t' => $nombre, 'd' => $descrpcion, 's' => $estado, 'id' => $id]);

      $this->close();
      if($query->rowCount()){
          return true;
      }else{
          return false;
      }
    }

    public function delete($id){
      $hr = new Tools();
      try{
          $stm = $this->connect()->prepare("DELETE FROM modulos WHERE idModulo = :id");
          $stm->execute(['id' => $hr->limpiarCadena($id)]);
          $this->close();
          echo '<script type="text/javascript">window.location="../Modulos";</script>';
      }catch (PDOException $e){
          return $sms = $e->getMessage();
      }
    }

    public function getModulo(){
        return $this->modulo;
    }

    public function getId(){
        return $this->id;
    }

}

?>
