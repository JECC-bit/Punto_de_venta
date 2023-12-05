<?php
  // Conexión a la base de datos
  $servername = "localhost";
  $username = "root";
  $password = "";
  $dbname = "pdv";

  $conn = new mysqli($servername, $username, $password, $dbname);

  if ($conn->connect_error) {
      die("Error de conexión: " . $conn->connect_error);
  }

  // Consulta SQL para obtener datos de la tabla articulos 
  $sql = "SELECT * FROM articulos";
  $result = $conn->query($sql);

  if ($result->num_rows > 0) {
      // Convertir los resultados a un array asociativo
      $data = array();
      while($row = $result->fetch_assoc()) {
        // Agregar la estructura de acciones para cada fila
        $row['acciones'] = array(
            array(
                'text' => 'Eliminar',
                'icon' => 'mdi-delete',
                'color' => 'red',
                'class' => 'ma-2',
                'small' => true,
                'funcion' => 'eliminarArticulo', 
                  'id_usuario' => $row['id_articulo'] 
            ),
            array(
                'text' => 'Modificar',
                'icon' => 'mdi-update',
                'color' => 'blue',
                'class' => 'ma-2',
                'small' => true,
                'funcion' => 'modificarArticulo', 
                'id_usuario' => $row['id_articulo'] 
            ),
        );
        
          $data[] = $row;
      }

      // Devolver los datos como JSON
      echo json_encode($data);
  } else {
      echo "0 resultados";
  }

  $conn->close();
?>