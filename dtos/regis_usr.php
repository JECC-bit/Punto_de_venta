<?php

if (
    isset($_POST["nombre"]) && !empty($_POST["nombre"]) &&
    isset($_POST["correo"]) && !empty($_POST["correo"]) &&
    isset($_POST["user"]) && !empty($_POST["user"]) &&
    isset($_POST["psw"]) && !empty($_POST["psw"]) &&
    isset($_POST["pswc"]) && !empty($_POST["pswc"]) 
    ) {
        $link = mysqli_connect('localhost', 'root', '', 'pdv');
        $name = $_POST["nombre"];
        $correo = $_POST["correo"];
    $user = $_POST["user"];
    $passw = $_POST["psw"];
    
    // Obtener el último ID insertado
    $sql2 = "SELECT MAX(id_user) AS ultimo_id FROM usuarios";
    $resultado = $link->query($sql2);
    
    if ($resultado->num_rows > 0) {
        $fila = $resultado->fetch_assoc();
        $ultimoId = $fila['ultimo_id'];
        $numeroActual = (int)substr($ultimoId, 1);
        $nuevoNumero = $numeroActual + 1;
        $nuevoCodigoUsuario = 'U' . str_pad($nuevoNumero, 2, '0', STR_PAD_LEFT);
    } else {
        // Si no hay registros, establecer el primer código de usuario como U01
        $nuevoCodigoUsuario = 'U01';
    }
    
    $sqlInsert = "INSERT INTO `usuarios` (`id_user`, `nombre_usuario`, `correo`, `usuario`, `contrasena`, `rol`) VALUES (?, ?, ?, ?, ?, ?)";
    
    if ($statement = mysqli_prepare($link, $sqlInsert)) {
        session_start(); 
        $rol = 'Usuario'; 
        
        mysqli_stmt_bind_param($statement, "ssssss", $nuevoCodigoUsuario, $name, $correo, $user, $passw, $rol);
        mysqli_stmt_execute($statement);
        mysqli_stmt_close($statement);
        
        $_SESSION['rol'] = $rol;
        header("location: clientes.php"); 
        exit();
    } else {
        echo "Error al preparar la consulta para insertar.";
    }

    mysqli_close($link);
} else { }
?>
