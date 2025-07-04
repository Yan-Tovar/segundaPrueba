function eliminarProducto(id){
    if (confirm("¿Está seguro de eliminar este producto?")) {
        window.location.href = `index.php?accion=eliminarProducto&id=${id}`;
    }
}
function eliminarCategoria(id){
    if (confirm("¿Está seguro de eliminar esta categoria?")) {
        window.location.href = `index.php?accion=eliminarCategoria&id=${id}`;
    }
}
function eliminarImagen(id){
    if (confirm("¿Está seguro de eliminar esta Imagen?")) {
        window.location.href = `index.php?accion=eliminarImagen&id=${id}`;
    }
}