<?php

// Establece la conexión a tu base de datos
$link = mysqli_connect('localhost', 'root', '', 'pdv');

// Verifica la conexión
if (!$link) {
    die('Error de conexión: ' . mysqli_connect_error());
}

// Consulta para obtener las categorías
$sql = "SELECT categoria FROM articulos";
$result = mysqli_query($link, $sql);

if ($result) {
    $categorias = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $categorias[] = $row['categoria'];
    }

    // Devuelve las categorías en formato JSON
    header('Content-Type: application/json');
    echo json_encode($categorias);
} else {
    echo "Error al obtener las categorías: " . mysqli_error($link);
}

// Cierra la conexión
mysqli_close($link);
?>