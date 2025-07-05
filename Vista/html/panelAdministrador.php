<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Catalogo</title>
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
            <a href="index.php?accion=verEstadisticas">Estadisticas</a>
            <a href="index.php?accion=cerrarSesion">Cerrar Sesion</a>
        </nav>
    </header>
    <section>
      <div class="admin-section">
        <h3>Pedidos</h3>
        <table>
          <thead>
            <tr>
              <th>ID Pedido</th>
              <th>Cliente</th>
              <th>Producto</th>
              <th>Cantidad</th>
              <th>Fecha</th>
              <th>Estado</th>
            </tr>
          </thead>
          <tbody>
          <?php
            if(isset($pedidos) && $pedidos->num_rows > 0) {
                    while($fila = $pedidos->fetch_assoc()){
          ?>
                    <!-- Aquí se llenan los productos dinámicamente -->
                      <tr>
                        <td><?php echo $fila['id']; ?></td>
                        <td><?php echo $fila['cliente']; ?></td>
                        <td><?php echo $fila['producto']; ?></td>
                        <td><?php echo $fila['cantidad']; ?></td>
                        <td><?php echo $fila['fecha']; ?></td>
                        <td><?php echo $fila['estado']; ?></td>
                        <td>
                          <form action="index.php?accion=cambiarEstadoPedido" method="POST">
                            <input type="hidden" value="<?php echo $fila['id']; ?>" name="id">
                            <select name="estado">
                              <option value="Pendiente">Pendiente</option>
                              <option value="Enviado">Enviado</option>
                              <option value="Entregado">Entregado</option>
                              <option value="Cancelado">Cancelado</option>
                            </select>
                            <input type="submit" value="Cambiar">
                          </form>
                        </td>
                      </tr>
            <?php
                }
            }else{
                    echo "<tbody><tr>Aún no hay pedidos registrados</tr></tbody>";
            }
            ?> 
            </tbody>
        </table>
      </div>
    </section>
</body>
</html>