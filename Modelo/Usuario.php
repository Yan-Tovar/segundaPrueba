<?php
class Usuario{
    private $nombre;
    private $correo;
    private $contrasena;
    public function __construct($name, $email, $password){
        $this->nombre = $name;
        $this->correo = $email;
        $this->contrasena = $password;
    }
    public function obtenerNombre(){
        return $this->nombre;
    }
    public function obtenerCorreo(){
        return $this->correo;
    }
    public function obtenerContrasena(){
        return $this->contrasena;
    }
}
?>