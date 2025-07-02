<?php
class Producto{
    private $marca;
    private $modelo;
    private $tipo;
    private $especificaciones;
    private $precio;
    private $categoria;
    public function __construct($mar, $mod, $tip, $esp, $pre, $cat){
        $this->marca = $mar;
        $this->modelo = $mod;
        $this->tipo = $tip;
        $this->especificaciones = $esp;
        $this->precio = $pre;
        $this->categoria = $cat;
    }
    public function obtenerMarca(){
        return $this->marca;
    }
    public function obtenerModelo(){
        return $this->modelo;
    }
    public function obtenerTipo(){
        return $this->tipo;
    }
    public function obtenerEspecificaciones(){
        return $this->especificaciones;
    }
    public function obtenerPrecio(){
        return $this->precio;
    }
    public function obtenerCategoria(){
        return $this->categoria;
    }
}
?>