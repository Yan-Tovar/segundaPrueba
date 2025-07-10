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
                    GROUP BY productos.id
                    ";
        $conexion->consulta($sql);
        $result = $conexion->obtenerResultado();
        $conexion->cerrar();
        return $result;
    }
    public function consultarProductosTotales($inicio, $cantidad){
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
                    GROUP BY productos.id
                    LIMIT $inicio, $cantidad";
        $conexion->consulta($sql);
        $result = $conexion->obtenerResultado();
        $conexion->cerrar();
        return $result;
    }
    public function filtrarBusqueda($busqueda, $inicio, $cantidad) {
        $conexion = new Conexion();
        $conexion->abrir();
        $busqueda = $conexion->obtenerConexion()->real_escape_string($busqueda);
        $like = "'%" . $busqueda . "%'";

        $sql = "SELECT productos.*, tipo.nombre AS tipo_nombre, categorias.nombre AS nombreCategoria,
                    GROUP_CONCAT(imagenes.nombre) AS imagenesProducto
                FROM productos
                LEFT JOIN imagenes ON productos.id = imagenes.id_producto
                LEFT JOIN tipo ON productos.tipo = tipo.id
                LEFT JOIN categorias ON productos.id_categoria = categorias.id
                WHERE productos.marca LIKE $like
                OR productos.modelo LIKE $like
                OR productos.especificaciones LIKE $like
                OR productos.precio LIKE $like
                OR tipo.nombre LIKE $like
                OR categorias.nombre LIKE $like
                GROUP BY productos.id
                LIMIT $inicio, $cantidad";

        $conexion->consulta($sql);
        $result = $conexion->obtenerResultado();
        $conexion->cerrar();
        return $result;
    }
    public function contarFiltrados($busqueda){
        $conexion = new Conexion();
        $conexion->abrir();
        $busqueda = $conexion->obtenerConexion()->real_escape_string($busqueda);
        $like = "'%" . $busqueda . "%'";
        $sql = "SELECT COUNT(*) AS total
                FROM productos
                LEFT JOIN tipo ON productos.tipo = tipo.id
                LEFT JOIN categorias ON productos.id_categoria = categorias.id
                WHERE productos.marca LIKE $like
                OR productos.modelo LIKE $like
                OR productos.especificaciones LIKE $like
                OR tipo.nombre LIKE $like
                OR categorias.nombre LIKE $like";
        $conexion->consulta($sql);
        $resultado = $conexion->obtenerResultado();
        $conexion->cerrar();
        if ($resultado && $fila = mysqli_fetch_assoc($resultado)) {
            return (int)$fila['total'];
        }
        return 0;
    }
    public function contarFiltradosTotales(){
        $conexion = new Conexion();
        $conexion->abrir();
        $sql = "SELECT COUNT(*) AS total
                FROM productos
                LEFT JOIN tipo ON productos.tipo = tipo.id
                LEFT JOIN categorias ON productos.id_categoria = categorias.id ";
        $conexion->consulta($sql);
        $resultado = $conexion->obtenerResultado();
        $conexion->cerrar();
        if ($resultado && $fila = mysqli_fetch_assoc($resultado)) {
            return (int)$fila['total'];
        }
        return 0;
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
    public function consultarCarritoId($id_Usu){
        $conexion = new Conexion();
        $conexion->abrir();
         $sql = "SELECT 
                    productos.*,
                    productos.id AS idProducto,
                    categorias.nombre AS nombreCategoria,
                    (SELECT SUM(carrito.cantidad) 
                        FROM carrito 
                        WHERE carrito.id_usuario = '$id_Usu' AND carrito.id_producto = productos.id
                    ) AS cantidad,
                    GROUP_CONCAT(DISTINCT imagenes.nombre) AS imagenesProducto
                FROM productos 
                JOIN categorias  ON productos.id_categoria = categorias.id
                LEFT JOIN imagenes  ON productos.id = imagenes.id_producto
                WHERE productos.id IN (
                    SELECT id_producto FROM carrito WHERE id_usuario = '$id_Usu'
                )
                GROUP BY productos.id";

        $conexion->consulta($sql);
        $result= $conexion->obtenerResultado();
        $conexion->cerrar();
        return $result;
    }
    public function contarCarritoId($id_Usu){
        $conexion = new Conexion();
        $conexion->abrir();
        $sql = "SELECT * FROM carrito WHERE id_usuario = '$id_Usu'";
        $conexion->consulta($sql);
        $result = $conexion->obtenerFilasAfectadas();
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
    public function ventasPorTipo(){
        $conexion = new Conexion();
        $conexion->abrir();
        $sql = "SELECT 
            p.id_producto,
            productos.marca AS nombre_producto,
            t.nombre AS tipo_nombre,
            SUM(p.cantidad) AS total_cantidad_pedida
        FROM pedidos p
        JOIN productos ON p.id_producto = productos.id
        JOIN tipo t ON productos.tipo = t.id
        GROUP BY p.id_producto, productos.marca, t.nombre
        ORDER BY total_cantidad_pedida DESC;
        ";
        $conexion->consulta($sql);
        $result = $conexion->obtenerResultado();
        $conexion->cerrar();
        return $result;
    }
    public function productosPorCategoria(){
        $conexion = new Conexion();
        $conexion->abrir();
        $sql = "SELECT count(productos.id) AS cantidad, categorias.nombre AS categoria_nombre FROM productos
        JOIN categorias ON productos.id_categoria = categorias.id
        GROUP BY productos.id_categoria";
        $conexion->consulta($sql);
        $result = $conexion->obtenerResultado();
        $conexion->cerrar();
        return $result;
    }
    public function clientesRegistrados(){
        $conexion = new Conexion();
        $conexion->abrir();
        $sql = "SELECT count(*) AS cantidad, rol FROM usuarios GROUP BY rol";
        $conexion->consulta($sql);
        $result = $conexion->obtenerResultado();
        $conexion->cerrar();
        return $result;
    }
    public function estadoPedidos(){
        $conexion = new Conexion();
        $conexion->abrir();
        $sql = "SELECT count(*) AS cantidad, estado FROM pedidos GROUP BY estado";
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
    // public function agregarPedido(Pedido $pedido ){
    //     $conexion = new Conexion();
    //     $conexion->abrir();
    //     $idU = $pedido->obtenerIdU();
    //     $idP = $pedido->obtenerId();
    //     $cantidad = $pedido->obtenerCantidad();
    //     $fecha = $pedido->obtenerFecha();
    //     for ($i = 0; $i < count($idP); $i++) {
    //         $idP = $productos[$i];
    //         $cantidad = $cantidades[$i];
    //         $sql = "INSERT INTO pedidos VALUES(null, '$idU', '$idP', '$cantidad', '$fecha', 'Solicitado')";
    //     }
    //     $conexion->consulta($sql);
    //     $result = $conexion->obtenerFilasAfectadas();
    //     $conexion->cerrar();
    //     return $result;
    // }
    public function agregarPedido(Pedido $pedido) {
        $conexion = new Conexion();
        $conexion->abrir();

        $idUsuario = $pedido->obtenerIdUsuario();
        $productos = $pedido->obtenerProductos();
        $cantidades = $pedido->obtenerCantidades();
        $fecha = $pedido->obtenerFecha();

        for ($i = 0; $i < count($productos); $i++) {
            $idProducto = $productos[$i];
            $cantidad = $cantidades[$i];

            $sql = "INSERT INTO pedidos VALUES (null, '$idUsuario', '$idProducto', '$cantidad', '$fecha', 'Solicitado')";
            $conexion->consulta($sql);
        }

        $conexion->consulta($sql);
        $result = $conexion->obtenerFilasAfectadas();
        $conexion->cerrar();
        return $result;
    }

     public function enviarCarrito($id, $cantidad , $id_usu){
        $conexion = new Conexion();
        $conexion->abrir();
        $sql = "INSERT INTO carrito VALUES(null, '$id_usu', '$id', '$cantidad')";
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
    public function cambiarEstadoP($id, $estado){
        $conexion = new Conexion();
        $conexion->abrir();
        $sql = "UPDATE pedidos SET estado = '$estado' WHERE id = '$id'";
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