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
        <h2>Editar Categoria</h2>
        <div class="productos">
    <?php
    if(isset($categoria) && $categoria->num_rows > 0) {
            while($fila = $categoria->fetch_assoc()){
    ?>
            <!-- Aquí se llenan los datos del producto dinámicamente -->
            <form action="index.php?accion=editarCategoria" method="POST">
                <input type="hidden" name="id" value="<?php echo $fila['id']; ?>" required>
                <input type="text" name="nombre" value="<?php echo $fila['nombre']; ?>" required>
                <input type="submit" value="Actualizar">   
            </form>
            <a href="index.php?accion=verPanelA"><button>Cancelar</button></a>
    <?php
        }
    }else{
            echo "<div class='producto'><h3>Ocurrió un error en la busqueda</h3></div>";
    }
    ?>
        </div>
    </section>
</body>
</html>