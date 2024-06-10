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
                                            <button type='button' class='btn btn-primary edit-btn' data-bs-toggle='modal' data-bs-target='#ModalPlaUp' data-id='" . $row['IdPLatillos'] . "' data-descripcion='" . $row['Descripcion'] . "'>
                                                <i class='bi bi-pencil-square'></i>
                                            </button>
                                            <button type='button' class='btn btn-danger delete-btn' data-bs-toggle='modal' data-bs-target='#ModalPlaDe' data-id='" . $row['IdPLatillos'] . "'>
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

    public function GetAllCategories(){
        try {
            $query = "SELECT Descripcion FROM categorias";
            $stmt = $this->db->prepare($query);
            $stmt->execute();
            $result = $stmt->get_result();
            if ($result->num_rows > 0) {
                $tableBody = '';
                while ($row = $result->fetch_assoc()) {
                    $tableBody .= '<option>' . $row['Descripcion'] . '</option>';
                }
                return $tableBody;
            } else {
                return '<option value="0">No hay categorias</option>';
            }
        } catch (Exception $e) {
            echo "<script>alert('Error: " . $e->getMessage() . "');</script>";
        }
    }

    public function deletePlatillo($id){
        try {
            $query = "DELETE FROM platillos WHERE IdPLatillos = ?";
            $stmt = $this->db->prepare($query);
            $stmt->bind_param("i", $id);
            $stmt->execute();
            return true; // Éxito
        } catch (Exception $e) {
            echo "<script>alert('Error al eliminar el ingrediente " . $e->getMessage() . "');</script>";
            return false; // Error
        }
    }

    public function updatePlatillo($id, $descripcion, $cantidad){
        try {
            $query = "UPDATE platillos SET Descripcion = ?, Cantidad = ? WHERE IdIngredientes = ?";
            $stmt = $this->db->prepare($query);
            $stmt->bind_param("ssi", $descripcion, $cantidad, $id);
            $stmt->execute();
            return true; // Éxito
        } catch (Exception $e) {
            echo "<script>alert('Error al editar el ingrediente: " . $e->getMessage() . "');</script>";
            return false; // Error
        }
    }
}
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $menu = new ModelSaurces(new Connection());
    if (isset($_POST['edit_Platillo'])) {
        $id = $_POST['id'];
        $descripcion = $_POST['descripcion'];
        $cantidad = $_POST['cantidad'];
        $menu->updatePlatillo($id, $descripcion, $cantidad);
    } elseif (isset($_POST['delete_Platillo'])) {
        $id = $_POST['id'];
        $menu->deletePlatillo($id);
    }
    header('Location: ' . $_SERVER['PHP_SELF']); // Redirige después de editar o eliminar
    exit;
}
?>
