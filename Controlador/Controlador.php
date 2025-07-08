<?php
class Controlador{
    public function verPagina($ruta){
        require_once $ruta;
    }
    public function listarProductos(){
        $paginaActual = isset($_GET['pagina']) ? (int)$_GET['pagina'] : 1;
        $porPagina = isset($_GET['cantidad']) ? (int)$_GET['cantidad'] : 6;
        $inicio = ($paginaActual - 1) * $porPagina;
        $gestor = new GestorProductos();
        $result = $gestor->consultarProductosTotales($inicio, $porPagina);
        $totalResultados = $gestor->contarFiltradosTotales();
        require_once "Vista/html/catalogo.php";
    }
    public function filtrarBusqueda($busqueda) {
        $paginaActual = isset($_GET['pagina']) ? (int)$_GET['pagina'] : 1;
        $porPagina = isset($_GET['cantidad']) ? (int)$_GET['cantidad'] : 6;
        $inicio = ($paginaActual - 1) * $porPagina;
        $gestor = new GestorProductos();
        $result = $gestor->filtrarBusqueda($busqueda, $inicio, $porPagina);
        $totalResultados = $gestor->contarFiltrados($busqueda);
        require_once "Vista/html/catalogo.php";
    }
    public function mostrarProducto($id){
        $gestor = new GestorProductos();
        $producto = $gestor->consultarProductosPorId($id);
        $categorias = $gestor->consultarCategorias();
        $tipos = $gestor->consultarTipos();
        $imagenes = $gestor->consultarImagenes($id);
        require_once "Vista/html/editarProducto.php";
    }
    public function mostrarCategoria($id){
        $gestor = new GestorProductos();
        $categoria = $gestor->consultarCategoriasPorId($id);
        require_once "Vista/html/editarCategoria.php";
    }
    public function verPanelA(){
        $gestor = new GestorProductos();
        $pedidos = $gestor->consultarPedidos();
        require_once "Vista/html/panelAdministrador.php";
    }
    public function verEstadisticas(){
        $gestor = new GestorProductos();
        $ventasTipo = $gestor->ventasPorTipo();
        $productosCategoria = $gestor->productosPorCategoria();
        $clientesRegistrados = $gestor->ClientesRegistrados();
        $estadoPedidos = $gestor->estadoPedidos();
        require_once "Vista/html/estadisticas.php";
    }
    public function verProductos(){
        $gestor = new GestorProductos();
        $productos = $gestor->consultarProductos();
        $categorias = $gestor->consultarCategorias();
        $tipos = $gestor->consultarTipos();
        require_once "Vista/html/verProductos.php";
    }
    public function verCategorias(){
        $gestor = new GestorProductos();
        $categorias = $gestor->consultarCategorias();
        require_once "Vista/html/verCategorias.php";
    }
    public function editarProducto($id, $marca, $modelo, $tipo, $especificaciones, $precio, $categoria){
        $gestor = new GestorProductos();
        $result = $gestor->editarProducto($id, $marca, $modelo, $tipo, $especificaciones, $precio, $categoria);
        if($result > 0){
            $productos = $gestor->consultarProductos();
            $categorias = $gestor->consultarCategorias();
            $tipos = $gestor->consultarTipos();
            require_once "Vista/html/verProductos.php";
        }else{
            echo "<script>alert('No se pudo editar el producto :(')</script>";
            $productos = $gestor->consultarProductos();
            $categorias = $gestor->consultarCategorias();
            $tipos = $gestor->consultarTipos();
            require_once "Vista/html/verProductos.php";
        } 
    }
    public function editarCategoria($id, $nombre){
        $gestor = new GestorProductos();
        $result = $gestor->editarCategoria($id, $nombre);
        if($result > 0){
            $categorias = $gestor->consultarCategorias();
            require_once "Vista/html/verCategorias.php";
        }else{
            echo "<script>alert('No se pudo editar el producto :(')</script>";
            $categorias = $gestor->consultarCategorias();
            require_once "Vista/html/verCategorias.php";
        } 
    }
    public function solicitarProducto($id, $cantidad){
        $idUsuario = $_SESSION['id'];
        $fecha = date("Y-m-d");
        $pedido = new Pedido($idUsuario, $id, $cantidad, $fecha);
        $gestor = new GestorProductos();
        $result = $gestor->agregarPedido($pedido);
        echo "<script>alert('El pedido se agregó correctamente')</script>";
        $result = $gestor->consultarProductos();
        $categorias = $gestor->consultarCategorias();
        require_once "Vista/html/catalogo.php";
    }
    public function loginUsuario($correo, $contrasena){
        $gestor = new GestorUsuarios();
        $validarContrasena = $gestor->validarContrasena($correo);
        if($validarContrasena != null){
            if(password_verify($contrasena, $validarContrasena['contraseña'])){
                $result = $gestor->consultarUsuario($correo);
                $_SESSION['id'] = $result['id'];
                $_SESSION['rol'] = $result['rol'];
                if($_SESSION['rol'] == "admin"){
                    $gestor = new GestorProductos();
                    $pedidos = $gestor->consultarPedidos();
                    require_once "Vista/html/panelAdministrador.php";
                }else{
                    $gestor = new GestorProductos();
                    $result = $gestor->consultarProductos();
                    $categorias = $gestor->consultarCategorias();
                    require_once "Vista/html/catalogo.php";
                }
            }else{
                echo "<script>alert('La contraseña es incorrecta :(')</script>";
                require_once "Vista/html/loginUsuario.php";
            }
        }else{
            echo "<script>alert('El usuario no esta registrado :(')</script>";
            require_once "Vista/html/loginUsuario.php";
        }
        
        
    }
    public function registrarUsuario($nombre, $correo, $contrasena){
        $usuario = new Usuario($nombre, $correo, $contrasena);
        $gestor = new GestorUsuarios();
        $validar = $gestor->validarCorreo($correo);
        if($validar > 0){
            echo "<script>alert('El usuario con este correo ya está registrado. Cambialo')</script>";
            require_once "Vista/html/formularioRegistro.php";
        }else{
            $result = $gestor->agregarUsuario($usuario);
            echo "<script>alert('El usuario se agregó correctamente')</script>";
            require_once "Vista/html/loginUsuario.php";
        }
    }
   public function agregarProducto($marca, $modelo, $tipo, $especificaciones, $precio, $imagenes, $categoria) {
    $producto = new Producto($marca, $modelo, $tipo, $especificaciones, $precio, $categoria);
    $gestor = new GestorProductos();
    $id = $gestor->agregarProducto($producto);
    $imagenesObj = [];
    if (is_array($imagenes) && !empty($imagenes)) {
        foreach ($imagenes as $nombreImagen) {
            $rutaImagen = "imagenes/" . $nombreImagen;
            $imagenesObj[] = new Imagen($rutaImagen, $id);
        }
        $resultadoImg = $gestor->agregarImagenes($imagenesObj);
    }
    echo "<script>alert('El producto se agregó correctamente')</script>";
    $productos = $gestor->consultarProductos();
    $categorias = $gestor->consultarCategorias();
    $tipos = $gestor->consultarTipos();
    require_once "Vista/html/verProductos.php";
    }
    public function agregarImagenes($imagenes, $idP) {
    $gestor = new GestorProductos();
    $imagenesObj = [];
    if (is_array($imagenes) && !empty($imagenes)) {
        foreach ($imagenes as $nombreImagen) {
            $rutaImagen = "imagenes/" . $nombreImagen;
            $imagenesObj[] = new Imagen($rutaImagen, $idP);
        }
        $resultadoImg = $gestor->agregarImagenes($imagenesObj);
    }
    echo "<script>alert('se agregó correctamente')</script>";
    $productos = $gestor->consultarProductos();
    $categorias = $gestor->consultarCategorias();
    $tipos = $gestor->consultarTipos();
    require_once "Vista/html/verProductos.php";
    }
    public function agregarCategoria($nombre){
        $categoria = new Categoria($nombre);
        $gestor = new GestorProductos();
        $result = $gestor->agregarCategoria($categoria);
        echo "<script>alert('La categoria se agregó correctamente')</script>";
        $categorias = $gestor->consultarCategorias();
        require_once "Vista/html/verCategorias.php";
    }
    public function eliminarProducto($id){
        $gestor = new GestorProductos();
        $result = $gestor->eliminarProductoPorId($id);
        echo "<script>alert('El producto se eliminó correctamente')</script>";
        $productos = $gestor->consultarProductos();
        $categorias = $gestor->consultarCategorias();
        require_once "Vista/html/verProductos.php";
    }
    public function cambiarEstadoPedido($id, $estado){
        $gestor = new GestorProductos();
        $result = $gestor->cambiarEstadoP($id, $estado);
        echo "<script>alert('El pedido se actualizó correctamente correctamente')</script>";
        $pedidos = $gestor->consultarPedidos();
        require_once "Vista/html/panelAdministrador.php";
    }
    public function eliminarCategoria($id){
        $gestor = new GestorProductos();
        $validarCategorias = $gestor->consultarCategoriaF($id);
        if($validarCategorias > 0){
            echo "<script>alert('La categoria no se puede eliminar Porque tiene productos asosiados')</script>";
           $categorias = $gestor->consultarCategorias();
            require_once "Vista/html/verCategorias.php";
        }else{
            $result = $gestor->eliminarCategoriaPorId($id);
            echo "<script>alert('La categoria se eliminó correctamente')</script>";
            $categorias = $gestor->consultarCategorias();
            require_once "Vista/html/verCategorias.php";
        }
        
    }
    public function eliminarImagen($id){
        $gestor = new GestorProductos();
        $imagenA = $gestor->consultarImagen($id);
        $imagePath = $imagenA['nombre'];
        if (file_exists($imagePath)) {
            unlink($imagePath);
        }
        $imagenA = $gestor->eliminarImagen($id);
        echo "<script>alert('Se eliminó la imagen con Exito')</script>";
        $productos = $gestor->consultarProductos();
        $categorias = $gestor->consultarCategorias();
        $tipos = $gestor->consultarTipos();
        require_once "Vista/html/verProductos.php";
    }
}
?>