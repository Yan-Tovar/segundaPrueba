<?php
if($_SESSION['rol'] == "admin"){
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>VerProductos</title>
    <link rel="stylesheet" href="Vista/css/estilos.css">
    <script src="Vista/js/script.js"></script>
</head>
<body>
    <!--Encabezado  -->
    <header>
        <h1>Tienda de Tenis</h1>
        <nav>
            <a href="index.php?accion=verPanelA">Inicio</a>
            <a href="index.php?accion=verProductos">Productos</a>
            <a href="index.php?accion=verCategorias">Categorias</a>
            <a href="index.php?accion=cerrarSesion">Cerrar Sesion</a>
        </nav>
    </header>
    <section id="panel-admin">
        <h2>Panel de Administración</h2>
        <div class="admin-section">
            <h3>Productos</h3>
            <form class="form-admin" action="index.php?accion=agregarProducto" method="POST" enctype="multipart/form-data">
            <input type="text" name="marca" placeholder="Marca" required>
            <input type="text" name="modelo" placeholder="modelo" required>
            <select name="categoria">
                <option value="">Seleccionar categoría</option>
                <?php while($fila2 = $categorias->fetch_assoc()){ ?>
                    <option value="<?php echo $fila2['id']; ?>"><?php echo $fila2['nombre']; ?></option> 
                <?php } ?>
            </select>
            <select name="tipo">
                <option value="">Seleccionar tipo</option>
                <?php while($fila3 = $tipos->fetch_assoc()){ ?>
                    <option value="<?php echo $fila3['id']; ?>"><?php echo $fila3['nombre']; ?></option> 
                <?php } ?>
            </select>
            <input type="text" name="especificaciones" placeholder="especificaciones" required>
            <input type="number" name="precio" placeholder="precio" required>
            <input type="file"  multiple name="imagen[]" accept="image/*">
            <button type="submit">Guardar Producto</button>
            </form>
            <table>
            <thead>
                <tr>
                <th>Id</th>
                <th>Marca</th>
                <th>Modelo</th>
                <th>Tipo</th>
                <th>especificaciones</th>
                <th>Precio</th>
                <th>Categoria</th>
                </tr>
            </thead>
            <?php
            if(isset($productos) && $productos->num_rows > 0) {
                    while($fila = $productos->fetch_assoc()){
            ?>
                <!-- Aquí se llenan los productos dinámicamente -->
                    <tbody>
                    <tr>
                        <td><?php echo $fila['id']; ?></td>
                        <td><?php echo $fila['marca']; ?></td>
                        <td><?php echo $fila['modelo']; ?></td>
                        <td><?php echo $fila['nombreTipo']; ?></td>
                        <td><?php echo $fila['especificaciones']; ?></td>
                        <td><?php echo $fila['precio']; ?></td>
                        <td><?php echo $fila['nombreCategoria']; ?></td>
                        <td>
                        <a href="index.php?accion=mostrarProducto&id=<?php echo $fila['id']; ?>"><button>Editar</button></a>
                        <button onclick="eliminarProducto('<?php echo $fila['id']; ?>')">Eliminar</button>
                        </td>
                    </tr>
                    </tbody>
            <?php
                }
            }else{
                    echo "<tbody><tr>Aún no hay productos registrados</tr></tbody>";
            }
            ?>   
            </table>
    </div>
    </section>  
</body>
</html>
<?php
}else{
  echo "<script>alert('You can´t open this file');</script>";
  header('location:index.php');
}
?>