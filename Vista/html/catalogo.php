<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Catalogo</title>
    <link rel="stylesheet" href="Vista/css/estilos.css">
</head>
<body>   
     <!--Encabezado  -->
    <header>
        <h1>Tienda de Tenis</h1>
        <nav>
            <a href="index.php?accion=listarProductos">Catálogo</a>
            <a href="index.php?accion=verLoginA">Zona Admin</a>
            <?php if(isset($_SESSION['rol'])){ ?>
                <a href="index.php?accion=cerrarSesion">Cerrar Sesion</a>
            <?php } ?>
        </nav>
    </header>
    <!-- Listado de productos -->
    <section id="catalogo">
        <h2>Catálogo de Productos</h2>
        <form action="index.php?accion=filtrarCategoria" method="POST">
            Filtrar por:
            <select name="categoria">
            <option value="x">todas las categorias</option>
            <?php while($fila2 = $categorias->fetch_assoc()){ ?>
                <option value="<?php echo $fila2['id']; ?>"><?php echo $fila2['nombre']; ?></option> 
            <?php } ?>
            </select>
            <input type="submit" value="Buscar">
        </form>
        <div class="productos">
    <?php
    if(isset($result) && $result->num_rows > 0) {
            while($fila = $result->fetch_assoc()){
    ?>
            <!-- Aquí se llenan los productos dinámicamente -->
            <div class="producto">
                <?php if($fila['imagen'] == null){ ?><img src="imagenes/sinImagen.jpg" alt="Sin Imagen" class="imgProducto">
                    <?php }else{ ?><img src="imagenes/<?php echo $fila['imagen']; ?>" alt="Tenis Ejemplo" class="imgProducto"><?php }?>
                <h3><?php echo $fila['nombre']; ?></h3>
                <p>Categoría: <?php echo $fila['nombreCategoria']; ?></p>
                <p>Talla: <?php echo $fila['talla']; ?></p>
                <p>Descripción: <?php echo $fila['descripcion']; ?></p>
                <p>$<?php echo $fila['precio']; ?></p>
                <form class="none" action="index.php?accion=solicitarProducto" method="POST">
                    <input type="hidden" name="id" value="<?php echo $fila['id']; ?>">
                    <?php if(isset($_SESSION['id'])){?>
                    <input type="number" name="cantidad" placeholder="Cantidad +1">
                    <button>Solicitar Compra</button>
                    <?php }else{ ?>
                        <a href="index.php?accion=verLoginU">Iniciar Sesion o Registrarse</a>;
                    <?php } ?>
                </form>
            </div>
    <?php
        }
    }else{
            echo "<div class='producto'><h3>Aún no hay productos disponibles</h3></div>";
    }
    ?>
        </div>
    </section>
</body>
</html>