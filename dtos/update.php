<?php
session_start();

// Verificar si se reciben datos del usuario para actualizar
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_GET["id"]) && !empty($_GET["id"])) {
    $link = mysqli_connect('localhost', 'root', '', 'pdv');
    $id = $_GET["id"];
    
    // Extraer el tipo de ID
    $tipo = substr($id, 0, 1);

    switch ($tipo) {
        //////////////////////////////////////////////////////////////////////// clientes
        case 'C':

            // Sentencia SQL para actualizar los datos del usuario en la tabla especificada
            $sql = "UPDATE clientes SET nombre_cliente = ?, telefono_cliente = ?, direccion = ? WHERE id_cliente = ?";

                // Obtener los datos del usuario del cuerpo de la solicitud
            $data = json_decode(file_get_contents("php://input"), true);
            
            if ($statement = mysqli_prepare($link, $sql)) {
                mysqli_stmt_bind_param($statement, "ssss", $data['nombre_cliente'], $data['telefono_cliente'], $data['direccion'], $id);
                mysqli_stmt_execute($statement);
                
                // Verificar si se actualizó correctamente
                if (mysqli_stmt_affected_rows($statement) > 0) {
                    echo "Datos del usuario actualizados correctamente";
                } else {
                    echo "No se pudieron actualizar los datos del usuario";
                    // Puedes manejar el caso en el que no se actualizan los datos
                }

                mysqli_stmt_close($statement);
            } else {
                echo "Error al preparar la consulta.";
            }

            mysqli_close($link);

            break;
        ///////////////////////////////////////////////////////////////////// usuarios
        case 'U':

            // Sentencia SQL para actualizar los datos del usuario en la tabla especificada
            $sql = "UPDATE usuarios SET nombre_usuario = ?, correo = ?, usuario = ?, rol = ? WHERE id_user = ?";

                // Obtener los datos del usuario del cuerpo de la solicitud
            $data = json_decode(file_get_contents("php://input"), true);
            
            if ($statement = mysqli_prepare($link, $sql)) {
                mysqli_stmt_bind_param($statement, "sssss", $data['nombre_usuario'], $data['correo'], $data['usuario'], $data['rol'], $id);
                mysqli_stmt_execute($statement);
                
                // Verificar si se actualizó correctamente
                if (mysqli_stmt_affected_rows($statement) > 0) {
                    echo "Datos del usuario actualizados correctamente";
                } else {
                    echo "No se pudieron actualizar los datos del usuario";
                    // Puedes manejar el caso en el que no se actualizan los datos
                }

                mysqli_stmt_close($statement);
            } else {
                echo "Error al preparar la consulta.";
            }

            mysqli_close($link);

            break;
        ////////////////////////////////////////////////////////////////// Ventas
        case 'V':

            // Sentencia SQL para actualizar los datos del usuario en la tabla especificada
            $sql = "UPDATE ventas SET id_articulo = ?, cantidad_venta = ?, fecha_venta = ?, metodo_pago = ? WHERE id_venta = ?";

            $data = json_decode(file_get_contents("php://input"), true);

            // Obtener los datos del usuario del cuerpo de la solicitud
            if ($statement = mysqli_prepare($link, $sql)) {
                mysqli_stmt_bind_param($statement, "sdsss", $data['id_articulo'], $data['cantidad_venta'], $data['fecha_venta'], $data['metodo_pago'], $id);
                mysqli_stmt_execute($statement);
                
                // Verificar si se actualizó correctamente
                if (mysqli_stmt_affected_rows($statement) > 0) {
                    echo "Datos del usuario actualizados correctamente";
                } else {
                    echo "No se pudieron actualizar los datos del usuario";
                    // Puedes manejar el caso en el que no se actualizan los datos
                }
                
                mysqli_stmt_close($statement);
            } else {
                echo "Error al preparar la consulta.";
            }
            
            mysqli_close($link);

            break;
        ///////////////////////////////////////////////////////////////////// Articulos
        case 'A':

            // Sentencia SQL para actualizar los datos del usuario en la tabla especificada
            $sql = "UPDATE articulos SET nombre_articulo = ?, descripcion = ?, categoria = ?, cant_max_stock = ?, cant_min_stock = ?, precio_provee = ?, precio_public = ?, iva = ? WHERE id_articulo = ?";
            
            
            $data = json_decode(file_get_contents("php://input"), true);

            // Obtener los datos del usuario del cuerpo de la solicitud
            if ($statement = mysqli_prepare($link, $sql)) {
                mysqli_stmt_bind_param($statement, "sssssssss", $data['nombre_articulo'], $data['descripcion'], $data['categoria'], $data['cant_max_stock'], $data['cant_min_stock'], $data['precio_provee'], $data['precio_public'], $data['iva'], $id);
                mysqli_stmt_execute($statement);
                
                // Verificar si se actualizó correctamente
                if (mysqli_stmt_affected_rows($statement) > 0) {
                    echo "Datos del usuario actualizados correctamente";
                } else {
                    echo "No se pudieron actualizar los datos del usuario";
                    // Puedes manejar el caso en el que no se actualizan los datos
                }
                
                mysqli_stmt_close($statement);
            } else {
                echo "Error al preparar la consulta.";
            }
            
            mysqli_close($link);

            break;

        default:
            echo "Tipo de ID no válido";
            exit();
    }

} else {
    echo "No se proporcionaron datos para actualizar";
    // Puedes manejar el caso en el que no se proporcionan datos para actualizar
}
?>
