<?php

require_once '../Model/Connection.php';
require_once '../fpdf/fpdf.php';
class ModelAlmacen
{
    private $db;

    public function __construct($con) {
        $this->db = $con->getConnection();
    }

    public function EditItem($id, $descripcion, $total, $disponibles, $defectuosos) {
        try {
            $query = "UPDATE Almacen SET Descripcion = ?, Total = ?, Diponibles = ?, Defectuosos = ? WHERE IdAlmacen = ?";
            $stmt = $this->db->prepare($query);
            $stmt->bind_param("siiii", $descripcion, $total, $disponibles, $defectuosos, $id);
            $stmt->execute();
            return true; // Éxito
        } catch (Exception $e) {
            echo "<script>alert('Error al editar el item: " . $e->getMessage() . "');</script>";
            return false; // Error
        }
    }

    public function DeleteItem($id) {
        try {
            $query = "DELETE FROM Almacen WHERE IdAlmacen = ?";
            $stmt = $this->db->prepare($query);
            $stmt->bind_param("i", $id);
            $stmt->execute();
            return true; // Éxito
        } catch (Exception $e) {
            echo "<script>alert('Error al eliminar el item: " . $e->getMessage() . "');</script>";
            return false; // Error
        }
    }

    public function GetAllItems() {
        try {
            $query = "SELECT IdAlmacen, Descripcion, Total, Diponibles, Defectuosos FROM Almacen";
            $stmt = $this->db->prepare($query);
            $stmt->execute();
            $result = $stmt->get_result();
            if ($result->num_rows > 0) {
                $tableBody = '';
                while ($row = $result->fetch_assoc()) {
                    $tableBody .= '<tr>';
                    $tableBody .= '<td class="text-center">' . $row['IdAlmacen'] . '</td>';
                    $tableBody .= '<td class="text-center">' . $row['Descripcion'] . '</td>';
                    $tableBody .= '<td class="text-center">' . $row['Total'] . '</td>';
                    $tableBody .= '<td class="text-center">' . $row['Diponibles'] . '</td>';
                    $tableBody .= '<td class="text-center">' . $row['Defectuosos'] . '</td>';
                    $tableBody .=   "<td class='text-center'>
                                        <div class='text-center'>
                                            <button type='button' class='btn btn-primary edit-item-btn' data-bs-toggle='modal' data-bs-target='#modalAlmEd' data-id='" . $row['IdAlmacen'] . "' data-descripcion='" . $row['Descripcion'] . "' data-total='" . $row['Total'] . "' data-disponibles='" . $row['Diponibles'] . "' data-defectuosos='" . $row['Defectuosos'] . "'>
                                                <i class='bi bi-pencil-square'></i>
                                            </button>
                                            <button type='button' class='btn btn-danger delete-item-btn' data-bs-toggle='modal' data-bs-target='#modalAlmDe' data-id='" . $row['IdAlmacen'] . "'>
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
                            <td colspan="5" class="text-center">
                                <h7 class="text-center">No hay datos aun</h7>
                            </td>
                        </tr>';
            }
        } catch (Exception $e) {
            echo "<script>alert('Error: " . $e->getMessage() . "');</script>";
        }
    }
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $modelItems = new ModelAlmacen(new Connection());
    if (isset($_POST['edit_item'])) {
        $id = $_POST['id'];
        $descripcion = $_POST['descripcion'];
        $total = $_POST['total'];
        $disponibles = $_POST['disponibles'];
        $defectuosos = $_POST['defectuosos'];
        $modelItems->EditItem($id, $descripcion, $total, $disponibles, $defectuosos);
    } elseif (isset($_POST['delete_item'])) {
        $id = $_POST['id'];
        $modelItems->DeleteItem($id);
    }
    header('Location: ' . $_SERVER['PHP_SELF']); // Redirige después de editar o eliminar
    exit;
}
