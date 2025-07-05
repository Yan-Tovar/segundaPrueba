<?php
$categorias = [];
$cantidadesP = [];
$tipos = [];
$cantidadesU = [];
$cantidadClientes = [];
$roles = [];
if ($ventasTipo->num_rows > 0) {
    while ($fila = $ventasTipo->fetch_object()) {
        $tipos[] = $fila->tipo_nombre;
        $cantidadesU[] = $fila->total_cantidad_pedida;
    }
}
if ($productosCategoria->num_rows > 0) {
    while ($fila = $productosCategoria->fetch_object()) {
        $categorias[] = $fila->categoria_nombre;
        $cantidadesP[] = $fila->cantidad;
    }
}
if ($clientesRegistrados->num_rows > 0) {
    while ($fila = $clientesRegistrados->fetch_object()) {
        $roles[] = $fila->rol;
        $cantidadClientes[] = $fila->cantidad;
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Estadisticas</title>
    <link rel="stylesheet" href="Vista/css/estilos.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script> 
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
<!-- Cantidad de productos en el pedido segun el tipo -->
        <canvas id="graficoVentasTipo" class="grafico"></canvas>
        <script>
            const ctx1 = document.getElementById('graficoVentasTipo').getContext('2d');
            const grafico = new Chart(ctx1, {
                type: 'bar',
                data: {
                    labels: <?php echo json_encode($tipos); ?>,
                    datasets: [{
                        label: 'Cantidad de Productos vendidos por Tipo',
                        data: <?php echo json_encode($cantidadesU); ?>,
                        backgroundColor: 'rgba(75, 192, 192, 0.5)',
                        borderColor: 'rgba(75, 192, 192, 1)',
                        borderWidth: 1
                    }]
                },
                options: {
                    responsive: true,
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    }
                }
            });

            setTimeout(() => {
                location.reload(); 
            }, 10000); 
        </script>
<!-- Cantidad de Productos Por categoria -->
        <canvas id="graficoCantidadProductosCategoria" class="grafico"></canvas>
        <script>
            const ctx2 = document.getElementById('graficoCantidadProductosCategoria').getContext('2d');
            const graficoCitas = new Chart(ctx2, {
                type: 'bar',
                data: {
                    labels: <?php echo json_encode($categorias); ?>,
                    datasets: [{
                        label: 'Cantidad de Productos por Categoria',
                        data: <?php echo json_encode($cantidadesP); ?>,
                        backgroundColor: 'rgba(153, 102, 255, 0.5)',
                        borderColor: 'rgba(153, 102, 255, 1)',
                        borderWidth: 1
                    }]
                },
                options: {
                    responsive: true,
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    }
                }
            });
        </script>
<!-- Gráfico de usuarios por rol -->
        <canvas id="graficoUsuariosPorRol" class="grafico"></canvas>
        <script>
            const ctxRol = document.getElementById('graficoUsuariosPorRol').getContext('2d');
            const graficoUsuarios = new Chart(ctxRol, {
                type: 'pie',
                data: {
                    labels: <?php echo json_encode($roles); ?>,
                    datasets: [{
                        label: 'Usuarios por Rol',
                        data: <?php echo json_encode($cantidadClientes); ?>,
                        backgroundColor: [
                            'rgba(255, 99, 132, 0.5)',
                            'rgba(54, 162, 235, 0.5)',
                            'rgba(255, 206, 86, 0.5)',
                            'rgba(75, 192, 192, 0.5)',
                            'rgba(153, 102, 255, 0.5)'
                        ],
                        borderColor: [
                            'rgb(255, 99, 132)',
                            'rgb(54, 162, 235)',
                            'rgb(255, 206, 86)',
                            'rgb(75, 192, 192)',
                            'rgb(153, 102, 255)'
                        ],
                        borderWidth: 1
                    }]
                },
                options: {
                    responsive: true
                }
            });
        </script>
</body>
</html>