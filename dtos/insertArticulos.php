<?php
if (
    $_SERVER["REQUEST_METHOD"] === "POST"
) {
    $link = mysqli_connect('localhost', 'root', '', 'pdv');

    // Obtener los datos del usuario del cuerpo de la solicitud
    $data = json_decode(file_get_contents("php://input"), true);

    // Obtener el último ID insertado
    $sql2 = "SELECT MAX(id_articulo) AS ultimo_id FROM articulos";
    $resultado = $link->query($sql2);

    if ($resultado->num_rows > 0) {
        $fila = $resultado->fetch_assoc();
        $ultimoId = $fila['ultimo_id'];
        $numeroActual = (int)substr($ultimoId, 1);
        $nuevoNumero = $numeroActual + 1;
        $nuevoCodigoCliente = 'A' . str_pad($nuevoNumero, 2, '0', STR_PAD_LEFT);
    } else {
        // Si no hay registros, establecer el primer código de cliente como C01
        $nuevoCodigoCliente = 'A01';
    }

    $sqlInsert = "INSERT INTO `articulos`(`id_articulo`, `nombre_articulo`, `descripcion`, `categoria`, `cant_max_stock`, `cant_min_stock`, `precio_provee`, `precio_public`, `iva`) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";

    if ($statement = mysqli_prepare($link, $sqlInsert)) {
        mysqli_stmt_bind_param($statement, "sssssssss", $nuevoCodigoCliente, $data['nombre_articulo'], $data['descripcion'], $data['categoria'], $data['cant_max_stock'], $data['cant_min_stock'], $data['precio_provee'], $data['precio_public'], $data['iva']);
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
