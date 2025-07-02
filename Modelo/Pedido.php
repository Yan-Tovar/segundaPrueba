<?php
class Pedido{
    private $idUsuario;
    private $id;
    private $cantidad;
    private $fecha;
    public function __construct($idU, $id, $canti, $fech){
        $this->idUsuario = $idU;
        $this->id = $id;
        $this->cantidad = $canti;
        $this->fecha = $fech;
    }
    public function obtenerIdU(){
        return $this->idUsuario;
    }
    public function obtenerId(){
        return $this->id;
    }
    public function obtenerCantidad(){
        return $this->cantidad;
    }
    public function obtenerFecha(){
        return $this->fecha;
    }
}
?>