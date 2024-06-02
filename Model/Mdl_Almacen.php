<?php

require_once '../Model/Connection.php';

class ModelAlmacen
{
    private $db;

    public function __construct($con)
    {
        // Asigna la conexión a $this->db
        $this->db = $con->getConnection();
    }

    public function GetAllAlmacen()
    {
        try {
            $query = "SELECT IdAlmacen, Descripcion, Total, Disponibles, Defectuosos FROM almacen";
            $stmt = $this->db->prepare($query);
            $stmt->execute();
            $result = $stmt->get_result();
            if ($result->num_rows > 0) {
                // Generate table body
                $tableBody = '';
                while ($row = $result->fetch_assoc()) {
                    $tableBody .= '<tr>';
                    $tableBody .= '<td class="text-center">' . $row['IdAlmacen'] . '</td>';
                    $tableBody .= '<td class="text-center">' . $row['Descripcion'] . '</td>';
                    $tableBody .= '<td class="text-center">' . $row['Total'] . '</td>';
                    $tableBody .= '<td class="text-center">' . $row['Disponibles'] . '</td>';
                    $tableBody .= '<td class="text-center">' . $row['Defectuosos'] . '</td>';
                    $tableBody .=   "<td class='text-center'>
                                        <div class='text-center'>
                                                <button class='btn btn-primary' data-bs-toggle='modal' data-bs-target='#ModalBebEd'>
                                                <i class='bi bi-pencil-square'></i>
                                            </button>
                                            <button class='btn btn-danger' data-bs-toggle='modal' data-bs-target='#ModalBebDe'>
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
