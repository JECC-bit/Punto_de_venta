<?php
require '../composer/vendor/autoload.php'; 

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Style\Border;
$link = mysqli_connect('localhost', 'root', '', 'pdv');

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Obtener los datos enviados por POST
    $data = json_decode(file_get_contents("php://input"), true);

    // Validar y procesar los datos recibidos
    $selectedSection = $data['section'];
    $startDate = $data['startDate'];
    $endDate = $data['endDate'];

    $styleCenter = [
        'alignment' => [
            'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
            'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
        ],
    ];

    $styleHeader = [
        'font' => [
            'bold' => true,
            'color' => ['rgb' => 'FFFFFF'], // Color de fuente blanco
        ],
        'fill' => [
            'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
            'startColor' => ['rgb' => '008000'], // Color de fondo verde (cambiar según el deseado)
        ],
    ];

    $styleArray = [
        'borders' => [
            'allBorders' => [
                'borderStyle' => Border::BORDER_THIN,
                'color' => ['argb' => 'FFFF'],
            ],
        ],
      ];

    // Verificar la seccion seleccionada
    switch($selectedSection){
        case 'Artículos':
                $spreadsheet = new Spreadsheet();
                $sheet = $spreadsheet->getActiveSheet();

                $sheet->getColumnDimension('A')->setWidth(15); 
                $sheet->getColumnDimension('B')->setWidth(25);
                $sheet->getColumnDimension('C')->setWidth(27);
                $sheet->getColumnDimension('D')->setWidth(18);
                $sheet->getColumnDimension('E')->setWidth(16);
                $sheet->getColumnDimension('F')->setWidth(16);
                $sheet->getColumnDimension('G')->setWidth(19);
                $sheet->getColumnDimension('H')->setWidth(17);


                $sheet->setCellValue('A1', 'ID Articulo');
                $sheet->setCellValue('B1', 'Nombre del articulo');
                $sheet->setCellValue('C1', 'Descripcion');
                $sheet->setCellValue('D1', 'Categoria');
                $sheet->setCellValue('E1', 'Cant. Max. Stock');
                $sheet->setCellValue('F1', 'Cant. Min. Stock');
                $sheet->setCellValue('G1', 'Precio del proveedor');
                $sheet->setCellValue('H1', 'Precio al publico');
                $sheet->setCellValue('I1', 'IVA');

                $cell = 2;
                $sql = "SELECT * FROM articulos";
                $query = mysqli_query($link, $sql);
                while ($row = mysqli_fetch_array($query)) { 
                
                    
                    $sheet->setCellValue('A'.$cell+1, $row['id_articulo']);
                    $sheet->setCellValue('B'.$cell+1, $row['nombre_articulo']);
                    $sheet->setCellValue('C'.$cell+1, $row['descripcion']);
                    $sheet->setCellValue('D'.$cell+1, $row['categoria']);            
                    $sheet->setCellValue('E'.$cell+1, $row['cant_max_stock']);
                    $sheet->setCellValue('F'.$cell+1, $row['cant_min_stock']);
                    $sheet->setCellValue('G'.$cell+1, $row['precio_provee']);
                    $sheet->setCellValue('H'.$cell+1, $row['precio_public']);
                    $sheet->setCellValue('I'.$cell+1, $row['iva']);
                    
                    $cell=$cell+1;
                }
                $sheet->getStyle('A1:I'.$cell)->applyFromArray($styleCenter);
                $sheet->getStyle('A1:I1')->applyFromArray($styleHeader);
                $sheet->getStyle('A1:I'.$cell)->applyFromArray($styleArray);
                $writer = new Xlsx($spreadsheet);
                // Configurar la cabecera para indicar que se envía un archivo Excel
                header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
                header('Content-Disposition: attachment;filename="reporteArticulos.xlsx"');
                header('Cache-Control: max-age=0');
            
                // Salida del archivo Excel
                $writer->save('php://output');
            break;
        
        case 'Clientes':
                $spreadsheet = new Spreadsheet();
                $sheet = $spreadsheet->getActiveSheet();

                $sheet->getColumnDimension('A')->setWidth(15); 
                $sheet->getColumnDimension('B')->setWidth(25);
                $sheet->getColumnDimension('C')->setWidth(22);
                $sheet->getColumnDimension('D')->setWidth(30);



                $sheet->setCellValue('A1', 'ID Cliente');
                $sheet->setCellValue('B1', 'Nombre del Cliente');
                $sheet->setCellValue('C1', 'Telefono');
                $sheet->setCellValue('D1', 'Dirección');


                $cell = 2;
                $sql = "SELECT * FROM clientes";
                $query = mysqli_query($link, $sql);
                while ($row = mysqli_fetch_array($query)) { 
                
                    
                    $sheet->setCellValue('A'.$cell+1, $row['id_cliente']);
                    $sheet->setCellValue('B'.$cell+1, $row['nombre_cliente']);
                    $sheet->setCellValue('C'.$cell+1, $row['telefono_cliente']);
                    $sheet->setCellValue('D'.$cell+1, $row['direccion']);            

                    
                    $cell=$cell+1;
                }
                $sheet->getStyle('A1:D'.$cell)->applyFromArray($styleCenter);
                $sheet->getStyle('A1:D1')->applyFromArray($styleHeader);
                $sheet->getStyle('A1:D'.$cell)->applyFromArray($styleArray);
                $writer = new Xlsx($spreadsheet);
                // Configurar la cabecera para indicar que se envía un archivo Excel
                header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
                header('Content-Disposition: attachment;filename="reporteClientes.xlsx"');
                header('Cache-Control: max-age=0');
            
                // Salida del archivo Excel
                $writer->save('php://output');
            break;

        case 'Ventas':

                $spreadsheet = new Spreadsheet();
                $sheet = $spreadsheet->getActiveSheet();

                $sheet->getColumnDimension('A')->setWidth(15); 
                $sheet->getColumnDimension('B')->setWidth(25);
                $sheet->getColumnDimension('C')->setWidth(22);
                $sheet->getColumnDimension('D')->setWidth(30);
                $sheet->getColumnDimension('E')->setWidth(30);
                $sheet->getColumnDimension('F')->setWidth(18);



                $sheet->setCellValue('A1', 'ID Venta');
                $sheet->setCellValue('B1', 'ID del articulo');
                $sheet->setCellValue('C1', 'Descripción del articulo');
                $sheet->setCellValue('D1', 'Cantiad de venta');
                $sheet->setCellValue('E1', 'Fecha de venta');
                $sheet->setCellValue('F1', 'Método de pago');


                $cell = 2;

                $sql = "SELECT ventas.*, articulos.descripcion AS descripcion_articulo 
                FROM ventas 
                INNER JOIN articulos ON ventas.id_articulo = articulos.id_articulo 
                WHERE fecha_venta BETWEEN '$startDate' AND '$endDate'";

                $query = mysqli_query($link, $sql);
                while ($row = mysqli_fetch_array($query)) { 
                
                    
                    $sheet->setCellValue('A'.$cell+1, $row['id_venta']);
                    $sheet->setCellValue('B'.$cell+1, $row['id_articulo']);
                    $sheet->setCellValue('C'.$cell+1, $row['descripcion_articulo']);
                    $sheet->setCellValue('D'.$cell+1, $row['cantidad_venta']);  
                    $sheet->setCellValue('E'.$cell+1, $row['fecha_venta']);  
                    $sheet->setCellValue('F'.$cell+1, $row['metodo_pago']);         

                    
                    $cell=$cell+1;
                }
                $sheet->getStyle('A1:F'.$cell)->applyFromArray($styleCenter);
                $sheet->getStyle('A1:F1')->applyFromArray($styleHeader);
                $sheet->getStyle('A1:F'.$cell)->applyFromArray($styleArray);
                $writer = new Xlsx($spreadsheet);
                // Configurar la cabecera para indicar que se envía un archivo Excel
                header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
                header('Content-Disposition: attachment;filename="reporteClientes.xlsx"');
                header('Cache-Control: max-age=0');
            
                // Salida del archivo Excel
                $writer->save('php://output');
            break;

        case 'Usuarios':

                $spreadsheet = new Spreadsheet();
                $sheet = $spreadsheet->getActiveSheet();

                $sheet->getColumnDimension('A')->setWidth(15); 
                $sheet->getColumnDimension('B')->setWidth(25);
                $sheet->getColumnDimension('C')->setWidth(25);
                $sheet->getColumnDimension('D')->setWidth(20);
                $sheet->getColumnDimension('E')->setWidth(20);



                $sheet->setCellValue('A1', 'ID Usuario');
                $sheet->setCellValue('B1', 'Nombre del Usuario');
                $sheet->setCellValue('C1', 'Correo');
                $sheet->setCellValue('D1', 'Usuario');
                $sheet->setCellValue('E1', 'Rol');


                $cell = 2;
                $sql = "SELECT * FROM Usuarios";
                $query = mysqli_query($link, $sql);
                while ($row = mysqli_fetch_array($query)) { 
                
                    
                    $sheet->setCellValue('A'.$cell+1, $row['id_user']);
                    $sheet->setCellValue('B'.$cell+1, $row['nombre_usuario']);
                    $sheet->setCellValue('C'.$cell+1, $row['correo']);
                    $sheet->setCellValue('D'.$cell+1, $row['usuario']); 
                    $sheet->setCellValue('E'.$cell+1, $row['rol']);           

                    
                    $cell=$cell+1;
                }
                $sheet->getStyle('A1:E'.$cell)->applyFromArray($styleCenter);
                $sheet->getStyle('A1:E1')->applyFromArray($styleHeader);
                $sheet->getStyle('A1:E'.$cell)->applyFromArray($styleArray);
                $writer = new Xlsx($spreadsheet);
                // Configurar la cabecera para indicar que se envía un archivo Excel
                header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
                header('Content-Disposition: attachment;filename="reporteUsuarios.xlsx"');
                header('Cache-Control: max-age=0');
            
                // Salida del archivo Excel
                $writer->save('php://output');
            break;
    }


    mysqli_close($link);
} else {
    echo "Solicitud inválida.";
}
?>
