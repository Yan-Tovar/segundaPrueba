<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Usuario</title>
    <link rel="stylesheet" href="Vista/css/estilos.css">
</head>
<body>
    <section id="admin">
        <p><strong>Iniciar sesión:</strong></p>
        <form action="index.php?accion=loginUsuario" method="POST">
            <input type="email" name="correo" placeholder="Correo">
            <input type="password" name="contrasena" placeholder="Contraseña">
            <button type="submit">Ingresar</button>
        </form>
    </section>
</body>
</html>