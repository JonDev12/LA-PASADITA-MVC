<?php

require_once '../Model/Connection.php';

class ModelIngredients{
    private $db;
    public function __construct($con){
        $this->db = $con->getConnection();        
    }

    public function GetAllIngredients(){
        try {
            $query = "SELECT IdIngredientes, Descripcion, Cantidad, U_Medida FROM ingredientes";
            $stmt = $this->db->prepare($query);
            $stmt->execute();
            $result = $stmt->get_result();
            if ($result->num_rows > 0) {
                // Generate table body
                $tableBody = '';
                while ($row = $result->fetch_assoc()) {
                    $tableBody .= '<tr>';
                    $tableBody .= '<td>' . $row['IdIngredientes'] . '</td>';
                    $tableBody .= '<td class="text-center">' . $row['Descripcion'] . '</td>';
                    $tableBody .= '<td class="text-center">' . $row['Cantidad'] . '</td>';
                    $tableBody .= '<td class="text-center">' . $row['U_Medida'] . '</td>';
                    $tableBody .=   "<td class='text-center'>
                                        <div class='text-center'>
                                            <button type='button' class='btn btn-primary edit-btn' data-bs-toggle='modal' data-bs-target='#modalIngEd' data-id='" . $row['IdIngredientes'] . "' data-descripcion='" . $row['Descripcion'] . "' data-cantidad='" . $row['Cantidad'] . "'>
                                                <i class='bi bi-pencil-square'></i>
                                            </button>
                                            <button type='button' class='btn btn-danger delete-btn' data-bs-toggle='modal' data-bs-target='#modalIngDe' data-id='" . $row['IdIngredientes'] . "'>
                                                <i class='bi bi-trash-fill'></i>
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

    public function ShowUnit(){
        try{
            $sql = "SELECT DISTINCT U_Medida FROM Ingredientes";
            $stmt = $this->db->prepare($sql);
            $stmt->execute();
            $result = $stmt->get_result();
            if($result->num_rows > 0){
                $data = '';
                while($row = $result->fetch_assoc()){
                    $data .= '<option value="' . $row['U_Medida'] . '">' . $row['U_Medida'] . '</option>';
                }
                return $data;
            } else {
                return '<option>No units found</option>';
            }
        } catch(Exception $e){
            echo "<script>alert('Error: " . $e->getMessage() . "');</script>";
        }
    }
    
    public function deleteIngrediente($id){
        try {
            $query = "DELETE FROM ingredientes WHERE IdIngredientes = ?";
            $stmt = $this->db->prepare($query);
            $stmt->bind_param("i", $id);
            $stmt->execute();
            return true; // Éxito
        } catch (Exception $e) {
            echo "<script>alert('Error al eliminar el ingrediente " . $e->getMessage() . "');</script>";
            return false; // Error
        }
    }

    public function updateIngrediente($id, $descripcion, $cantidad){
        try {
            $query = "UPDATE ingredientes SET Descripcion = ?, Cantidad = ? WHERE IdIngredientes = ?";
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
    $menu = new ModelIngredients(new Connection());
    if (isset($_POST['edit_Ingrediente'])) {
        $id = $_POST['id'];
        $descripcion = $_POST['descripcion'];
        $cantidad = $_POST['cantidad'];
        $menu->updateIngrediente($id, $descripcion, $cantidad);
    } elseif (isset($_POST['delete_Ingrediente'])) {
        $id = $_POST['id'];
        $menu->deleteIngrediente($id);
    }
    header('Location: ' . $_SERVER['PHP_SELF']); // Redirige después de editar o eliminar
    exit;
}