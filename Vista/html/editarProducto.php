<?php
if($_SESSION['rol'] == "admin"){
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Catalogo</title>
    <link rel="stylesheet" href="Vista/css/estilos.css">
    <!-- Bootstrap 5.3 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap 5.3 JS + Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
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
    <!-- Listado de productos -->
    <section id="catalogo">
        <h2>Editar Producto</h2>
        <div class="productos">
            <?php
            if(isset($producto) && $producto->num_rows > 0) {
                    while($fila = $producto->fetch_assoc()){
            ?>
            <!-- Aquí se llenan los datos del producto dinámicamente -->
            <form action="index.php?accion=editarProducto" method="POST" enctype="multipart/form-data">
                <input type="hidden" name="id" value="<?php echo $fila['id']; ?>" required>
                <input type="text" name="marca" value="<?php echo $fila['marca']; ?>" required placeholder="Marca">
                <input type="text" name="modelo" value="<?php echo $fila['modelo']; ?>" required placeholder="Modelo">
                <select name="tipo">
                    <option value="<?php echo $fila['tipo']; ?>"><?php echo $fila['nombreTipo']; ?></option> 
                    <?php while($fila4 = $tipos->fetch_assoc()){ ?>
                        <option value="<?php echo $fila4['id']; ?>"><?php echo $fila4['nombre']; ?></option> 
                    <?php } ?>
                </select>
                <input type="text" name="especificaciones" value="<?php echo $fila['especificaciones']; ?>" required placeholder="Especificaciones">
                <input type="number" name="precio" value="<?php echo $fila['precio']; ?>" required placeholder="precio">
                <select name="categoria">
                    <option value="<?php echo $fila['id_categoria']; ?>"><?php echo $fila['nombreCategoria']; ?></option> 
                    <?php while($fila2 = $categorias->fetch_assoc()){ ?>
                        <option value="<?php echo $fila2['id']; ?>"><?php echo $fila2['nombre']; ?></option> 
                    <?php } ?>
                </select>
                <input type="submit" value="Actualizar">
            </form>
        </div>
        <h3>Agregar Imagen</h3>
        <form action="index.php?accion=agregarImagen" method="POST" enctype="multipart/form-data">
            <input type="hidden" name="id" value="<?php echo $fila['id']; ?>">
            <input type="file" multiple name="imagen[]" accept="image/*">
            <input type="submit" value="Subir">
        </form>
    <?php
        }
    }else{
            echo "<div class='producto'><h3>Ocurrió un error en la busqueda</h3></div>";
    }
    ?>
    </section>
    <hr>
    <h1>Imagenes</h1>
    <?php
    if (!empty($imagenes)) {
    foreach ($imagenes as $fila3) {
    ?>
            <!-- Aquí se llenan los datos de la imagen dinámicamente -->
            <div class="card" style="width: 18rem;">
                <img src="<?php echo $fila3['nombre']; ?>" alt="Imagen">
                <div class="card-body">
                    <h5 class="card-title"><?php echo $fila3['nombre']; ?></h5>
                    <button onclick="eliminarImagen('<?php echo $fila3['id']; ?>')">Eliminar</button>
                </div>
            </div>
            <br>
    <?php
        }
    }else{
            echo "<div class='producto'><h3>No hay imagenes</h3></div>";
    }
    ?>
</body>
</html>
<?php
}else{
  echo "<script>alert('You can´t open this file');</script>";
  header('location:index.php');
}
?>