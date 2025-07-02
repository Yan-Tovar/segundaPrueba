<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Catalogo</title>
    <link rel="stylesheet" href="Vista/css/estilos.css">
</head>
<body>   
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
                <input type="text" name="nombre" value="<?php echo $fila['nombre']; ?>" required placeholder="nombre">
                <input type="number" name="talla" value="<?php echo $fila['talla']; ?>" required placeholder="talla">
                <input type="text" name="descripcion" value="<?php echo $fila['descripcion']; ?>" required placeholder="descripcion">
                <input type="number" name="precio" value="<?php echo $fila['precio']; ?>" required placeholder="precio">
                <input type="file" name="imagen" accept="image/*">
                <select name="categoria">
                    <option value="<?php echo $fila['id_categoria']; ?>"><?php echo $fila['nombreCategoria']; ?></option> 
                    <?php while($fila2 = $categorias->fetch_assoc()){ ?>
                        <option value="<?php echo $fila2['id']; ?>"><?php echo $fila2['nombre']; ?></option> 
                    <?php } ?>
                </select>
                <input type="submit" value="Actualizar">
            </form>
            <a href="index.php?accion=verPanelA"><button>Cancelar</button></a>
    <?php
        }
    }else{
            echo "<div class='producto'><h3>Ocurrió un error en la busqueda</h3></div>";
            echo "<a href='index.php?accion=verPanelA'><button>Ir al Panel</button></a>";
    }
    ?>
        </div>
    </section>
</body>
</html>