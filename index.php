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

if(isset($_GET['accion'])){
    if($_GET['accion'] == "loginUsuario"){
        $controlador->loginUsuario($_POST['correo'], $_POST['contrasena']);
    }elseif($_GET['accion'] == "listarProductos"){
        $controlador->listarProductos();
    }elseif($_GET['accion'] == "solicitarProducto"){
        if($_POST['cantidad'] == null){
            $cantidad = 1;
            $controlador->solicitarProducto($_POST['id'],$cantidad);
        }else{
            $controlador->solicitarProducto($_POST['id'],$_POST['cantidad']);
        }
    }elseif($_GET['accion'] == "verRegistrar"){
        $controlador->verPagina("Vista/html/formularioRegistro.php");
    }elseif($_GET['accion'] == "verLoginA"){
        $controlador->verPagina("Vista/html/loginAdministrador.php");
    }elseif($_GET['accion'] == "verLoginU"){
        $controlador->verPagina("Vista/html/loginUsuario.php");
    }elseif($_GET['accion'] == "verPanelA"){
        $controlador->verPanelA();
    }elseif($_GET['accion'] == "verProductos"){
        $controlador->verProductos();
    }elseif($_GET['accion'] == "verCategorias"){
        $controlador->verCategorias();
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
    }elseif($_GET['accion'] == "filtrarCategoria"){
        if($_POST['categoria'] == 'x'){
            $controlador->listarProductos();
        }else{
            $controlador->filtrarCategoria( $_POST['categoria']);
        }
    }elseif($_GET['accion'] == "mostrarCategoria"){
        $controlador->mostrarCategoria( $_GET['id']);
    }elseif($_GET['accion'] == "completarPedido"){
        $controlador->completarPedido( $_GET['id']);
    }elseif($_GET['accion'] == "cerrarSesion"){
        session_unset();
        session_destroy();
        $controlador->listarProductos();
    }
}else{
    $controlador->listarProductos();
}
?>