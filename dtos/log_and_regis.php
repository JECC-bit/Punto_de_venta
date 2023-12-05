<?php
session_start(); 

if (
    isset($_POST["correolog"]) && !empty($_POST["correolog"]) &&
    isset($_POST["contrasenalog"]) && !empty($_POST["contrasenalog"])
) {
    $link = mysqli_connect('localhost', 'root', '', 'pdv');
    $correo = $_POST["correolog"];
    $passw = $_POST["contrasenalog"];

    $sql = "SELECT usuario, contrasena, rol FROM usuarios WHERE correo=? AND contrasena = ?";
    
    if ($statement = mysqli_prepare($link, $sql)) {
        mysqli_stmt_bind_param($statement, "ss", $correo, $passw);
        mysqli_stmt_execute($statement);
        
        $result = mysqli_stmt_get_result($statement);
        if ($row = mysqli_fetch_assoc($result)) {
           
            $_SESSION['rol'] = $row['rol'];
            
            if ($_SESSION['rol'] === 'Admin') {
                header("location: usuario.php"); 
            } elseif ($_SESSION['rol'] === 'Usuario') {
                header("location: clientes.php"); 
            exit();
        } else {
            echo "Error: Usuario o contraseña incorrectos.";
        }
    }
        mysqli_stmt_close($statement);
    } else {
        echo "Error al preparar la consulta.";
    }

    mysqli_close($link);
} else { }
?>
