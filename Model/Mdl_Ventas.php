<?php

require_once '../Model/Connection.php';
require_once '../fpdf/fpdf.php';

class ModelSales{
    private $db;

    public function __construct($con){
        $this->db = $con->getConnection();
    }

    public function getAllSales(){
        try {
            $query = "SELECT IdVentas, fecha, hora, cantidad, total FROM ventas ORDER BY IdVentas DESC";
            $stmt = $this->db->prepare($query);
            $stmt->execute();   
            $result = $stmt->get_result();
            if ($result->num_rows > 0) {
                // Generate table body
                $tableBody = '';
                while ($row = $result->fetch_assoc()) {
                    $tableBody .= '<tr>';
                    $tableBody .= '<td class="text-center">' . $row['IdVentas'] . '</td>';
                    $tableBody .= '<td class="text-center">' . $row['fecha'] . '</td>';
                    $tableBody .= '<td class="text-center">' . $row['hora'] . '</td>';
                    $tableBody .= '<td class="text-center">' . $row['cantidad'] . '</td>';
                    $tableBody .= '<td class="text-center">' . $row['total'] . '</td>';
                    $tableBody .= '<td>
                                    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalRegistroEd">
                                        <i class="bi bi-pencil-square"></i>
                                    </button>
                                    <button class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#modalRegistroDe">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </td>';
                    $tableBody .= '</tr>';
                }
                return $tableBody;
            } else {
                return '
                        <tr class="text-center">
                            <td colspan="6" class="text-center">
                                <h7 class="text-center">Sin datos que mostrar</h7>
                            </td>
                        </tr>';
            }
        } catch (Exception $e) {
            echo "<script>alert('Error: " . $e->getMessage() . "');</script>";
        }    
    }

    public function GenPDF(){
        echo '<div  align="center" >
                <a  href= "../fpdf/ReporteVentas.php" target = "_blank">
                    Obtener Reporte
                    </div>';
        
    }
}