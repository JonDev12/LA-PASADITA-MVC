<?php

require_once '../Model/Connection.php';

class ModelCategories
{
    private $db;

    public function __construct($con)
    {
        // Asigna la conexión a $this->db
        $this->db = $con->getConnection();
    }

    public function GetAllCategories()
    {
        try {
            $query = "SELECT IdCategorias, Descripcion, Fecha_Creacion FROM categorias";
            $stmt = $this->db->prepare($query);
            $stmt->execute();
            $result = $stmt->get_result();
            if ($result->num_rows > 0) {
                // Generate table body
                $tableBody = '';
                while ($row = $result->fetch_assoc()) {
                    $tableBody .= '<tr>';
                    $tableBody .= '<td class="text-center">' . $row['IdCategorias'] . '</td>';
                    $tableBody .= '<td>' . $row['Descripcion'] . '</td>';
                    $tableBody .= '<td>' . $row['Fecha_Creacion'] . '</td>';
                    $tableBody .=   "<td class='text-center'>
                                        <div class='text-center'>
                                            <button data-bs-target='modalIngEd' style='width: 40px; height: 40px;border-radius: 10px; background-color: #d9e3eb;'>
                                                <i class='bi bi-pen-fill'></i>
                                            </button>
                                            <button data-bs-target='modalIngDe' style='width: 40px; height: 40px;border-radius: 10px; background-color: red;'>
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
