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
                    // Convertir imágenes en array
                    $imagenes = isset($fila['imagenesProducto']) ? explode(',', $fila['imagenesProducto']) : [];
            ?>
                <div class="producto">
                    <?php 
                    if(count($imagenes) == 0 || $imagenes[0] == null){ ?>
                        <img src="imagenes/sinImagen.jpg" alt="Sin Imagen" class="imgProducto">
                    <?php 
                    } else {?>
                    <div class="centrado">
                        <div id="carouselExample" class="carousel slide col-3" data-bs-ride="carousel">
                            <div class="carousel-inner">
                                <?php 
                                $activo = true;
                                foreach($imagenes as $img){ ?>
                                    <div class="carousel-item <?php echo $activo ? 'active' : ''; ?>">
                                        <img src="<?php echo $img; ?>" alt="Imagen Producto" class="d-block w-100 imgProducto">
                                    </div>
                                <?php 
                                $activo = false;
                                } }?>
                            </div>
                            <button class="carousel-control-prev" type="button" data-bs-target="#carouselExample" data-bs-slide="prev">
                                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                <span class="visually-hidden">Anterior</span>
                            </button>
                            <button class="carousel-control-next" type="button" data-bs-target="#carouselExample" data-bs-slide="next">
                                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                <span class="visually-hidden">Siguiente</span>
                            </button>
                        </div>
                    </div>
                        <p>Categoría: <?php echo $fila['nombreCategoria']; ?></p>
                        <p>Marca: <?php echo $fila['marca']; ?></p>
                        <p>Modelo: <?php echo $fila['modelo']; ?></p>
                        <p>Especificaciones: <?php echo $fila['especificaciones']; ?></p>
                        <p>$<?php echo $fila['precio']; ?></p>

                        <form class="none" action="index.php?accion=solicitarProducto" method="POST">
                            <input type="hidden" name="id" value="<?php echo $fila['id']; ?>">
                            <?php if(isset($_SESSION['id'])){ ?>
                                <input type="number" name="cantidad" placeholder="Cantidad +1">
                                <button>Solicitar Compra</button>
                            <?php }else{ ?>
                                <a href="index.php?accion=verLoginU">Iniciar Sesión o Registrarse</a>
                            <?php } ?>
                        </form>
                </div>
            <?php
                }
            } else {
                echo "<div class='producto'><h3>Aún no hay productos disponibles</h3></div>";
            }
            ?>
        </div>
    </section>
</body>
</html>