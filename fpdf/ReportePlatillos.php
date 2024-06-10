<?php
require_once '../Model/Connection.php';
require_once '../fpdf/fpdf.php';

class ModelPlatillos{
    private $db;

    public function __construct($con) {
        $this->db = $con->getConnection();
    }

    public function GetAllPlatillos() {
        try {
            $query = "SELECT IdPLatillos, Descripcion, Precio, ImagenPlatillo, FechaCreacion FROM platillos";
            $stmt = $this->db->prepare($query);
            $stmt->execute();
            $result = $stmt->get_result();
            return $result->fetch_all(MYSQLI_ASSOC);
        } catch (Exception $e) {
            echo "<script>alert('Error: " . $e->getMessage() . "');</script>";
            return [];
        }
    }
}

// Crear una conexión
$con = new Connection();
$modelpla = new ModelPlatillos($con);

// Obtener todas las ventas
$pla = $modelpla->GetAllPlatillos();

// Crear una instancia de FPDF
$pdf = new FPDF('P', 'mm', 'A4');

// Agregar una página
$pdf->AddPage();
$pdf->Image('../images/LogoLaPasadita.png', 15, 10, 30); // (ruta, posición x, posición y, tamaño)
$pdf->Image('../images/LogoLaPasadita.png', 165, 10, 30);
// Títulos y Encabezados
$pdf->SetFont('helvetica', 'B', 14);
$pdf->Cell(0, 30, 'Reporte de Platillos', 0, 1, 'C');
$pdf->Ln(5);


// Posicionar la tabla centrada
$pos_x = ($pdf->GetPageWidth() - 170) / 2;
$pdf->SetX($pos_x);

// Establecer colores para encabezados
$pdf->SetFillColor(216, 255, 217); // Color de fondo (RGB)
$pdf->SetTextColor(0, 0, 0); // Color del texto (negro)
$pdf->SetDrawColor(50, 50, 100); // Color del borde (RGB)

$pdf->SetFont('courier', 'B', 12);
$pdf->Cell(25, 10, 'Id', 1, 0, 'C', true);
$pdf->Cell(40, 10, 'Descipcion', 1, 0, 'C', true);
$pdf->Cell(20, 10, 'Precio', 1, 0, 'C', true);
$pdf->Cell(45, 10, 'Imagen', 1, 0, 'C', true);
$pdf->Cell(40, 10, 'Fecha', 1, 1, 'C', true);

// Datos de Ventas
$pdf->SetFont('courier', '', 12);
foreach ($pla as $row) {
    $pdf->SetX($pos_x);
    $pdf->Cell(25, 10, $row['IdPLatillos'], 1, 0, 'C');
    $pdf->Cell(40, 10, $row['Descripcion'], 1, 0, 'C');
    $pdf->Cell(20, 10, $row['Precio'], 1, 0, 'C');
    $pdf->Cell(45, 10, $row['ImagenPlatillo'], 1, 0, 'C');
    $pdf->Cell(40, 10, $row['FechaCreacion'], 1, 1, 'C');
}

// Salida del PDF
$pdf->Output('I', 'reporte_platillos.pdf');


?>