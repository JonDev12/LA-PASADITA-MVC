<?php
require_once '../Model/Connection.php';
require_once '../fpdf/fpdf.php';

class ModelIngredientes{
    private $db;

    public function __construct($con) {
        $this->db = $con->getConnection();
    }

    public function GetAllIngredients() {
        try {
            $query = "SELECT IdIngredientes, Descripcion, Cantidad, U_Medida, IdAlmacen FROM ingredientes";
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
$modeling = new ModelIngredientes($con);

// Obtener todas las ventas
$ing = $modeling->GetAllIngredients();

// Crear una instancia de FPDF
$pdf = new FPDF('P', 'mm', 'A4');

// Agregar una página
$pdf->AddPage();

// Títulos y Encabezados
$pdf->SetFont('helvetica', 'B', 14);
$pdf->Cell(0, 10, 'Reporte de Ingredientes', 0, 1, 'C');
$pdf->Ln(10);


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
$pdf->Cell(30, 10, 'Cantidad', 1, 0, 'C', true);
$pdf->Cell(45, 10, 'Unidad de medida', 1, 0, 'C', true);
$pdf->Cell(30, 10, 'Id Almacen', 1, 1, 'C', true);

// Datos de Ventas
$pdf->SetFont('courier', '', 12);
foreach ($ing as $row) {
    $pdf->SetX($pos_x);
    $pdf->Cell(25, 10, $row['IdIngredientes'], 1, 0, 'C');
    $pdf->Cell(40, 10, $row['Descripcion'], 1, 0, 'C');
    $pdf->Cell(30, 10, $row['Cantidad'], 1, 0, 'C');
    $pdf->Cell(45, 10, $row['U_Medida'], 1, 0, 'C');
    $pdf->Cell(30, 10, $row['IdAlmacen'], 1, 1, 'C');
}

// Salida del PDF
$pdf->Output('I', 'reporte_ingredientes.pdf');


?>