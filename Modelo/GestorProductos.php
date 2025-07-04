<?php
class GestorProductos{
    public function consultarProductos(){
        $conexion = new Conexion();
        $conexion->abrir();
        $sql = "SELECT  productos.*,
                        categorias.nombre AS nombreCategoria,
                        tipo.nombre AS nombreTipo,
                        GROUP_CONCAT(imagenes.nombre) AS imagenesProducto
                    FROM productos
                    JOIN tipo ON productos.tipo = tipo.id
                    JOIN categorias ON productos.id_categoria = categorias.id
                    LEFT JOIN imagenes ON productos.id = imagenes.id_producto
                    GROUP BY productos.id;
                    ";
        $conexion->consulta($sql);
        $result = $conexion->obtenerResultado();
        $conexion->cerrar();
        return $result;
    }
    public function filtrarProductos($idCategoria){
        $conexion = new Conexion();
        $conexion->abrir();
        $sql = "SELECT productos.*, categorias.nombre AS nombreCategoria FROM productos
        JOIN categorias ON productos.id_categoria = categorias.id 
        WHERE productos.id_categoria = '$idCategoria'";
        $conexion->consulta($sql);
        $result = $conexion->obtenerResultado();
        $conexion->cerrar();
        return $result;
    }
    public function consultarPedidos(){
        $conexion = new Conexion();
        $conexion->abrir();
        $sql = "SELECT pedidos.*, usuarios.nombre AS cliente, productos.modelo AS producto FROM pedidos
        JOIN usuarios ON pedidos.id_usuario = usuarios.id
        JOIN productos ON pedidos.id_producto = productos.id";
        $conexion->consulta($sql);
        $result = $conexion->obtenerResultado();
        $conexion->cerrar();
        return $result;
    }
    public function consultarCategoriaF($id){
        $conexion = new Conexion();
        $conexion->abrir();
        $sql = "SELECT productos.id_categoria FROM productos WHERE id_categoria = '$id'";
        $conexion->consulta($sql);
        $result = $conexion->obtenerUnaFila();
        $conexion->cerrar();
        return $result;
    }
    public function consultarImagenes($id){
        $conexion = new Conexion();
        $conexion->abrir();
        $sql = "SELECT * FROM imagenes WHERE id_producto = '$id'";
        $conexion->consulta($sql);
        $result = $conexion->obtenerResultado();
        $conexion->cerrar();
        return $result;
    }
    public function consultarCategorias(){
        $conexion = new Conexion();
        $conexion->abrir();
        $sql = "SELECT * FROM categorias";
        $conexion->consulta($sql);
        $result = $conexion->obtenerResultado();
        $conexion->cerrar();
        return $result;
    }
    public function consultarTipos(){
        $conexion = new Conexion();
        $conexion->abrir();
        $sql = "SELECT * FROM tipo";
        $conexion->consulta($sql);
        $result = $conexion->obtenerResultado();
        $conexion->cerrar();
        return $result;
    }
    public function consultarProductosPorId($id){
        $conexion = new Conexion();
        $conexion->abrir();
        $sql = "SELECT productos.*, categorias.nombre AS nombreCategoria, tipo.nombre AS nombreTipo FROM productos
        JOIN tipo ON productos.tipo = tipo.id
        JOIN categorias ON productos.id_categoria = categorias.id WHERE productos.id = '$id'";
        $conexion->consulta($sql);
        $producto = $conexion->obtenerResultado();
        $conexion->cerrar();
        return $producto;
    }
    public function consultarCategoriasPorId($id){
        $conexion = new Conexion();
        $conexion->abrir();
        $sql = "SELECT * FROM categorias WHERE id = '$id'";
        $conexion->consulta($sql);
        $producto = $conexion->obtenerResultado();
        $conexion->cerrar();
        return $producto;
    }
    public function consultarImagen($id){
        $conexion = new Conexion();
        $conexion->abrir();
        $sql = "SELECT nombre FROM imagenes WHERE id = '$id'";
        $conexion->consulta($sql);
        $result = $conexion->obtenerUnaFila();
        $conexion->cerrar();
        return $result;
    }
    public function eliminarImagen($id){
        $conexion = new Conexion();
        $conexion->abrir();
        $sql = "DELETE FROM imagenes WHERE id = '$id'";
        $conexion->consulta($sql);
        $result = $conexion->obtenerFilasAfectadas();
        $conexion->cerrar();
        return $result;
    }
    public function aniadirPedido(){
        $conexion = new Conexion();
        $conexion->abrir();
        $sql = "SELECT productos.*, categorias.nombre AS nombreCategoria FROM productos
        JOIN categorias ON productos.id_categoria = categorias.id";
        $conexion->consulta($sql);
        $result = $conexion->obtenerResultado();
        $conexion->cerrar();
        return $result;
    }
    public function agregarPedido(Pedido $pedido ){
        $conexion = new Conexion();
        $conexion->abrir();
        $idU = $pedido->obtenerIdU();
        $idP = $pedido->obtenerId();
        $cantidad = $pedido->obtenerCantidad();
        $fecha = $pedido->obtenerFecha();
        $sql = "INSERT INTO pedidos VALUES(null, '$idU', '$idP', '$cantidad', '$fecha', 'Solicitado')";
        $conexion->consulta($sql);
        $result = $conexion->obtenerFilasAfectadas();
        $conexion->cerrar();
        return $result;
    }
    public function editarProducto($id, $marca, $modelo, $tipo, $especificaciones, $precio, $categoria){
        $conexion = new Conexion();
        $conexion->abrir();
        $sql = "UPDATE productos SET marca = '$marca', modelo = '$modelo', tipo= '$tipo', especificaciones= '$especificaciones', precio= '$precio', id_categoria= '$categoria'
        WHERE id = '$id'";
        $conexion->consulta($sql);
        $result = $conexion->obtenerFilasAfectadas();
        $conexion->cerrar();
        return $result;
    }
    public function editarCategoria($id, $nombre){
        $conexion = new Conexion();
        $conexion->abrir();
        $sql = "UPDATE categorias SET nombre ='$nombre' WHERE id = '$id'";
        $conexion->consulta($sql);
        $result = $conexion->obtenerFilasAfectadas();
        $conexion->cerrar();
        return $result;
    }
    public function completarPedido($id){
        $conexion = new Conexion();
        $conexion->abrir();
        $sql = "UPDATE pedidos SET estado = 'Completado' WHERE id = '$id'";
        $conexion->consulta($sql);
        $result = $conexion->obtenerFilasAfectadas();
        $conexion->cerrar();
        return $result;
    }
    public function eliminarProductoPorId($id){
        $conexion = new Conexion();
        $conexion->abrir();
        $sql = "DELETE FROM productos WHERE id = '$id'";
        $conexion->consulta($sql);
        $result = $conexion->obtenerFilasAfectadas();
        $conexion->cerrar();
        return $result;
    }
    public function eliminarCategoriaPorId($id){
        $conexion = new Conexion();
        $conexion->abrir();
        $sql = "DELETE FROM categorias WHERE id = '$id'";
        $conexion->consulta($sql);
        $result = $conexion->obtenerFilasAfectadas();
        $conexion->cerrar();
        return $result;
    }
    public function agregarProducto(Producto $producto ){
        $conexion = new Conexion();
        $conexion->abrir();
        $marca = $producto->obtenerMarca();
        $modelo = $producto->obtenerModelo();
        $tipo = $producto->obtenerTipo();
        $especificaciones = $producto->obtenerEspecificaciones();
        $precio = $producto->obtenerPrecio();
        $categoria = $producto->obtenerCategoria();
        $sql = "INSERT INTO productos VALUES(null, '$marca', '$modelo', '$tipo', '$especificaciones', '$precio', '$categoria')";
        $conexion->consulta($sql);
        $result = $conexion->obtenerId();
        $conexion->cerrar();
        return $result;
    }
    public function agregarImagenes(array $imagenes) {
        $conexion = new Conexion();
        $conexion->abrir();
        $resultados = 0;
        foreach ($imagenes as $imagen) {
            $nombre = $imagen->obtenerNombre();
            $idProducto = $imagen->obtenerIdProducto();
            $idProducto = intval($idProducto);
            $sql = "INSERT INTO imagenes VALUES (null, '$nombre', $idProducto)";
            $conexion->consulta($sql);
            $resultados += $conexion->obtenerFilasAfectadas();
        }
        $conexion->cerrar();
        return $resultados;
    }
    public function agregarCategoria(Categoria $categoria ){
        $conexion = new Conexion();
        $conexion->abrir();
        $nombre = $categoria->obtenerNombre();
        $sql = "INSERT INTO categorias VALUES(null, '$nombre')";
        $conexion->consulta($sql);
        $result = $conexion->obtenerFilasAfectadas();
        $conexion->cerrar();
        return $result;
    }
}
?>