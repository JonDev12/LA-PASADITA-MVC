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

    public function GetAllCategories(){
        try {
            $query = "SELECT IdCategorias, Descripcion, DATE(Fecha_Creacion) AS Fecha_Creacion FROM categorias";
            $stmt = $this->db->prepare($query);
            $stmt->execute();
            $result = $stmt->get_result();
            if ($result->num_rows > 0) {
                // Generate table body
                $tableBody = '';
                while ($row = $result->fetch_assoc()) {
                    $tableBody .= '<tr>';
                    $tableBody .= '<td class="text-center">' . $row['IdCategorias'] . '</td>';
                    $tableBody .= '<td class="text-center">' . $row['Descripcion'] . '</td>';
                    $tableBody .= '<td class="text-center">' . $row['Fecha_Creacion'] . '</td>';
                    $tableBody .=   "<td class='text-center'>
                                        <div class='text-center'>
                                            <button type='button' class='btn btn-primary' data-bs-toggle='modal' data-bs-target='#ModalCatUp' onclick='GetCategory(" . $row['IdCategorias'] . ")'>
                                                <i class='bi bi-pencil-square'></i>
                                            </button>
                                            <button type='button' class='btn btn-danger' data-bs-toggle='modal' data-bs-target='#ModalCatDe' onclick='GetCategory(" . $row['IdCategorias'] . ")'>
                                                <i class='bi bi-trash'></i>
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
