<?php

class UserSession{

    public function __construct(){
        session_start();
    }

    public function setCurrentUser($user){
        $_SESSION['user'] = $user;
    }

    public function setRol($rol){
      $_SESSION['rol'] = $rol;
    }

    public function getRol(){
      return $_SESSION['rol'];
    }

    public function setCurrentUserId($userId){
        $_SESSION['userId'] = $userId;
    }

    public function getCurrentUser(){
        return $_SESSION['user'];
    }

    public function getCurrentUserId(){
        return $_SESSION['userId'];
    }

    public function closeSession(){
        session_unset();
        session_destroy();
    }
}

?>
