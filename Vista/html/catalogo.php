<?php
$busqueda = isset($_GET['busqueda']) ? $_GET['busqueda'] : '';
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
</head>
<body>   
     <!--Encabezado  -->
    <header>
        <h1>Tienda de Tenis</h1>
        <nav>
            <a href="index.php?accion=listarProductos">Catálogo</a>
            <?php if(isset($_SESSION['rol'])){ ?>
                <a href="index.php?accion=cerrarSesion">Cerrar Sesion</a>
            <?php }else{ ?>
                <a href="index.php?accion=verLoginA">Zona Admin</a>
            <?php } ?>
        </nav>
    </header>
    <!-- Listado de productos -->
    <section id="catalogo">

        <h2>Catálogo de Productos</h2>
        <form action="index.php?accion=filtrarBusqueda" method="POST">
            Buscar o Filtrar
            <input type="text" name="busqueda" placeholder="Categoria -- Nombre -- Marca -- tipo">
            <input type="submit" value="Buscar">
        </form>
        <div class="productos">
        <?php
        // Parámetros de paginación
        $porPagina = isset($_GET['cantidad']) ? (int)$_GET['cantidad'] : 6;
        $paginaActual = isset($_GET['pagina']) ? (int)$_GET['pagina'] : 1;
        $inicio = ($paginaActual - 1) * $porPagina;
        $totalPaginas = ceil($totalResultados / $porPagina);
        if (isset($result) && mysqli_num_rows($result) > 0) {
            while ($fila = mysqli_fetch_assoc($result)) {
                $imagenes = isset($fila['imagenesProducto']) ? explode(',', $fila['imagenesProducto']) : [];
        ?>
            <div class="producto">
                <?php if (count($imagenes) == 0 || $imagenes[0] == null) { ?>
                    <img src="imagenes/sinImagen.jpg" alt="Sin Imagen" class="imagenCarrusel">
                <?php } else { ?>
                <div class="centrado">
                    <div id="carousel<?php echo $fila['id']; ?>" class="carousel slide col-3" data-bs-ride="carousel">
                        <div class="carousel-inner">
                            <?php 
                            $activo = true;
                            foreach ($imagenes as $img) { ?>
                                <div class="carousel-item <?php echo $activo ? 'active' : ''; ?>">
                                    <img src="<?php echo $img; ?>" alt="Imagen Producto" class="d-block w-100 imagenCarrusel">
                                </div>
                            <?php $activo = false; } ?>
                        </div>
                        <button class="carousel-control-prev" type="button" data-bs-target="#carousel<?php echo $fila['id']; ?>" data-bs-slide="prev">
                            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                            <span class="visually-hidden">Anterior</span>
                        </button>
                        <button class="carousel-control-next" type="button" data-bs-target="#carousel<?php echo $fila['id']; ?>" data-bs-slide="next">
                            <span class="carousel-control-next-icon" aria-hidden="true"></span>
                            <span class="visually-hidden">Siguiente</span>
                        </button>
                    </div>
                </div>
                <?php } ?>
                <p>Categoría: <?php echo $fila['nombreCategoria']; ?></p>
                <p>Marca: <?php echo $fila['marca']; ?></p>
                <p>Modelo: <?php echo $fila['modelo']; ?></p>
                <p>Especificaciones: <?php echo $fila['especificaciones']; ?></p>
                <p>$<?php echo $fila['precio']; ?></p>

                <form class="none" action="index.php?accion=solicitarProducto" method="POST">
                    <input type="hidden" name="id" value="<?php echo $fila['id']; ?>">
                    <?php if (isset($_SESSION['id'])) { ?>
                        <input type="number" name="cantidad" placeholder="Cantidad +1">
                        <button>Solicitar Compra</button>
                    <?php } else { ?>
                        <a href="index.php?accion=verLoginU">Iniciar Sesión o Registrarse</a>
                    <?php } ?>
                </form>
            </div>
        <?php }
        }else {
            echo "<div class='producto'><h3>Aún no hay productos disponibles</h3></div>";
        }
        ?>
        </div>
    </section>
    <!-- Paginación -->
            <div class="d-flex justify-content-center mt-4">
                <nav>
                    <ul class="pagination">
                        <?php if ($paginaActual > 1): ?>
                            <li class="page-item">
                                <a class="page-link" href="index.php?accion=filtrarBusqueda&busqueda=<?= urlencode($busqueda) ?>&pagina=<?= $paginaActual - 1 ?>&cantidad=<?= $porPagina ?>">Anterior</a>
                            </li>
                        <?php endif; ?>

                        <?php for ($i = 1; $i <= $totalPaginas; $i++): ?>
                            <li class="page-item <?= ($i == $paginaActual) ? 'active' : '' ?>">
                                <a class="page-link" href="index.php?accion=filtrarBusqueda&busqueda=<?= urlencode($busqueda) ?>&pagina=<?= $i ?>&cantidad=<?= $porPagina ?>"><?= $i ?></a>
                            </li>
                        <?php endfor; ?>

                        <?php if ($paginaActual < $totalPaginas): ?>
                            <li class="page-item">
                                <a class="page-link" href="index.php?accion=filtrarBusqueda&busqueda=<?= urlencode($busqueda) ?>&pagina=<?= $paginaActual + 1 ?>&cantidad=<?= $porPagina ?>">Siguiente</a>
                            </li>
                        <?php endif; ?>
                    </ul>
                </nav>
            </div>
</body>
</html>