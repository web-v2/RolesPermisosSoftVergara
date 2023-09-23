<?php
include_once 'db.php';
include_once 'Tools.php';
class User extends db
{
  private $nombreUser;
  private $userName;
  private $userId;
  private $users;
  private $rol;

  public function userExists($user, $pass)
  {
    $hr = new Tools();
    $query = $this->connect()->prepare('SELECT * FROM uxer WHERE email = :user AND estadoUxer = :status');
    $stts = "ACTIVO";
    $query->execute(['user' => $hr->limpiarCadena($user), 'status' => $stts]);
    $result = $query->fetch(PDO::FETCH_OBJ);
    $passBD = $result->password;
    $rol = $result->id_rol;
    $this->close();
    if ($query->rowCount()) {
      if (Password::verify($passBD, $pass)) {
        $_SESSION['rol'] = $rol;
        return true;
      } else {
        return false;
      }
    } else {
      return false;
    }
  }

  public function newUser()
  {
    $hr = new Tools();
    $email = $hr->limpiarCadena(strtolower($_POST['correoUser']));
    $username = $hr->limpiarCadena($_POST['user']);
    $pass1 = $hr->limpiarCadena($_POST['cont1']);
    $pass2 = $hr->limpiarCadena($_POST['cont2']);
    $rol = $hr->limpiarCadena($_POST['rol']);
    $estado = "ACTIVO";

    if (!$this->getUserIdByEmail($email)) {
      if ($pass1 === $pass2) {
        $passFinal = Password::hash($pass1);
        $query = $this->connect()->prepare('INSERT INTO `uxer`(`idUxer`, `username`, `email`, `password`, `estadoUxer`, `id_rol`) VALUES (null, :user, :correo, :pass, :estado, :rol)');
        $query->execute(['user' => $username, 'correo' => $email, 'pass' => $passFinal, 'estado' => $estado, 'rol' => $rol]);
        $this->close();
        if ($query->rowCount()) {
          return true;
        } else {
          return false;
        }
      } else {
        return false;
      }
    } else {
      return false;
    }
  }

  public function reset_pass($user, $pass)
  {
    $hr = new Tools();
    $stts = "ACTIVO";
    $query = $this->connect()->prepare('SELECT * FROM uxer WHERE email = :user AND estadoUxer = :status');
    $query->execute(['user' => $hr->limpiarCadena($user), 'status' => $stts]);

    if ($query->rowCount()) {
      $result = $query->fetch(PDO::FETCH_OBJ);
      $passBD = $result->password;
      if (Password::verify($passBD, $pass)) {
        $id = $hr->limpiarCadena($_POST['idUs']);
        $pass1 = $hr->limpiarCadena($_POST['cont1']);
        $pass2 = $hr->limpiarCadena($_POST['cont2']);
        if ($pass1 === $pass2) {
          $passFinal = Password::hash($pass1);
          $query = $this->connect()->prepare('UPDATE `uxer` SET `password`=:ps WHERE `idUxer`=:id');
          $query->execute(['id' => $id, 'ps' => $passFinal]);
          $this->close();
          return true;
        }
      } else {
        return false;
      }
    } else {
      return false;
    }
  }

  public function reset_pass_token($tk, $ps)
  {
    //echo 'Ingreso al metodo';
    $hr = new Tools();
    $stts = "ACTIVO";
    $query = $this->connect()->prepare('SELECT u.*, pr.TOKENS FROM `password_resets` as pr, uxer as u WHERE pr.USER_SOLICITUD = u.email AND pr.TOKENS =:token AND u.estadoUxer =:status');
    $query->execute(['token' => $hr->limpiarCadena($tk), 'status' => $stts]);
    //echo 'Ejecuto la consulta del token/usuario';
    if ($query->rowCount()) {
      $result = $query->fetch(PDO::FETCH_OBJ);
      $id = $result->idUxer;
      $pass = $hr->limpiarCadena($ps);
      //echo 'Resultado Token/usuario satisfactorio';
      if ($pass) {
        $passFinal = Password::hash($pass);
        $query = $this->connect()->prepare('UPDATE `uxer` SET `password`=:ps WHERE `idUxer`=:id');
        $query->execute(['id' => $id, 'ps' => $passFinal]);
        //echo 'Pass cambiada';

        $this->inactivaToken($tk);
        $this->close();
        //echo 'Token inactivado';
        return true;
      }
    } else {
      return false;
    }
  }

  public function inactivaToken($id)
  {
    $r = $this->connect()->prepare('UPDATE `password_resets` SET `ESTADO_RESET` = "INACTIVO" WHERE `TOKENS` = :id');
    $r->execute(['id' => $id]);
    $this->close();
    return true;
  }

  public function setUser($user)
  {
    $hr = new Tools();
    $query = $this->connect()->prepare('SELECT * FROM uxer WHERE email = :user');
    $query->execute(['user' => $hr->limpiarCadena($user)]);
    $this->close();
    foreach ($query as $currentUser) {
      $this->nombreUser = $currentUser["username"];
      $this->userName = $currentUser["email"];
      $this->userId = $currentUser["idUxer"];
      $this->rol = $currentUser["id_rol"];
      //echo $this->userName;
      //exit;
    }
  }

  public function getUserIdBy($id)
  {
    $hr = new Tools();
    $query = $this->connect()->prepare('SELECT idUxer, username, email, estadoUxer, id_rol, fecha_create FROM uxer WHERE idUxer =:id');
    $query->execute(['id' => $hr->limpiarCadena($id)]);
    $this->close();
    while ($filas = $query->FETCHALL(PDO::FETCH_ASSOC)) {
      return $this->users[] = $filas;
    }
    return false;
  }

  public function getUserIdByEmailExist($email)
  {
    $hr = new Tools();
    $stts = "ACTIVO";
    $query = $this->connect()->prepare('SELECT idUxer FROM uxer WHERE email = :user AND estadoUxer = :status');
    $query->execute(['user' => $hr->limpiarCadena($email), 'status' => $stts]);
    $this->close();
    while ($filas = $query->fetch(PDO::FETCH_OBJ)) {
      return $this->users[] = $filas;
    }
    return false;
  }

  public function getAllUsers()
  { //Get All Usuarios
    $query = $this->connect()->prepare('SELECT u.`idUxer`,u.`username`,u.`email`,u.`estadoUxer`,u.`id_rol`,u.`fecha_create`, r.nombreRol rolNomobre FROM `uxer` u INNER JOIN roles r ON r.idRol=u.id_rol');
    $query->execute();
    $this->close();
    while ($filas = $query->FETCHALL(PDO::FETCH_ASSOC)) {
      return $this->users[] = $filas;
    }
    return false;
  }

  public function updateUser()
  {
    $hr = new Tools();
    $email =    $hr->limpiarCadena(strtolower($_POST['correoUser']));
    $username = $hr->limpiarCadena($_POST['user']);
    $rol =      $hr->limpiarCadena($_POST['rol']);
    $estado =   $hr->limpiarCadena($_POST['estado']);
    $id =       $hr->limpiarCadena($_POST['idUs']);
    try {
      $stm = $this->connect()->prepare("UPDATE `uxer` SET `username`=:user, `email`=:correo, `estadoUxer`=:estado, `id_rol`=:rol WHERE idUxer = :id");
      $stm->execute(['user' => $username, 'correo' => $email, 'estado' => $estado, 'rol' => $rol, 'id' => $id]);
      $this->close();
      return true;
    } catch (PDOException $e) {
      return false; //$e->getMessage();
    }
  }

  public function getUserIdByEmail($email)
  {
    $hr = new Tools();
    $correo = $hr->limpiarCadena($email);
    $query = $this->connect()->prepare('SELECT idUxer FROM uxer WHERE email = :user');
    $query->execute(['user' => $correo]);
    $this->close();
    while ($filas = $query->fetch(PDO::FETCH_OBJ)) {
      return $this->users[] = $filas;
    }
    return false;
  }

  public function getNombre()
  {
    return $this->nombreUser;
  }
  public function getUser()
  {
    return $this->userName;
  }

  public function getPermisosByIdRol($id_rol)
  {
    $hr = new Tools();
    $query = $this->connect()->prepare('SELECT R.idRol, R.nombreRol, P.idPermiso, P.Crear, P.Leer, P.Editar, P.Eliminar, M.titulo FROM roles AS R, permisos AS P, modulos AS M WHERE R.idRol = P.idRol AND P.idRol = R.idRol AND P.idModulo = M.idModulo AND M.idModulo = P.idModulo AND R.idRol = :id;');
    $query->execute(['id' => $hr->limpiarCadena($id_rol)]);
    $this->close();
    while ($filas = $query->FETCHALL(PDO::FETCH_ASSOC)) {
      return $this->users[] = $filas;
    }
    return false;
  }
  public function getUserId()
  {
    return $this->userId;
  }
  public function getUserIdRol()
  {
    return $this->rol;
  }
}
