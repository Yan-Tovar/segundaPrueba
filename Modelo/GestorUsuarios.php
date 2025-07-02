<?php
class GestorUsuarios{
    public function consultarUsuario($correo){
        $conexion = new Conexion();
        $conexion->abrir();
        $sql = "SELECT * FROM usuarios WHERE correo = '$correo'";
        $conexion->consulta($sql);
        $result = $conexion->obtenerUnaFila();
        $conexion->cerrar();
        return $result;
    }
    public function agregarUsuario(Usuario $usuario ){
        $conexion = new Conexion();
        $conexion->abrir();
        $nombre = $usuario->obtenerNombre();
        $correo = $usuario->obtenerCorreo();
        $contrasena = $usuario->obtenerContrasena();
        $contrasenaEncriptada = password_hash($contrasena, PASSWORD_DEFAULT);
        $sql = "INSERT INTO usuarios VALUES(null, '$nombre', '$correo', '$contrasenaEncriptada', 'cliente')";
        $conexion->consulta($sql);
        $result = $conexion->obtenerFilasAfectadas();
        $conexion->cerrar();
        return $result;
    }
    public function validarContrasena($correo){
        $conexion = new Conexion();
        $conexion->abrir();
        $sql = "SELECT contraseña FROM usuarios WHERE correo = '$correo'";
        $conexion->consulta($sql);
        $result = $conexion->obtenerUnaFila();
        $conexion->cerrar();
        return $result;
    }
    public function validarCorreo($correo){
        $conexion = new Conexion();
        $conexion->abrir();
        $sql = "SELECT correo FROM usuarios WHERE correo = '$correo'";
        $conexion->consulta($sql);
        $result = $conexion->obtenerUnaFila();
        $conexion->cerrar();
        return $result;
    }
}
?>