<?php
require('fpdf/fpdf.php');

class PDF extends FPDF
{
    // Cabecera de página
    function Header()
    {
        // Arial bold 15
        $this->SetFont('Arial','B',16);
        // Título
        $this->Cell(0,10,'Reporte de Productos por Categoria',0,1,'C');
        // Salto de línea
        $this->Ln(10);

        // Encabezados de tabla
        $this->Cell(40,10,'Categoria',1,0,'C');
        $this->Cell(70,10,'Nombre',1,0,'C');
        $this->Cell(30,10,'Precio',1,0,'C');
        $this->Cell(30,10,'Stock',1,1,'C');
    }

    // Pie de página
    function Footer()
    {
        // Posición: a 1,5 cm del final
        $this->SetY(-15);
        // Arial italic 8
        $this->SetFont('Arial','I',8);
        // Número de página
        $this->Cell(0,10,'Pagina '.$this->PageNo().'/{nb}',0,0,'C');
    }
}

require ("cn.php");
$consulta = "SELECT c.categoria_nombre AS categoria, p.producto_codigo, p.producto_nombre, p.producto_precio, p.producto_stock FROM producto p INNER JOIN categoria c ON p.categoria_id = c.categoria_id ORDER BY c.categoria_nombre ASC";
$resultado = mysqli_query($conexion, $consulta);

// Crear instancia de PDF y definir tamaño personalizado
$pdf = new PDF('P', 'mm', 'A4');

// Agregar página
$pdf->AddPage();

// Establecer fuente y tamaño para el contenido de la tabla
$pdf->SetFont('Arial','',10);

while ($row = $resultado->fetch_assoc()) {
    $categoria = $row['categoria'];
    $nombre = $row['producto_nombre'];
    $precio = $row['producto_precio'];
    $stock = $row['producto_stock'];

    // Imprimir los datos en la tabla
    $pdf->Cell(40,10,$categoria,1,0,'C');
    $pdf->Cell(70,10,$nombre,1,0,'C');
    $pdf->Cell(30,10,$precio,1,0,'C');
    $pdf->Cell(30,10,$stock,1,1,'C');
}

// Salida del PDF
$pdf->Output();
?>
