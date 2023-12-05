<?php
if (
    $_SERVER["REQUEST_METHOD"] === "POST"
) {
    $link = mysqli_connect('localhost', 'root', '', 'pdv');

    // Obtener los datos del usuario del cuerpo de la solicitud
    $data = json_decode(file_get_contents("php://input"), true);

    // Obtener el último ID insertado
    $sql2 = "SELECT MAX(id_venta) AS ultimo_id FROM ventas";
    $resultado = $link->query($sql2);

    if ($resultado->num_rows > 0) {
        $fila = $resultado->fetch_assoc();
        $ultimoId = $fila['ultimo_id'];
        $numeroActual = (int)substr($ultimoId, 1);
        $nuevoNumero = $numeroActual + 1;
        $nuevoCodigoCliente = 'V' . str_pad($nuevoNumero, 2, '0', STR_PAD_LEFT);
    } else {
        // Si no hay registros, establecer el primer código de cliente como C01
        $nuevoCodigoCliente = 'V01';
    }

    $sqlInsert = "INSERT INTO `ventas`(`id_venta`, `id_articulo`, `cantidad_venta`, `fecha_venta`, `metodo_pago`) VALUES (?, ?, ?, ?, ?)";

    if ($statement = mysqli_prepare($link, $sqlInsert)) {
        mysqli_stmt_bind_param($statement, "ssdss", $nuevoCodigoCliente, $data['id_articulo'], $data['cantidad_venta'], $data['fecha_venta'], $data['metodo_pago']);
        mysqli_stmt_execute($statement);
        mysqli_stmt_close($statement);
        exit();
    } else {
        echo "Error al preparar la consulta para insertar.";
    }

    mysqli_close($link);
} else {
    // Manejar caso en el que los campos no estén completos
}
?>
