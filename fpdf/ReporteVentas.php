<?php
require_once '../Model/Connection.php';
require_once '../fpdf/fpdf.php';

class ModelSales {
    private $db;

    public function __construct($con) {
        $this->db = $con->getConnection();
    }

    public function getAllSales() {
        try {
            $query = "SELECT IdVentas, fecha, hora, cantidad, total FROM ventas";
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
$modelSales = new ModelSales($con);

// Obtener todas las ventas
$sales = $modelSales->getAllSales();

// Crear una instancia de FPDF
$pdf = new FPDF('P', 'mm', 'A4');

// Agregar una página
$pdf->AddPage();

// Títulos y Encabezados
$pdf->SetFont('helvetica', 'B', 14);
$pdf->Cell(0, 10, 'Reporte de Ventas', 0, 1, 'C');
$pdf->Ln(10);


// Posicionar la tabla centrada
$pos_x = ($pdf->GetPageWidth() - 140) / 2;
$pdf->SetX($pos_x);

$pdf->SetFont('courier', 'B', 12);
$pdf->Cell(25, 10, 'ID', 1, 0, 'C');
$pdf->Cell(30, 10, 'Fecha', 1, 0, 'C');
$pdf->Cell(30, 10, 'Hora', 1, 0, 'C');
$pdf->Cell(25, 10, 'Cantidad', 1, 0, 'C');
$pdf->Cell(30, 10, 'Total', 1, 1, 'C');

// Datos de Ventas
$pdf->SetFont('courier', '', 12);
foreach ($sales as $row) {
    $pdf->SetX($pos_x);
    $pdf->Cell(25, 10, $row['IdVentas'], 1, 0, 'C');
    $pdf->Cell(30, 10, $row['fecha'], 1, 0, 'C');
    $pdf->Cell(30, 10, $row['hora'], 1, 0, 'C');
    $pdf->Cell(25, 10, $row['cantidad'], 1, 0, 'C');
    $pdf->Cell(30, 10, $row['total'], 1, 1, 'C');
}

// Salida del PDF
$pdf->Output('I', 'reporte_ventas.pdf');


?>