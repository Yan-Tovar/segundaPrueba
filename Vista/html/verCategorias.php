<?php
if($_SESSION['rol'] == "admin"){
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>VerCategorias</title>
    <link rel="stylesheet" href="Vista/css/estilos.css">
    <script src="Vista/js/script.js"></script>
</head>
<body>
  <!--Encabezado  -->
    <header>
        <h1>Tienda de Tenis</h1>
        <nav>
            <a href="index.php?accion=verPanelA">Inicio</a>
            <a href="index.php?accion=verProductos">Producutos</a>
            <a href="index.php?accion=verCategorias">Categorias</a>
            <a href="index.php?accion=verEstadisticas">Estadisticas</a>
            <a href="index.php?accion=cerrarSesion">Cerrar Sesion</a>
        </nav>
    </header>
    <section>
      <div class="admin-section">
        <h3>Categorías</h3>
        <form class="form-admin" action="index.php?accion=agregarCategoria" method="POST">
          <input type="text" name="nombre" placeholder="Nombre de la categoría" required>
          <button type="submit">Guardar Categoría</button>
        </form>
        <table>
          <ul>
            <?php
              if(isset($categorias) && $categorias->num_rows > 0) {
                      while($fila = $categorias->fetch_assoc()){
            ?>
                      <!-- Aquí se llenan los productos dinámicamente -->
                      <li><?php echo $fila['nombre']; ?> 
                        <a href="index.php?accion=mostrarCategoria&id=<?php echo $fila['id']; ?>"><button>Editar</button></a>
                        <button onclick="eliminarCategoria('<?php echo $fila['id']; ?>')">Eliminar</button>
                      </li>
              <?php
                  }
              }else{
                      echo "<tbody><tr>Aún no hay categorias registradas</tr></tbody>";
              }
              ?> 
          </ul>
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