<?php
date_default_timezone_set("America/Bogota");
session_start();
class Conectar{
	private $driver;
    private $host, $user, $pass, $base;
	private $db;
	
    public function __construct() {
        $db_cfg = require_once 'config.php';
        $this->driver=$db_cfg["driver"];
        $this->host=$db_cfg["host"];
        $this->usuario=$db_cfg["usuario"];
        $this->pass=$db_cfg["pass"];
        $this->base=$db_cfg["base"];
    }
	public function conexion(){
        if($this->driver=="mysql" || $this->driver==null){
            $this->db = new PDO('mysql:host='.$this->host.';dbname='.$this->base.'', $this->usuario, $this->pass);
        }
        return $this->db;
    }
	public function cerrar(){
        
        $this->db= NULL;
    }
	
}
?>