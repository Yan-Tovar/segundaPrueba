<?php
class Producto{
    private $nombre;
    private $descripcion;
    private $precio;
    private $talla;
    private $imagen;
    private $categoria;
    public function __construct($nom, $des, $pre, $tal, $ima, $cat){
        $this->nombre = $nom;
        $this->descripcion = $des;
        $this->precio = $pre;
        $this->talla = $tal;
        $this->imagen = $ima;
        $this->categoria = $cat;
    }
    public function obtenerNombre(){
        return $this->nombre;
    }
    public function obtenerDescripcion(){
        return $this->descripcion;
    }
    public function obtenerPrecio(){
        return $this->precio;
    }
    public function obtenerTalla(){
        return $this->talla;
    }
    public function obtenerImagen(){
        return $this->imagen;
    }
    public function obtenerCategoria(){
        return $this->categoria;
    }
}
?>