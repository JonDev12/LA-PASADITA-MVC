<?php
require_once '../Model/Connection.php';

class ModelCategories {
    private $db;

    public function __construct($con) {
        $this->db = $con->getConnection();
    }

    public function EditCategory($id, $descripcion) {
        try {
            $query = "UPDATE categorias SET Descripcion = ? WHERE IdCategorias = ?";
            $stmt = $this->db->prepare($query);
            $stmt->bind_param("si", $descripcion, $id);
            $stmt->execute();
            return true; // Éxito
        } catch (Exception $e) {
            echo "<script>alert('Error al editar la categoría: " . $e->getMessage() . "');</script>";
            return false; // Error
        }
    }

    public function DeleteCategory($id) {
        try {
            $query = "DELETE FROM categorias WHERE IdCategorias = ?";
            $stmt = $this->db->prepare($query);
            $stmt->bind_param("i", $id);
            $stmt->execute();
            return true; // Éxito
        } catch (Exception $e) {
            echo "<script>alert('Error al eliminar la categoría: " . $e->getMessage() . "');</script>";
            return false; // Error
        }
    }

    public function GetAllCategories() {
        try {
            $query = "SELECT IdCategorias, Descripcion, DATE(Fecha_Creacion) AS Fecha_Creacion FROM categorias";
            $stmt = $this->db->prepare($query);
            $stmt->execute();
            $result = $stmt->get_result();
            if ($result->num_rows > 0) {
                $tableBody = '';
                while ($row = $result->fetch_assoc()) {
                    $tableBody .= '<tr>';
                    $tableBody .= '<td class="text-center">' . $row['IdCategorias'] . '</td>';
                    $tableBody .= '<td class="text-center">' . $row['Descripcion'] . '</td>';
                    $tableBody .= '<td class="text-center">' . $row['Fecha_Creacion'] . '</td>';
                    $tableBody .=   "<td class='text-center'>
                                        <div class='text-center'>
                                            <button type='button' class='btn btn-primary edit-btn' data-bs-toggle='modal' data-bs-target='#ModalCatUp' data-id='" . $row['IdCategorias'] . "' data-descripcion='" . $row['Descripcion'] . "'>
                                                <i class='bi bi-pencil-square'></i>
                                            </button>
                                            <button type='button' class='btn btn-danger delete-btn' data-bs-toggle='modal' data-bs-target='#ModalCatDe' data-id='" . $row['IdCategorias'] . "'>
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

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $menu = new ModelCategories(new Connection());
    if (isset($_POST['edit_category'])) {
        $id = $_POST['id'];
        $descripcion = $_POST['descripcion'];
        $menu->EditCategory($id, $descripcion);
    } elseif (isset($_POST['delete_category'])) {
        $id = $_POST['id'];
        $menu->DeleteCategory($id);
    }
    header('Location: ' . $_SERVER['PHP_SELF']); // Redirige después de editar o eliminar
    exit;
}
?>
