<?php
require_once '../Model/Connection.php';
require_once '../fpdf/fpdf.php';

class ModelAlmacen{
    private $db;

    public function __construct($con) {
        $this->db = $con->getConnection();
    }

    public function GetAllAlmacen() {
        try {
            $query = "SELECT IdAlmacen, Descripcion, Total, Diponibles, Defectuosos FROM almacen";
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
$modelalm = new ModelAlmacen($con);

// Obtener todas las ventas
$alm = $modelalm->GetAllAlmacen();

// Crear una instancia de FPDF
$pdf = new FPDF('P', 'mm', 'A4');

// Agregar una página
$pdf->AddPage();

// Agregar el logo (ajusta la ruta según tu estructura de archivos)
$pdf->Image('../images/LogoLaPasadita.png', 10, 10, 30); // (ruta, posición x, posición y, tamaño)
$pdf->Image('../images/LogoLaPasadita.png', 167, 10, 30);
// Mover el cursor a la derecha para dejar espacio para el logo
$pdf->SetY(20); // Ajusta la posición Y según sea necesario


// Títulos y Encabezados
$pdf->SetFont('helvetica', 'B', 14);
$pdf->Cell(0, 10, 'Reporte de Almacen', 0, 1, 'C');
$pdf->Ln(10);


// Posicionar la tabla centrada
$pos_x = ($pdf->GetPageWidth() - 145) / 2;
$pdf->SetX($pos_x);

// Establecer colores para encabezados
$pdf->SetFillColor(254, 198, 255); // Color de fondo (RGB)
$pdf->SetTextColor(0, 0, 0); // Color del texto (negro)
$pdf->SetDrawColor(50, 50, 100); // Color del borde (RGB)

$pdf->SetFont('courier', 'B', 11);
$pdf->Cell(20, 10, 'Id', 1, 0, 'C', true);
$pdf->Cell(45, 10, 'Descripcion', 1, 0, 'C', true);
$pdf->Cell(25, 10, 'Total', 1, 0, 'C', true);
$pdf->Cell(30, 10, 'Disponibles', 1, 0, 'C', true);
$pdf->Cell(30, 10, 'Defectuosos', 1, 1, 'C', true);

// Datos de Ventas
$pdf->SetFont('courier', '', 11);
foreach ($alm as $row) {
    $pdf->SetX($pos_x);
    $pdf->Cell(20, 10, $row['IdAlmacen'], 1, 0, 'C');
    $pdf->Cell(45, 10, $row['Descripcion'], 1, 0, 'C');
    $pdf->Cell(25, 10, $row['Total'], 1, 0, 'C');
    $pdf->Cell(30, 10, $row['Diponibles'], 1, 0, 'C');
    $pdf->Cell(30, 10, $row['Defectuosos'], 1, 1, 'C');
}

// Salida del PDF
$pdf->Output('I', 'reporte_almacen.pdf');


?>