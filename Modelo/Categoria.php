<?php
class Categoria{
    private $nombre;
    public function __construct($nom){
        $this->nombre = $nom;
    }
    public function obtenerNombre(){
        return $this->nombre;
    }
}
?>