<?php

require_once '../Model/Connection.php';

class ModelIngredients{
    private $db;
    public function __construct($con){
        $this->db = $con->getConnection();        
    }

    public function GetAllIngredients()
    {
        try {
            $query = "SELECT Descripcion, Cantidad, U_Medida FROM Ingredientes";
            $stmt = $this->db->prepare($query);
            $stmt->execute();
            $result = $stmt->get_result();
            if ($result->num_rows > 0) {
                // Generate table body
                $tableBody = '';
                while ($row = $result->fetch_assoc()) {
                    $tableBody .= '<tr>';
                    $tableBody .= '<td>' . $row['Descripcion'] . '</td>';
                    $tableBody .= '<td>' . $row['Cantidad'] . '</td>';
                    $tableBody .= '<td>' . $row['Unidad Medida'] . '</td>';
                    $tableBody .=   "<td class='text-center'>
                                        <div class='text-center'>
                                            <button href='#' style='width: 40px; height: 40px;border-radius: 10px; background-color: #d9e3eb;'>
                                                <i class='bi bi-pen-fill'></i>
                                            </button>
                                            <button href='#' style='width: 40px; height: 40px;border-radius: 10px; background-color: red;'>
                                                <i class='bi bi-trash3-fill'></i>
                                            </button>
                                        </div>
                                    </td>";
                    $tableBody .= '</tr>';
                }
                return $tableBody;
            } else {
                return '
                        <tr class="text-center">
                            <td colspan="4" class="text-center">
                                <h7 class="text-center">No hay datos aun</h7>
                            </td>
                        </tr>';
            }
        } catch (Exception $e) {
            echo "<script>alert('Error: " . $e->getMessage() . "');</script>";
        }
    }
}