<?php
    class database{
        private $host = "localhost";
        private $usuario = "root";
        private $contrasenia = "";
        private $nombreDeLaBaseDeDatos = "eventos";

        public function obtenerConexion(){
            $conexion  = new PDO("mysql:host=$this->host;dbname=$this->nombreDeLaBaseDeDatos;charset=utf8;",$this->usuario, $this->contrasenia);
            $conexion->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
            return $conexion;
        }
    }