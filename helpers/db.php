<?php
session_start();
date_default_timezone_set('America/Bogota');
class DB{
    private $host;
    private $db;
    private $user;
    private $password;
    private $charset;
    private $pdo;

    public function __construct(){
        $this->host     = 'localhost';
        $this->db       = 'lawyers_elmer';
        $this->user     = 'root';
        $this->password = "";
        $this->charset  = 'utf8mb4';
    } 

    /*
    public function __construct(){
        $this->host     = 'localhost';
        $this->db       = 'dproyecd4_impervega';
        $this->user     = 'dproyecd4_impervega_user';
        $this->password = "9QTDwDS2K%*O";
        $this->charset  = 'utf8mb4';
    } */

    public function __destruct(){
      $this->pdo = null;
  }

    public function connect(){
        try{

            $connection = "mysql:host=" . $this->host . ";dbname=" . $this->db . ";charset=" . $this->charset;
            $options = [
                PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_EMULATE_PREPARES   => false,
            ];
            $this->pdo = new PDO($connection, $this->user, $this->password, $options);

            return $this->pdo;

        }catch(PDOException $e){
            print_r('Error connection: ' . $e->getMessage());
        }
    }

    public function close(){
      $this->pdo = null;
    }
}
