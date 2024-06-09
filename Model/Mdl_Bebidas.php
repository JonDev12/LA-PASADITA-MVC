<?php

require_once '../Model/Connection.php';
require_once '../fpdf/fpdf.php';

class ModelBebidas
{
    private $db;

    public function __construct($con)
    {
        $this->db = $con->getConnection();
    }

    public function GetAllBebidas()
    {
        try {
            $query = "SELECT IdBebidas, Descripcion, Cantidad_ML, Cantidad, Precio FROM bebidas";
            $stmt = $this->db->prepare($query);
            $stmt->execute();
            $result = $stmt->get_result();
            if ($result->num_rows > 0) {
                $tableBody = '';
                while ($row = $result->fetch_assoc()) {
                    $tableBody .= '<tr>';
                    $tableBody .= '<td class="text-center">' . $row['IdBebidas'] . '</td>';
                    $tableBody .= '<td class="text-center">' . $row['Descripcion'] . '</td>';
                    $tableBody .= '<td class="text-center">' . $row['Cantidad_ML'] . '</td>';
                    $tableBody .= '<td class="text-center">' . $row['Cantidad'] . '</td>';
                    $tableBody .= '<td class="text-center">' . $row['Precio'] . '</td>';
                    $tableBody .= '<td class="text-center">
                                        <div class="text-center">
                                            <button class="btn btn-primary edit-bebida-btn" data-id="' . $row['IdBebidas'] . '" data-descripcion="' . $row['Descripcion'] . '" data-cantidad_ml="' . $row['Cantidad_ML'] . '" data-cantidad="' . $row['Cantidad'] . '" data-precio="' . $row['Precio'] . '" data-bs-toggle="modal" data-bs-target="#modalEditBeb">
                                                <i class="bi bi-pencil-square"></i>
                                            </button>
                                            <button class="btn btn-danger delete-bebida-btn" data-id="' . $row['IdBebidas'] . '" data-bs-toggle="modal" data-bs-target="#modalDeBebDe">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </div>
                                    </td>';
                    $tableBody .= '</tr>';
                }
                return $tableBody;
            } else {
                return '
                        <tr class="text-center">
                            <td colspan="7" class="text-center">
                                <h7 class="text-center">No hay datos aun</h7>
                            </td>
                        </tr>';
            }
        } catch (Exception $e) {
            echo "<script>alert('Error: " . $e->getMessage() . "');</script>";
        }
    }

    public function EditBebida($id, $descripcion, $cantidad_ml, $cantidad, $precio)
    {
        try {
            $query = "UPDATE bebidas SET Descripcion = ?, Cantidad_ML = ?, Cantidad = ?, Precio = ? WHERE IdBebidas = ?";
            $stmt = $this->db->prepare($query);
            $stmt->bind_param("ssiii", $descripcion, $cantidad_ml, $cantidad, $precio, $id);
            $stmt->execute();
        } catch (Exception $e) {
            echo "<script>alert('Error: " . $e->getMessage() . "');</script>";
        }
    }

    public function DeleteBebida($id)
    {
        try {
            $query = "DELETE FROM bebidas WHERE IdBebidas = ?";
            $stmt = $this->db->prepare($query);
            $stmt->bind_param("i", $id);
            $stmt->execute();
        } catch (Exception $e) {
            echo "<script>alert('Error: " . $e->getMessage() . "');</script>";
        }
    }
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $con = new Connection();
    $modelBebidas = new ModelBebidas($con);

    if (isset($_POST['edit_bebida'])) {
        $id = $_POST['id'];
        $descripcion = $_POST['descripcion'];
        $cantidad_ml = $_POST['cantidad_ml'];
        $cantidad = $_POST['cantidad'];
        $precio = $_POST['precio'];
        $modelBebidas->EditBebida($id, $descripcion, $cantidad_ml, $cantidad, $precio);
    } elseif (isset($_POST['delete_bebida'])) {
        $id = $_POST['id'];
        $modelBebidas->DeleteBebida($id);
    }
    header('Location: ' . $_SERVER['PHP_SELF']); 
    exit;
}
?>
