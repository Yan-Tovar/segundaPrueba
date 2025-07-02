<?php
class Imagen{
    private $nombre;
    private $idProducto;
    public function __construct($name, $idP){
        $this->nombre = $name;
        $this->idProducto = $idP;
    }
    public function obtenerNombre(){
        return $this->nombre;
    }
    public function obtenerIdProducto(){
        return $this->idProducto;
    }
}
?>