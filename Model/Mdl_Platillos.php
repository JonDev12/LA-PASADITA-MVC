<?php

require_once '../Model/Connection.php';

class ModelSaurces {
    private $db;

    public function __construct($con) {
        $this->db = $con->getConnection();
    }

    public function GetAllSources() {
        try {
            $query = "SELECT IdPLatillos, Descripcion, FechaCreacion FROM platillos";
            $stmt = $this->db->prepare($query);
            $stmt->execute();
            $result = $stmt->get_result();
            if ($result->num_rows > 0) {
                $tableBody = '';
                while ($row = $result->fetch_assoc()) {
                    $tableBody .= '<tr>';
                    $tableBody .= '<td class="text-center">' . $row['IdPLatillos'] . '</td>';
                    $tableBody .= '<td class="text-center">' . $row['Descripcion'] . '</td>';
                    $tableBody .= '<td class="text-center">' . $row['FechaCreacion'] . '</td>';
                    $tableBody .=   "<td class='text-center'>
                                        <div class='text-center'>
                                            <button type='button' class='btn btn-primary edit-btn' data-bs-toggle='modal' data-bs-target='#ModalCatUp' data-id='" . $row['IdPLatillos'] . "' data-descripcion='" . $row['Descripcion'] . "'>
                                                <i class='bi bi-pencil-square'></i>
                                            </button>
                                            <button type='button' class='btn btn-danger delete-btn' data-bs-toggle='modal' data-bs-target='#ModalCatDe' data-id='" . $row['IdPLatillos'] . "'>
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
?>
