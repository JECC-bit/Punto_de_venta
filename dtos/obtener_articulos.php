<?php
// Establece la conexión a tu base de datos
$link = mysqli_connect('localhost', 'root', '', 'pdv');

// Verifica la conexión
if (!$link) {
    die('Error de conexión: ' . mysqli_connect_error());
}

// Consulta para obtener las categorías
$sql = "SELECT ventas.id_articulo, articulos.descripcion FROM ventas INNER JOIN articulos ON ventas.id_articulo = articulos.id_articulo";
$result = mysqli_query($link, $sql);

if ($result) {
    $articulos = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $articulos_bd = [
            'id_articulo' => $row['id_articulo'],
            'descripcion' => $row['descripcion']
        ];
        $articulos[] = $articulos_bd; // Agrega cada articulo al array principal de articulos
    }

    // Devuelve las categorías en formato JSON
    header('Content-Type: application/json');
    echo json_encode($articulos);
} else {
    echo "Error al obtener las categorías: " . mysqli_error($link);
}

// Cierra la conexión
mysqli_close($link);
?>
