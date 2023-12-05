<?php
session_start(); 

if (isset($_GET["id"]) && !empty($_GET["id"])) {
    $link = mysqli_connect('localhost', 'root', '', 'pdv');
    $id = $_GET["id"];

    // Extraer el tipo de ID (primer carácter)
    $tipo = substr($id, 0, 1);

    switch ($tipo) {
        case 'C':
            $tabla = 'clientes';
            $columna = 'id_cliente';
            break;
        case 'U':
            $tabla = 'usuarios';
            $columna = 'id_user';
            break;
        case 'V':
            $tabla = 'ventas';
            $columna = 'id_venta';
            break;
        case 'A':
            $tabla = 'articulos';
            $columna = 'id_articulo';
            break;
        default:
            echo "Tipo de ID no válido";
            exit();
    }

    // Sentencia SQL para eliminar el registro basado en el tipo de ID
    $sql = "DELETE FROM $tabla WHERE $columna = ?";
    echo $sql;  
    echo $id;
    if ($statement = mysqli_prepare($link, $sql)) {
        mysqli_stmt_bind_param($statement, "s", $id);
        mysqli_stmt_execute($statement);
        
        // Verificar si se eliminó correctamente
        if (mysqli_stmt_affected_rows($statement) > 0) {
            echo "Registro eliminado correctamente";
            
        } else {
            echo "No se pudo eliminar el registro";
            // Puedes manejar el caso en el que no se eliminó el registro
        }

        mysqli_stmt_close($statement);
    } else {
        echo "Error al preparar la consulta.";
    }

    mysqli_close($link);
} else {
    echo "ID no proporcionado";
    // Puedes manejar el caso en el que no se proporciona un ID
}
?>
