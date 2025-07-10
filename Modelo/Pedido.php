<?php
class Pedido {
    private $idUsuario;
    private $productos;    // array de IDs de productos
    private $cantidades;   // array de cantidades
    private $fecha;

    public function __construct($idUsuario, $productos, $cantidades, $fecha) {
        $this->idUsuario = $idUsuario;
        $this->productos = $productos;
        $this->cantidades = $cantidades;
        $this->fecha = $fecha;
    }

    public function obtenerIdUsuario() {
        return $this->idUsuario;
    }

    public function obtenerProductos() {
        return $this->productos;
    }

    public function obtenerCantidades() {
        return $this->cantidades;
    }

    public function obtenerFecha() {
        return $this->fecha;
    }
}
?>