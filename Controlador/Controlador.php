<?php
class Controlador{
    public function verPagina($ruta){
        require_once $ruta;
    }
    public function listarProductos(){
        $gestor = new GestorProductos();
        $result = $gestor->consultarProductos();
        $categorias = $gestor->consultarCategorias();
        require_once "Vista/html/catalogo.php";
    }
    public function filtrarCategoria($idCategoria){
        $gestor = new GestorProductos();
        $result = $gestor->filtrarProductos($idCategoria);
        $categorias = $gestor->consultarCategorias();
        require_once "Vista/html/catalogo.php";
    }
    public function mostrarProducto($id){
        $gestor = new GestorProductos();
        $producto = $gestor->consultarProductosPorId($id);
        $categorias = $gestor->consultarCategorias();
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
    public function verProductos(){
        $gestor = new GestorProductos();
        $productos = $gestor->consultarProductos();
        $categorias = $gestor->consultarCategorias();
        require_once "Vista/html/verProductos.php";
    }
    public function verCategorias(){
        $gestor = new GestorProductos();
        $categorias = $gestor->consultarCategorias();
        require_once "Vista/html/verCategorias.php";
    }
    public function editarProducto($id, $nombre, $descripcion, $precio, $talla, $imagen, $categoria){
        $gestor = new GestorProductos();
        if($imagen != null){
            $imagenA = $gestor->consultarImagen($id);
            $imagePath = 'imagenes/' . $imagenA['imagen'];
            if (file_exists($imagePath)) {
                unlink($imagePath);
            }
            $result = $gestor->editarProducto($id, $nombre, $descripcion, $precio, $imagen, $categoria);
        }else{
            $result = $gestor->editarProducto($id, $nombre, $descripcion, $precio, $imagen, $categoria);
        }
        if($result > 0){
            $productos = $gestor->consultarProductos();
            $categorias = $gestor->consultarCategorias();
            require_once "Vista/html/verProductos.php";
        }else{
            echo "<script>alert('No se pudo editar el producto :(')</script>";
            $productos = $gestor->consultarProductos();
            $categorias = $gestor->consultarCategorias();
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
    public function agregarProducto($nombre, $descripcion, $precio, $talla, $imagen, $categoria){
        $producto = new Producto($nombre, $descripcion, $precio, $talla, $imagen, $categoria);
        $gestor = new GestorProductos();
        $result = $gestor->agregarProducto($producto);
        echo "<script>alert('El producto se agregó correctamente')</script>";
        $productos = $gestor->consultarProductos();
        $categorias = $gestor->consultarCategorias();
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
        $imagen = $gestor->consultarImagen($id);
        $imagePath = 'imagenes/' . $imagen['imagen'];
        if (file_exists($imagePath)) {
            unlink($imagePath);
        }
        $result = $gestor->eliminarProductoPorId($id);
        echo "<script>alert('El producto se eliminó correctamente')</script>";
        $productos = $gestor->consultarProductos();
        $categorias = $gestor->consultarCategorias();
        require_once "Vista/html/verProductos.php";
    }
    public function completarPedido($id){
        $gestor = new GestorProductos();
        $result = $gestor->completarPedido($id);
        echo "<script>alert('El pedido se completó correctamente correctamente')</script>";
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
}
?>