<?php
session_start();
require_once "Controlador/Controlador.php";
require_once "Modelo/Conexion.php";
require_once "Modelo/GestorProductos.php";
require_once "Modelo/GestorUsuarios.php";
require_once "Modelo/Usuario.php";
require_once "Modelo/Producto.php";
require_once "Modelo/Pedido.php";
require_once "Modelo/Categoria.php";
require_once "Modelo/Imagen.php";
$controlador = new Controlador();

if (isset($_SESSION['id'])){
    $id_usu= $_SESSION['id'];
}
else{
    $id_usu=0;
}

if(isset($_GET['accion'])){
    if($_GET['accion'] == "loginUsuario"){
        $controlador->loginUsuario($_POST['correo'], $_POST['contrasena']);
    }elseif($_GET['accion'] == "listarProductos"){
        $controlador->listarProductos($id_usu);
    }elseif($_GET['accion'] == "solicitarProducto"){
        if($_POST['cantidad'] == null){
            $cantidad = 1;
            $controlador->solicitarProducto($_POST['id'],$cantidad, $id_usu);
        }else{
            $controlador->solicitarProducto($_POST['id'],$_POST['cantidad'], $id_usu);
        }
    }elseif($_GET['accion'] == "enviarCarrito"){
        if($_POST['cantidad'] == null){
            $cantidad = 1;
            $controlador->enviarCarrito($_POST['id'],$cantidad, $id_usu);
        }else{
            $controlador->enviarCarrito($_POST['id'],$_POST['cantidad'], $id_usu);
        }
    }elseif($_GET['accion'] == "verRegistrar"){
        $controlador->verPagina("Vista/html/formularioRegistro.php");
    }elseif($_GET['accion'] == "verLoginA"){
        $controlador->verPagina("Vista/html/loginAdministrador.php");
    }elseif($_GET['accion'] == "verLoginU"){
        $controlador->verPagina("Vista/html/loginUsuario.php");
    }elseif($_GET['accion'] == "verPanelA"){
        $controlador->verPanelA();
    }elseif($_GET['accion'] == "verEstadisticas"){
        $controlador->verEstadisticas();
    }elseif($_GET['accion'] == "verProductos"){
        $controlador->verProductos();
    }elseif($_GET['accion'] == "verCategorias"){
        $controlador->verCategorias();
    }elseif ($_GET['accion'] == "carrito"){
        $controlador->verCarrito($id_usu);
    }elseif($_GET['accion'] == "registrarUsuario"){
        $controlador->registrarUsuario($_POST['nombre'], $_POST['correo'], $_POST['contrasena']);
    }elseif($_GET['accion'] == "mostrarProducto"){
        $controlador->mostrarProducto($_GET['id']);
    }elseif ($_GET['accion'] == "editarProducto") {
        $controlador->editarProducto(
            $_POST['id'],
            $_POST['marca'],
            $_POST['modelo'],
            $_POST['tipo'],
            $_POST['especificaciones'],
            $_POST['precio'],
            $_POST['categoria']
        );
    }elseif($_GET['accion'] == "editarCategoria"){
        $controlador->editarCategoria($_POST['id'], $_POST['nombre']);
    }elseif ($_GET['accion'] == "agregarProducto") {
    if (isset($_FILES['imagen'])) {
        $nombresAleatorios = [];
        foreach ($_FILES['imagen']['tmp_name'] as $index => $tmpName) {
            if ($_FILES['imagen']['error'][$index] === UPLOAD_ERR_OK) {
                $nombreOriginal = $_FILES['imagen']['name'][$index];
                $extension = pathinfo($nombreOriginal, PATHINFO_EXTENSION);
                $nombreAleatorio = uniqid() . '.' . strtolower($extension);
                $rutaFinal = "imagenes/" . $nombreAleatorio;

                if (move_uploaded_file($tmpName, $rutaFinal)) {
                    $nombresAleatorios[] = $nombreAleatorio;
                }
            }
        }
        $controlador->agregarProducto(
            $_POST['marca'],
            $_POST['modelo'],
            $_POST['tipo'],
            $_POST['especificaciones'],
            $_POST['precio'],
            $nombresAleatorios,
            $_POST['categoria']
        );
    } else {
        // No se subió ninguna imagen
        $controlador->agregarProducto(
            $_POST['marca'],
            $_POST['modelo'],
            $_POST['tipo'],
            $_POST['especificaciones'],
            $_POST['precio'],
            [],
            $_POST['categoria']
        );
    }
    }elseif($_GET['accion'] == "agregarImagen"){
        $nombresAleatorios = [];
        foreach ($_FILES['imagen']['tmp_name'] as $index => $tmpName) {
            if ($_FILES['imagen']['error'][$index] === UPLOAD_ERR_OK) {
                $nombreOriginal = $_FILES['imagen']['name'][$index];
                $extension = pathinfo($nombreOriginal, PATHINFO_EXTENSION);
                $nombreAleatorio = uniqid() . '.' . strtolower($extension);
                $rutaFinal = "imagenes/" . $nombreAleatorio;

                if (move_uploaded_file($tmpName, $rutaFinal)) {
                    $nombresAleatorios[] = $nombreAleatorio;
                }
            }
        }
        $controlador->agregarImagenes($nombresAleatorios, $_POST['id']);
    }elseif($_GET['accion'] == "eliminarProducto"){
        $controlador->eliminarProducto($_GET['id']);
    }elseif($_GET['accion'] == "eliminarImagen"){
        $controlador->eliminarImagen($_GET['id']);
    }elseif($_GET['accion'] == "eliminarCategoria"){
        $controlador->eliminarCategoria($_GET['id']);
    }elseif($_GET['accion'] == "agregarCategoria"){
        $controlador->agregarCategoria( $_POST['nombre']);
    }elseif($_GET['accion'] == "filtrarBusqueda"){
        if(isset($_GET['busqueda'])){
            $controlador->filtrarBusqueda($_GET['busqueda']);
        }else{
            if($_POST['busqueda'] == null){
                $controlador->listarProductos($id_usu);
            }else{
                $controlador->filtrarBusqueda( $_POST['busqueda'],$id_usu);
            }
        }
    }elseif($_GET['accion'] == "mostrarCategoria"){
        $controlador->mostrarCategoria( $_GET['id']);
    }elseif($_GET['accion'] == "cambiarEstadoPedido"){
        $controlador->cambiarEstadoPedido( $_POST['id'], $_POST['estado']);
    }elseif($_GET['accion'] == "cerrarSesion"){
        session_unset();
        session_destroy();
        $controlador->listarProductos($id_usu);
    }elseif($_GET['accion'] == "compraPedido"){
        echo "<pre>";
        var_dump($_POST);
        echo "</pre>";
        $controlador->compraPedido(
            
            $_POST['idUsuario'], 
            $_POST['id_producto'], 
            $_POST['cantidad']
        );
    }
}else{
    $controlador->listarProductos($id_usu);
}
?>